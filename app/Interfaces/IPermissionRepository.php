<?php

namespace App\Interfaces;

interface IPermissionRepository extends IDefaultRepository
{
    public function getPermissionNames();
}
