<?php

namespace App\UseCase\TrafficTransaction\Create;

use App\Entity\Enum\TrafficTransactionType;
use DateTimeImmutable;

class CreateTrafficTransactionInput
{
    public function __construct(
        public int $companyId,
        public int $campaignId,
        public int $trafficSourceId,
        public string $amount,
        public DateTimeImmutable $date,
        public TrafficTransactionType $type,
    ) {}
}
