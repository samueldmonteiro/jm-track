<?php

namespace App\Application\UseCase\Campaign\Store;

use DateTimeImmutable;

class CampaignStoreInputDTO
{
    public function __construct(
        public int $companyId,
        public string $name,
        public DateTimeImmutable $startDate,
    ) {}
}
