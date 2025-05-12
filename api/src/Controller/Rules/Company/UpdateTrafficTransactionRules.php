<?php

namespace App\Controller\Rules\Company;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateTrafficTransactionRules
{
    #[Assert\NotBlank(message: "O Valor é obrigatório.")]
    public string $amount;

    #[Assert\NotBlank(message: "A Data é obrigatório.")]
    #[Assert\Date(message: 'A Data é inválida')]
    public string $date;

    #[Assert\NotBlank(message: "O companyId é obrigatório.")]
    public string $companyId;

    #[Assert\NotBlank(message: "O trafficTransactionId é obrigatório.")]
    public string $trafficTransactionId;

    #[Assert\NotBlank(message: "O trafficSourceId é obrigatório.")]
    public string $trafficSourceId;

    public function __construct(array $data)
    {
        $this->companyId = $data['companyId'] ?? '';
        $this->trafficSourceId = $data['trafficSourceId'] ?? '';
        $this->trafficTransactionId = $data['trafficTransactionId'] ?? '';
        $this->date = $data['date'] ?? '';
        $this->amount = $data['amount'] ?? '';
    }
}
