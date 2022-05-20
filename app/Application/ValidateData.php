<?php

namespace App\Application;

use App\Interfaces\IValidator;
use Illuminate\Support\Facades\Validator;

class ValidateData implements IValidator
{
    public function check($data, $fields)
    {
        $validator = Validator::make($data, $fields);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $validator;
        }
        return [];
    }
}
