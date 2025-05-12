<?php

namespace App\UseCase\TrafficTransaction\Delete;

class DeleteTrafficTransactionInput
{
    public function __construct(
        public int $companyId,
        public int $trafficTransactionId,
    ) {}
}
