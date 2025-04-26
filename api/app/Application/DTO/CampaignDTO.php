<?php

namespace App\Application\DTO;

use App\Domain\Entity\Company;
use App\Domain\Enum\CampaignStatus;
use DateTimeImmutable;

class CampaignDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public CampaignStatus $status,
        public DateTimeImmutable $startDate,
        public ?DateTimeImmutable $endDate = null,
        public ?Company $company = null,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company ? $this->company->toArray() : null,
            'name' => $this->name,
            'status' => $this->status->value,
            'start_date' => $this->startDate->format('Y-m-d H:i:s'),
            'end_date' => $this->endDate?->format('Y-m-d H:i:s'),
        ];
    }
}
