<?php

namespace App\Interfaces;

interface ISaidaViaturaRepository extends IDefaultRepository
{
    public function listActive();

    public function history();
}
