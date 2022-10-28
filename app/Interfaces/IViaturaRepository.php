<?php

namespace App\Interfaces;

interface IViaturaRepository extends IDefaultRepository
{
    public function listActive();

    public function history();

    public function active($id);

    public function desactive($id);
}
