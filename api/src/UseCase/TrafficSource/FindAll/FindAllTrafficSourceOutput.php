<?php

namespace App\UseCase\TrafficSource\FindAll;

class FindAllTrafficSourceOutput
{
    public function __construct(
        public array $trafficSources
    ) {}

    public function toArray(): array
    {
        return ['trafficSources' => $this->trafficSources];
    }
}
