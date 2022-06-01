<?php

namespace App\Repositories;

use App\Interfaces\IDefaultRepository;
use App\Interfaces\IValidator;
use App\Viatura;

class DefaultRepository implements IDefaultRepository
{
    protected $validateData;
    protected $validateErrors;
    protected $Entity;

    public function list()
    {
        return $this->Entity->active()->get();
    }

    public function history()
    {
        return $this->Entity->inactive()->get();
    }

    public function get($id)
    {
        return $this->Entity->find($id);
    }

    public function create($data)
    {
        $this->Entity->create($this->loadData($data));
        return true;
    }

    public function update($data, $id)
    {
        $this->Entity->find($id)->fill($this->loadData($data))->save();
        return true;
    }

    public function delete($id)
    {
        return $this->Entity->find($id)->delete();
    }

    public function isValid($data)
    {
        if(!$this->validateErrors = $this->validateData->check($data, $this->formValidate())){
            return true;
        }

        return false;
    }

    public function getValidateErrors()
    {
        return $this->validateErrors;
    }

    private function formValidate()
    {
        return $this->Entity->dataValidate;
    }

    private function loadData($data)
    {
        $dataForm = [];
        foreach ($this->Entity->getFillable() as $column) {
            $dataForm[$column] = $data->$column;
        }

        return $dataForm;
    }
}
