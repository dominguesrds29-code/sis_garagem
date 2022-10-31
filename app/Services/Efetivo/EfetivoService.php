<?php

namespace App\Services\Efetivo;

use App\Services\ServiceExternalApi;

abstract class EfetivoService extends ServiceExternalApi
{
    protected function getUri() {
        return "https://10.132.19.21/efetivosj/public";
    }
}
