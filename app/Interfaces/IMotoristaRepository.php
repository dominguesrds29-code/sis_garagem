<?php

namespace App\Interfaces;

interface IMotoristaRepository extends IDefaultRepository
{
    public function active($id);

    public function desactive($id);
}
