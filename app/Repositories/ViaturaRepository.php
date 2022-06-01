<?php

namespace App\Repositories;

use App\Interfaces\IValidator;
use App\Viatura;
use App\Interfaces\IViaturaRepository;

class ViaturaRepository extends DefaultRepository implements IViaturaRepository
{
    public function __construct(IValidator $validateData, Viatura $entity)
    {
        $this->Entity = $entity;
        $this->validateData = $validateData;
        $this->validateErrors = [];
    }

    public function active($id)
    {
        $this->Entity->find($id)->update(['situacao' => $this->Entity::ACTIVE]);
        return true;
    }

    public function desactive($id)
    {
        $this->Entity->find($id)->update(['situacao' => $this->Entity::INACTIVE]);
        return true;
    }
}
