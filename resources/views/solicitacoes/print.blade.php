<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitação de Viatura - DTCEA-SJ</title>
    <style>
        body {
            margin-bottom: 1cm;
            margin-left: 1cm;
            font-size: 11pt;
            font-family: 'Times', sans-serif;
        }

        .header-report p {
            margin: 1mm;
            text-align: center;
        }

        p {
            margin: 1mm;
        }

        .border {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .brasaomd {
            border: none;
            width: 80px;
            height: 80px;
        }

        marker {
            position: fixed;
            bottom: 148.5mm;
            left: 0mm;
            height: 1px;
            border-bottom: 1px solid #000;
            width: 7mm;
        }

        .page-break { page-break-before: always; }

    </style>
</head>
<body>
<div class="header-report">
    @php
        $mdUrl = asset(url('assets/img/brasaomd.jpg'));
        $arrContextOptions=[
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ];

        $type = pathinfo($mdUrl, PATHINFO_EXTENSION);
        $mdData = file_get_contents($mdUrl, false, stream_context_create($arrContextOptions));
        $mdBase64Data = base64_encode($mdData);
        $imageData = 'data:image/jpeg;base64,' . $mdBase64Data;
    @endphp

    <p><img class="brasaomd" src="{{ $imageData }}"/></p>
    <p><strong>MINISTÉRIO DA DEFESA</strong></p>
    <p><strong>COMANDO DA AERONÁUTICA</strong></p>
    <p><u>CENTRO REGIONAL DE CONTROLE DO ESPAÇO AÉREO SUDESTE</u></p>
    <p>DESTACAMENTO DE CONTROLE DO ESPAÇO AÉREO DE SÃO JOSÉ DOS CAMPOS</p>
</div>
<div style='text-align: justify'>
    <p style="margin-top: .5cm;"><strong>Número:</strong> {{ $solicitacao->id }} / SITS / {{ date('Y') }}</p>
    <p><strong>Autorizo o motorista:</strong> {{ $motorista ? "{$motorista->name} {$motorista->grade} {$motorista->specialty}" : "Desconhecido [ID: {$solicitacao->motorista_id}]" }} </p>
    <p><strong>Portador da carteira de habilitação Nr:</strong> {{ $motorista ? $solicitacao->motorista->cnh_number : '--' }} </p>
    <p><strong>A sair com a viatura:</strong> {{ $solicitacao->viatura ? $solicitacao->viatura->modelo :
        "Desconhecida [ID: {$solicitacao->viatura_id}]"  }} </p>
    <p><strong>Para a cidade de:</strong> {{ $solicitacao->destino  }} </p>
    <p><strong>Às</strong> {{ $solicitacao->hora_inicio  }} hs <strong>do dia</strong> {{ $solicitacao->getFormatDate($solicitacao->dt_inicio) }}</p>
    <p><strong>Itinerário:</strong> {{ $solicitacao->itinerario }}</p>
    <p><strong>Especificação do Serviço:</strong> {{ $solicitacao->missao }}</p>
    <p><strong>Relação de Passageiros:</strong> {{ $solicitacao->passageiros }}</p>
    <p style="text-align: right; margin-top: 1cm;">São José dos Campos, {{ $solicitacao->getFormatDate(date('Y-m-d', strtotime($solicitacao->created_at))) }}</p>
    @if(auth()->check())
    <p style="margin-top: 2cm;">
        <table style="width: 100%;">
            <tr>
                <td style="border-bottom: 1px solid #000; width: 45%;"></td>
                <td style="width: 10%;"></td>
                <td style="border-bottom: 1px solid #000; width: 45%;"></td>
            </tr>
            <tr>
                <td style="text-align: center;"> {{ auth()->user()->name }} {{ auth()->user()->pst_specialty }} <br> Despachante da SITS</td>
                <td></td>
                <td style="text-align: center;"> Jorge Henrique de Oliveira de Godoy 1º Ten Esp CTA <br> Comandante do DTCEA-SJ</td>
            </tr>
        </table>
    </p>
    @endif
    <p style="margin-top: 1cm; text-align: center;">CONTROLE DA SITS</p>
    <table class="border" style="width: 100%; font-size: .7em; line-height: 20pt;">
        <thead class="border">
            <th></th>
            <th class="border">DATA</th>
            <th class="border">HORA</th>
            <th class="border" style="text-align: left; padding: 0 5px;">KM</th>
            <th class="border" style="text-align: left; padding: 0 5px;">NOME DE GUERRA</th>
            <th class="border">ASSINATURA</th>
        </thead>
        <tbody>
            <tr class="border">
                <td class="border" style="width: 4%; font-weight: bold; padding: 0 5px;">SAÍDA</td>
                <td class="border" style="width: 7%; padding: 0 5px;"> ___/___/______ </td>
                <td class="border" style="width: 4%; padding: 0 5px;"> ___:___ </td>
                <td class="border" style="width: 25%;"></td>
                <td class="border" style="width: 25%;"></td>
                <td class="border" style="width: 25%;"></td>
            </tr>
            <tr class="border">
                <td class="border" style="font-weight: bold; padding: 0 5px;">REGRESSO</td>
                <td class="border" style="padding: 0 5px;"> ___/___/______ </td>
                <td class="border" style="padding: 0 5px;"> ___:___ </td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="border"></td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: .8cm; width: 100%; line-height: 16pt;">
        <tr><td style="border-bottom: 1px solid #000;">Ocorrências:</td></tr>
        @for($i=0;$i<8;$i++)
            <tr><td style="border-bottom: 1px solid #000; height: 13pt;"></td></tr>
        @endfor
    </table>
</div>
</body>
</html>

