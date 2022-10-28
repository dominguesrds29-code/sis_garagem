<?php

namespace App\Interfaces;

interface IUserRepository extends IDefaultRepository
{
    public function restore($id);

    public function getOwnRoles($user);

    public function getOwnPermissions($user);
}
