<?php

namespace App\Repositories;

use App\Interfaces\IRoleRepository;
use App\Interfaces\IValidator;
use App\Role;

class RoleRepository extends DefaultRepository implements IRoleRepository
{
    public function __construct(IValidator $validateData, Role $entity)
    {
        $this->Entity = $entity;
        $this->validateData = $validateData;
        $this->validateErrors = [];
    }

    public function getRoleNames()
    {
        return Role::orderBy('id', 'ASC')->pluck('name', 'name')->filter(function($item){
            if($item == 'super-admin'){
                return auth()->user()->hasRole('super-admin');
            }
            return true;
        })->all();
    }

    public function getOwnPermissions($role)
    {
        return $this->Entity->find($role)->permissions()->orderBy('id', 'ASC')->pluck('name', 'name')->all();
    }
}
