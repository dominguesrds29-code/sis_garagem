<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use GuzzleHttp\Psr7\Request;

abstract class ServiceExternalApi
{
    // Object Client do Guzzle
    protected $client;
    // Header usado em todas as chamadas de api
    private $header = NULL;
    // Resultado da api
    protected $result;
    // mensagem de erro que ocorrer ao acessar api
    private $hasError = false;
    // tem resposta no erro dado
    private $hasResponse = false;
    // messagem de erro ao acessar a resposta da api
    private $messageError;
    // token de acesso
    private $token;
    // tempo de expiração do token
    private $expToken;
    // tipo do token
    private $typeToken;
    // validador de certificados SSL
    protected $verifySSL = false;

    // url base do serviço
    abstract protected function getUri();

    // rota de acesso a api
    abstract protected function getRoute();

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return Boolean
     */
    public function hasError() : bool
    {
        return $this->hasError;
    }

    /**
     * @return String
     */
    public function getMessageError() : String
    {
        return $this->messageError;
    }

    /**
     * @param mixed $messageError
     */
    public function setMessageError($messageError): void
    {
        $this->messageError = $messageError;
    }

    /**
     * @return Boolean
     */
    public function hasResponse() : bool
    {
        return $this->hasResponse;
    }

    public function sendPostInJson(Array $params)
    {
        $request = new Request(
            'POST',
            $this->getUri() . $this->getRoute(),
            [
                "content-type" => 'application/json',
            ],
            json_encode($params)
        );
        $this->result = $this->client->send($request, ['verify' => $this->verifySSL]);
        $this->hasResponse = true;
        return $this->getResponse();
    }

    public function post(Array $params, Array $multipart = []) : String
    {
        try{
            $config = [
                'form_params' => $params,
                'verify' => $this->verifySSL
            ];
            if($this->header) {
                $config['headers'] = $this->header;
            }
            if($multipart) {
                $config['multipart'] = $multipart;
                unset($config['form_params']);
            }
            /*
            Log::info('===============================');
            Log::info('Disparando para a URL: ' . $this->getUri() . $this->getRoute());
            Log::info('Método: POST');
            Log::info('Form Params/header: ');
            Log::info($config);
            Log::info('===============================');
            */
            $this->result = $this->client->request('POST', $this->getUri() . $this->getRoute(), $config);
            $this->hasResponse = true;
            return $this->getResponse();
        } catch (RequestException $e) {
            $this->hasError = true;
            if ($e->hasResponse()) {
                $this->hasResponse = true;
                $this->messageError = $e->getResponse()->getBody()->getContents();
                return false;
            }
            Log::error($e->getMessage());
            $this->messageError = 'Erro interno do servidor';
            return false;
        }
    }

    public function get(Array $params = null, bool $httpBuildQuery = false) : String
    {
        try {
            $paramsGet = '';
            if($params && $httpBuildQuery) {
                $paramsGet .= '?' . http_build_query($params);
            }
            if($params && !$httpBuildQuery) {
                $paramsGet .= '/' . implode('/', $params);
            }
            /*
            Log::info('===============================');
            Log::info('Disparando para a URL: ' . $this->getUri() . $this->getRoute());
            Log::info('Método: GET');
            Log::info('Parametros GET: ');
            Log::info($paramsGet);
            Log::info('HEADER: ');
            Log::info($this->header);
            Log::info('===============================');
            */
            $this->result = $this->client->request('GET',$this->getUri() . $this->getRoute() . $paramsGet, [
                'verify' => $this->verifySSL,
                'headers' => $this->header
            ]);

            return $this->getResponse();
        } catch (RequestException $e) {
            $this->hasError = true;
            Log::error($e->getMessage());
            $this->messageError = 'Erro interno do servidor';
            return false;
        }
    }

    public function getInJson(Array $params = null, bool $httpBuildQuery = false)
    {
        $response = $this->get($params, $httpBuildQuery);
        return json_decode($response);
    }

    public function postInJson(Array $params, Array $multipart = [])
    {
        $response = $this->post($params, $multipart);
        return json_decode($response);
    }

    public function list(Array $params = null) : array
    {
        $dataApi = $this->get($params);
        if(!$this->hasNotErrorInResponse()) {
            throw new \Exception($this->getMessageError());
        }
        $data = json_decode($dataApi);
        if(!$this->hasNotMessageError($data))
        {
            throw new \Exception($this->getMessageError());
        }
        return $data->data;
    }

    private function getResponse()
    {
        return $this->result->getBody()->getContents();
    }

    /**
     * @return String
     */
    public function getToken() : String
    {
        return $this->token;
    }

    /**
     * @return String
     */
    public function getExpToken() : String
    {
        return $this->expToken;
    }

    /**
     * @return mixed
     */
    public function getTypeToken() : String
    {
        return $this->typeToken;
    }

    private function hasNotErrorInResponse() : bool
    {
        if($this->hasError()) {
            if($this->hasResponse()) {
                $messageError = json_decode($this->getMessageError());
                $this->setMessageError($messageError->message);
                return false;
            }
            return false;
        }
        return true;
    }

    private function hasNotMessageError($data) : bool
    {
        if(!$data->status)
        {
            $this->setMessageError($data->message);
            return false;
        }
        return true;
    }

    public function auth(Array $params) : String
    {
        $dataApi = $this->post($params);
        if(!$this->hasNotErrorInResponse()) {
            return false;
        }
        $data = json_decode($dataApi);
        if(!$this->hasNotMessageError($data))
        {
            return false;
        }
        $this->token = $data->data->access_token;
        $this->typeToken = $data->data->token_type;
        $this->expToken = $data->data->expires_in;
        return true;
    }

    public function generatedToken() : ServiceExternalApi
    {
        $token = JWTAuth::fromUser(auth()->user());
        $this->header = ['Authorization' => 'Bearer ' . $token];
        return $this;
    }
}
