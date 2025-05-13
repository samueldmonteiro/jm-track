<?php

namespace App\UseCase\TrafficSource\FindAll;

use App\Contract\Repository\TrafficSourceRepositoryInterface;

class FindAllTrafficSource
{
    public function __construct(
        private TrafficSourceRepositoryInterface $trafficSourceRepository
    ) {}

    public function execute(): FindAllTrafficSourceOutput
    {
        $all = $this->trafficSourceRepository->findAll();

        return new FindAllTrafficSourceOutput(
            $all
        );
    }
}
