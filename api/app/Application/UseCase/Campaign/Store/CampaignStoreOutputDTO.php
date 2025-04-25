<?php

namespace App\Application\UseCase\Campaign\Store;

use App\Domain\Entity\Company;
use App\Domain\Enum\CampaignStatus;
use DateTimeImmutable;

class CampaignStoreOutputDTO
{
    public function __construct(
        public int $id,
        public Company $company,
        public string $name,
        public CampaignStatus $status,
        public DateTimeImmutable $startDate,
        public ?DateTimeImmutable $endDate = null
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company->toArray(), 
            'name' => $this->name,
            'status' => $this->status->value,
            'start_date' => $this->startDate->format('Y-m-d H:i:s'),
            'end_date' => $this->endDate?->format('Y-m-d H:i:s'),
        ];
    }
}
