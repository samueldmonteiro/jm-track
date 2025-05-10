<?php

namespace App\Controller\Rules;

use Symfony\Component\Validator\Constraints as Assert;

class DeleteCampaignRules
{
    #[Assert\NotBlank(message: "O companyId é obrigatório.")]
    public string $companyId;

    #[Assert\NotBlank(message: "O campaignId é obrigatório.")]
    public string $campaignId;

    public function __construct(array $data)
    {
        $this->companyId = $data['companyId'] ?? '';
        $this->campaignId = $data['campaignId'] ?? '';
    }
}
