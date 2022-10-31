<?php

namespace App\Services\Efetivo;

class GetEffectiveList extends EfetivoService
{
    protected function getRoute() {
        return '/api/users/list';
    }

    public function call()
    {
        return parent::generatedToken()->getInJson();
    }
}
