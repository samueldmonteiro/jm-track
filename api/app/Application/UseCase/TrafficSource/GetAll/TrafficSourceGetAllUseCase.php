<?php

namespace App\Application\UseCase\TrafficSource\GetAll;

use App\Application\DTO\TrafficSourceDTO;
use App\Domain\Repository\TrafficSourceRepositoryInterface;

class TrafficSourceGetAllUseCase
{
    public function __construct(
        private TrafficSourceRepositoryInterface $trafficSourceRepository
    ) {}

    /** @return TrafficSourceDTO[] */
    public function execute(int $limit = 10): array
    {
        return array_map(function ($ts) {
            return new TrafficSourceDTO(
                $ts->getId(),
                $ts->getName(),
                $ts->getImage()
            );
        }, $this->trafficSourceRepository->getAll($limit));
    }
}
