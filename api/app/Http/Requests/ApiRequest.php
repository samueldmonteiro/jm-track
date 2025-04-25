<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(

            response()->json([
                'status' => false,
                'message' => (new ValidationException($validator))->getMessage(),
                'errors' => $errors,
            ], 400)
        );

        parent::failedValidation($validator);
    }
}