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

    public function listActive()
    {
        return $this->Entity->active()->get();
    }

    public function history()
    {
        return $this->Entity->inactive()->get();
    }

    public function isOut()
    {
        return $this->Entity->isOut();
    }

    public function getKilometragem($id)
    {
        return $this->Entity->find($id)->kilometragem;
    }

    public function updateKilometragem($value, $id)
    {
        $this->Entity->find($id)->update(['kilometragem' => $value]);
        return true;
    }

    public function apiListActive()
    {
        return $this->Entity->select(['id','modelo'])->get()->filter(function($viatura){
            return !$viatura->isOut();
        })->map(function ($item){
            return [
                'id' => $item->id,
                'modelo' => $item->modelo,
            ];
        });
    }
}
