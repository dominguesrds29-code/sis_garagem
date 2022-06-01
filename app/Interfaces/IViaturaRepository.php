<?php

namespace App\Interfaces;

interface IViaturaRepository extends IDefaultRepository
{
    public function active($id);

    public function desactive($id);
}
