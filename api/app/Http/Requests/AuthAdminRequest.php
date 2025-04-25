<?php

namespace App\Http\Requests;


class AuthAdminRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc',
            'password' => 'required|string', // Adicionando uma validação mínima para a senha
        ];
    }
}
