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
        return Role::orderBy('id', 'ASC')->pluck('name', 'name')->all();
    }

    public function getOwnPermissions($role)
    {
        return $this->Entity->find($role)->permissions()->orderBy('id', 'ASC')->pluck('name', 'name')->all();
    }
}
