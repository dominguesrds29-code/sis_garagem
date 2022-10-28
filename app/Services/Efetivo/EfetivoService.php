<?php

namespace App\Services\Efetivo;

use App\Services\ServiceExternalApi;

abstract class EfetivoService extends ServiceExternalApi
{
    protected function getUri() {
        return env('EFETIVO_API_URI');
    }
}
