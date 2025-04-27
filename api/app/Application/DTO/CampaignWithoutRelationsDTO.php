<?php

namespace App\Application\DTO;

use App\Domain\Enum\CampaignStatus;
use DateTimeImmutable;

class CampaignWithoutRelationsDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public CampaignStatus $status,
        public DateTimeImmutable $startDate,
        public ?DateTimeImmutable $endDate = null,
    ) {}
}
