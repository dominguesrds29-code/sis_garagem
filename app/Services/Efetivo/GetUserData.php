<?php

namespace App\Services\Efetivo;

class GetUserData extends EfetivoService
{
    private int $id;

    public function __construct(int $id)
    {
        parent::__construct();
        $this->id = $id;
    }

    protected function getRoute()
    {
        return '/api/users/getUser';
    }

    public function call()
    {
        return parent::generatedToken()->getInJson(['id' => $this->id]);
    }
}
