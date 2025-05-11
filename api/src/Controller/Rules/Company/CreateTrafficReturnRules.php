<?php

namespace App\Controller\Rules\Company;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTrafficReturnRules
{
    #[Assert\NotBlank(message: "O Valor é obrigatório.")]
    public string $amount;

    #[Assert\NotBlank(message: "A Data é obrigatório.")]
    #[Assert\Date(message: 'A Data é inválida')]
    public string $date;

    #[Assert\NotBlank(message: "O companyId é obrigatório.")]
    public string $companyId;

    #[Assert\NotBlank(message: "O campaignId é obrigatório.")]
    public string $campaignId;

    #[Assert\NotBlank(message: "O trafficSourceId é obrigatório.")]
    public string $trafficSourceId;

    public function __construct(array $data)
    {
        $this->companyId = $data['companyId'] ?? '';
        $this->trafficSourceId = $data['trafficSourceId'] ?? '';
        $this->campaignId = $data['campaignId'] ?? '';
        $this->date = $data['date'] ?? '';
        $this->amount = $data['amount'] ?? '';
    }
}
