<?php

namespace App\Contract\Repository;

use App\Exception\TrafficSourceNotFoundException;
use App\Entity\TrafficSource;

interface TrafficSourceRepositoryInterface
{
     /**
     * @throws TrafficSourceNotFoundException
     */
    public function findById(int $id, bool $throw = true): ?TrafficSource;
    public function findAll(): array;

}
