<?php

namespace App\Domain\Entity;

use App\Domain\Enum\CampaignStatus;
use DateTimeImmutable;
use DomainException;

class Campaign
{
    public function __construct(
        private ?int $id,
        private ?Company $company,
        private string $name,
        private CampaignStatus $status,
        private DateTimeImmutable $startDate,
        private ?DateTimeImmutable $endDate = null,
        private array $trafficExpenses = [],
        private array $trafficReturns = [],
        private array $campaignMetrics = [],
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): Company
    {
        if (!$this->company) {
            throw new DomainException('Company is not loaded.');
        }
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeImmutable $endDate = null): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getStatus(): CampaignStatus
    {
        return $this->status;
    }

    public function setStatus(CampaignStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getTrafficExpenses(): array
    {
        return $this->trafficExpenses;
    }

    public function getTrafficReturns(): array
    {
        return $this->trafficReturns;
    }

    public function getCampaignMetrics(): array
    {
        return $this->campaignMetrics;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'status' => $this->getStatus()->value,
            'start_date' => $this->getStartDate()->format('Y-m-d H:i:s'),
            'end_date' => $this->getEndDate()?->format('Y-m-d H:i:s'),
        ];

        if ($this->company) {
            $data['company'] =  $this->company->toArray();
        }

        if ($this->trafficExpenses) {
            $data['trafficExpenses'] = array_map(function ($te) {
                return $te->toArray();
            }, $this->trafficExpenses);
        }

        if ($this->trafficReturns) {
            $data['trafficReturns'] = array_map(function ($tr) {
                return $tr->toArray();
            }, $this->trafficReturns);
        }

        if ($this->campaignMetrics) {
            $data['campaignMetrics'] = array_map(function ($tr) {
                return $tr->toArray();
            }, $this->campaignMetrics);
        }

        if ($this->company) {
            $data['company'] =  $this->company->toArray();
        }

        return $data;
    }
}
