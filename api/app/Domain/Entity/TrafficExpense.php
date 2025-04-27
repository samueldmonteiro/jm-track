<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Amount;
use DateTimeImmutable;
use DomainException;

class TrafficExpense
{
    public function __construct(
        private ?int $id,
        private ?Company $company,
        private ?TrafficSource $trafficSource,
        private ?Campaign $campaign,
        private DateTimeImmutable $date,
        private Amount $amount
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

    public function getTrafficSource(): TrafficSource
    {
        if (!$this->trafficSource) {
            throw new DomainException('Traffic Source is not loaded.');
        }
        return $this->trafficSource;
    }

    public function setTrafficSource(TrafficSource $trafficSource): self
    {
        $this->trafficSource = $trafficSource;
        return $this;
    }

    public function getCampaign(): Campaign
    {
        if (!$this->campaign) {
            throw new DomainException('Campaign is not loaded.');
        }
        return $this->campaign;
    }

    public function setCampaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function setAmount(Amount $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'company' => $this->company ? $this->company->toArray() : null,
            'company' => $this->company ? $this->company->toArray() : null,
            'trafficSource' => $this->trafficSource ? $this->trafficSource->toArray() : null,
            'campaign' => $this->campaign ? $this->campaign->toArray() : null,
            'date' => $this->getDate()->format('Y-m-d'),
            'amount' => $this->getAmount()->getValue(),
        ];
    }
}
