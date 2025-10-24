<?php

namespace App\Interfaces;

interface IViaturaRepository extends IDefaultRepository
{
    public function listActive();

    public function history();

    public function active($id);

    public function desactive($id);

    public function isOut();

    public function getKilometragem($id);

    public function updateKilometragem($value, $id);
}
