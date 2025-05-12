<?php

namespace App\UseCase\TrafficTransaction\Create;

use App\Entity\TrafficTransaction;

class CreateTrafficTransactionOutput
{
    public function __construct(
        public TrafficTransaction $trafficTransaction
    ) {}

    public function toArray(): array
    {
        return ['trafficTransaction' => $this->trafficTransaction];
    }
}
