<?php

namespace App\UseCase\Campaign\FindAllForCompany;

class FindAllCampaignsForCompanyOutput
{
    public function __construct(
        /** @param Campaign[] */
        public array $campaigns
    ) {}

    public function toArray(): array
    {
        return ['campaigns' => $this->campaigns];
    }
}
