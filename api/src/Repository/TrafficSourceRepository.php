<?php

namespace App\Repository;

use App\Contract\Repository\TrafficSourceRepositoryInterface;
use App\Exception\TrafficSourceNotFoundException;
use App\Entity\TrafficSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrafficSourceRepository extends ServiceEntityRepository implements TrafficSourceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrafficSource::class);
    }

    public function findById(int $id, bool $throw = true): ?TrafficSource
    {
        $trafficSource = $this->findOneBy(['id' => $id]);
        if (!$trafficSource && $throw) {
            throw new TrafficSourceNotFoundException();
        }

        return $trafficSource;
    }
}
