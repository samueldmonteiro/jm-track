<?php

namespace App\Controller\Rules\Company;

use Symfony\Component\Validator\Constraints as Assert;

class DeleteTrafficTransactionRules
{
    #[Assert\NotBlank(message: "O companyId é obrigatório.")]
    public string $companyId;

    #[Assert\NotBlank(message: "O trafficTransactionId é obrigatório.")]
    public string $trafficTransactionId;

    public function __construct(array $data)
    {
        $this->companyId = $data['companyId'] ?? '';
        $this->trafficTransactionId = $data['trafficTransactionId'] ?? '';
    }
}
