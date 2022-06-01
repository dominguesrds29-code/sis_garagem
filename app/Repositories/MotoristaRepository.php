<?php

namespace App\Repositories;

use App\Interfaces\IValidator;
use App\Interfaces\IMotoristaRepository;
use App\Motorista;


class MotoristaRepository extends DefaultRepository implements IMotoristaRepository
{
    public function __construct(IValidator $validateData, Motorista $entity)
    {
        $this->Entity = $entity;
        $this->validateData = $validateData;
        $this->validateErrors = [];
    }

    public function active($id)
    {
        $this->Entity->find($id)->update(['status' => $this->Entity::AUTHORIZATION_ACTIVE]);
        return true;
    }

    public function desactive($id)
    {
        $this->Entity->find($id)->update(['status' => $this->Entity::AUTHORIZATION_INACTIVE]);
        return true;
    }
}
