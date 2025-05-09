<?php

namespace App\Domain\Repository;

use App\Domain\Entity\TrafficSource;

interface TrafficSourceRepositoryInterface
{
    public function findByName(string $name): ?TrafficSource;
    public function findById(int $id): ?TrafficSource;

    /** @return TrafficSource[] */
    public function getAll(int $limit = 10): array;
}
