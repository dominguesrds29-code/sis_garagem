<?php

namespace App\Repositories;

use App\Interfaces\IPermissionRepository;
use App\Interfaces\IValidator;
use App\Permission;

class PermissionRepository extends DefaultRepository implements IPermissionRepository
{
    public function __construct(IValidator $validateData, Permission $entity)
    {
        $this->Entity = $entity;
        $this->validateData = $validateData;
        $this->validateErrors = [];
    }

    public function getPermissionNames()
    {
        return Permission::pluck('name', 'name')->all();
    }
}
