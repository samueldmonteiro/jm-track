<?php

namespace App\UseCase\TrafficTransaction\Update;

use App\Entity\TrafficTransaction;

class UpdateTrafficTransactionOutput
{
    public function __construct(
        public TrafficTransaction $trafficTransaction
    ) {}

    public function toArray(): array
    {
        return ['trafficTransaction' => $this->trafficTransaction];
    }
}
