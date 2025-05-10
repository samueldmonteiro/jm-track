<?php

namespace App\UseCase\Campaign\Create;

class CreateCampaignInput
{
    public function __construct(
        public string $name,
        public int $companyId
    ) {}
}
