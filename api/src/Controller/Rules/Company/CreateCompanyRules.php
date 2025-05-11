<?php

namespace App\Controller\Rules\Company;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCompanyRules
{
    #[Assert\NotBlank(message: "O nome é obrigatório.")]
    #[Assert\Length(min: 3, max: 100, minMessage: "O nome deve ter no mínimo {{ limit }} caracteres.")]
    public string $name;

    #[Assert\NotBlank(message: "O documento é obrigatório.")]
    #[Assert\Length(min: 11, max: 14, minMessage: "O documento deve ter entre 11 e 14 caracteres.")]
    public string $document;

    #[Assert\NotBlank(message: "O telefone é obrigatório.")]
    #[Assert\Regex(
        pattern: "/^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/",
        message: "O telefone deve ser válido."
    )]
    public string $phone;

    #[Assert\NotBlank(message: "O e-mail é obrigatório.")]
    #[Assert\Email(message: "O e-mail deve ser válido.")]
    public string $email;

    #[Assert\NotBlank(message: "A senha é obrigatória.")]
    #[Assert\Length(min: 6, minMessage: "A senha deve ter no mínimo {{ limit }} caracteres.")]
    public string $password;

    public function __construct(array $data)
    {
        $this->name     = $data['name']     ?? '';
        $this->document = $data['document'] ?? '';
        $this->phone    = $data['phone']    ?? '';
        $this->email    = $data['email']    ?? '';
        $this->password = $data['password'] ?? '';
    }
}
