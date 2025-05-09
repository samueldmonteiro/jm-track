<?php

namespace App\Application\UseCase\TrafficSource\GetAll;

use App\Domain\Repository\TrafficSourceRepositoryInterface;

class TrafficSourceGetAllUseCase
{
    public function __construct(
        private TrafficSourceRepositoryInterface $trafficSourceRepository
    ) {}

    /** @return TrafficSource[] */
    public function execute(int $limit = 10): array
    {
        return $this->trafficSourceRepository->getAll($limit);
    }
}
