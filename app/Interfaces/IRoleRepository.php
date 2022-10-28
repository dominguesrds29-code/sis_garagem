<?php

namespace App\Interfaces;

interface IRoleRepository extends IDefaultRepository
{
    public function getRoleNames();

    public function getOwnPermissions($role);
}
