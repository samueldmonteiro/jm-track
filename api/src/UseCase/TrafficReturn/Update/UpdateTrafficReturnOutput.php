<?php

namespace App\UseCase\TrafficReturn\Update;

use App\Entity\TrafficReturn;

class UpdateTrafficReturnOutput
{
    public function __construct(
        public TrafficReturn $trafficReturn
    ) {}

    public function toArray(): array
    {
        return ['trafficReturn' => $this->trafficReturn];
    }
}
