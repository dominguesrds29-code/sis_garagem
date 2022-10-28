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
        $auth = $this->Entity->find($id);
        if($auth->cnh_validate < date('Y-m-d') || $auth->authorization_date < date('Y-m-d')){
            return false;
        }
        $auth->update(['status' => $this->Entity::AUTHORIZATION_ACTIVE]);
        return true;
    }

    public function desactive($id)
    {
        $this->Entity->find($id)->update(['status' => $this->Entity::AUTHORIZATION_INACTIVE]);
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

    public function apiMotoristasList()
    {
        return $this->Entity->select(['id','user_war_name'])->get()->map(function ($item){
            return [
                'id' => $item->id,
                'name' => $item->user_war_name,
            ];
        });
    }
}
