<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Campaign;

interface CampaignRepositoryInterface
{
    public function findById(int $id): ?Campaign;
    public function store(Campaign $campaign): Campaign;
}
