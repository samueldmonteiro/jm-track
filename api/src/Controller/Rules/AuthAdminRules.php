<?php

namespace App\Controller\Rules;

use Symfony\Component\Validator\Constraints as Assert;

class AuthAdminRules
{
    #[Assert\NotBlank(message: "O Documento é obrigatório.")]
    public string $document;

    #[Assert\NotBlank(message: "A senha é obrigatória.")]
    public string $password;

    public function __construct(array $data)
    {
        $this->document = $data['document'] ?? '';
        $this->password = $data['password'] ?? '';
    }
}
