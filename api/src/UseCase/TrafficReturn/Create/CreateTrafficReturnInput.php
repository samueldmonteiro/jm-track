<?php

namespace App\UseCase\TrafficReturn\Create;

use DateTimeImmutable;

class CreateTrafficReturnInput
{
    public function __construct(
        public int $companyId,
        public int $campaignId,
        public int $trafficSourceId,
        public string $amount,
        public DateTimeImmutable $date,
    ) {}
}
