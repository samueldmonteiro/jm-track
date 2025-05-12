<?php

namespace App\UseCase\TrafficTransaction\Update;

class UpdateTrafficTransactionInput
{
    public function __construct(
        public int $companyId,
        public int $trafficTransactionId,
        public int $trafficSourceId,
        public string $amount,
        public \DateTimeImmutable $date,
    ) {}
}
