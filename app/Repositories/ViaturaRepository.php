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
		// TODO: Implement get() method.
	}

	public function create($data)
	{
		// TODO: Implement create() method.
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
		// TODO: Implement isValid() method.
	}

	public function getValidateErrors()
	{
		// TODO: Implement getValidateErrors() method.
	}
}
