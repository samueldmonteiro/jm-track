<?php

namespace App\UseCase\TrafficReturn\Create;

use App\Entity\TrafficReturn;

class CreateTrafficReturnOutput
{
    public function __construct(
        public TrafficReturn $trafficReturn
    ) {}

    public function toArray(): array
    {
        return ['trafficReturn' => $this->trafficReturn];
    }
}
