<?php

namespace App\Controller\Rules;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCampaignRules
{
    #[Assert\NotBlank(message: "O nome é obrigatório.")]
    #[Assert\Length(min: 3, max: 50, minMessage: "O nome deve ter no mínimo {{ limit }} caracteres.")]
    public string $name;

    #[Assert\NotBlank(message: "O companyId é obrigatório.")]
    public string $companyId;

    public function __construct(array $data)
    {
        $this->name      = $data['name']      ?? '';
        $this->companyId = $data['companyId'] ?? '';
    }
}
