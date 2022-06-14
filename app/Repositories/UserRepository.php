<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Interfaces\IValidator;
use App\User;

class UserRepository extends DefaultRepository implements IUserRepository
{
    public function __construct(IValidator $validateData, User $entity)
    {
        $this->Entity = $entity;
        $this->validateData = $validateData;
        $this->validateErrors = [];
    }
}
