<?php

namespace App\UseCase\TrafficReturn\Delete;

class DeleteTrafficReturnInput
{
    public function __construct(
        public int $companyId,
        public int $trafficReturnId,
    ) {}
}
