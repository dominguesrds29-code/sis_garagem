<?php

namespace App\Repositories;

use App\Interfaces\IValidator;
use App\Viatura;
use App\Interfaces\IViaturaRepository;

class ViaturaRepository implements IViaturaRepository
{
    private $validateData;
    private $validateErrors;

    public function __construct(IValidator $validateData)
    {
        $this->validateData = $validateData;
        $this->validateErrors = [];
    }
	public function list()
	{
        return Viatura::all();
	}

	public function get($id)
	{
		return Viatura::find($id);
	}

	public function create($data)
	{
		Viatura::create([
			'modelo' => $data->modelo,
			'combustivel' => implode(',', $data->combustivel),
			'kilometragem' => $data->kilometragem,
			'situacao' => $data->situacao,
		]);

		return true;
	}

	public function update($data, $id)
	{
		// TODO: Implement update() method.
	}

	public function delete($id)
	{
		// TODO: Implement delete() method.
	}

	public function isValid($data, $id = null)
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

	private function formValidate(){
		return [
			'modelo' => 'required',
			'combustivel' => 'required',
			'situacao' => 'required|in:Ativa,Recolhida',
			'kilometragem' => 'sometimes|integer',
		];
	}
}
