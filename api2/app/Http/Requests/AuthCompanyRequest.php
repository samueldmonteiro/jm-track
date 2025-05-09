<?php

namespace App\Http\Requests;

class AuthCompanyRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document' => 'required|string',
            'password' => 'required|string'
        ];
    }
}
