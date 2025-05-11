<?php

namespace App\UseCase\TrafficReturn\Update;

class UpdateTrafficReturnInput
{
    public function __construct(
        public int $companyId,
        public int $trafficReturnId,
        public int $trafficSourceId,
        public string $amount,
        public \DateTimeImmutable $date,
    ) {}
}
