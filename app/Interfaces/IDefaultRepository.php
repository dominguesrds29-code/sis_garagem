<?php

namespace App\Interfaces;

interface IDefaultRepository
{
    public function list();

    public function get($id);

    public function create($data);

    public function update($data, $id);

    public function delete($id);

    public function isValid($data, $id = null);

    public function getValidateErrors();
}
