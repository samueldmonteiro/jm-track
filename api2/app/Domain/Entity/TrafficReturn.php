<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Amount;
use DateTimeImmutable;
use DomainException;

class TrafficReturn
{
    public function __construct(
        private ?int $id,
        private DateTimeImmutable $date,
        private Amount $amount,
        private ?Company $company,
        private ?Campaign $campaign,
        private ?TrafficSource $trafficSource
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
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

    public function getTrafficSource(): TrafficSource
    {
        if (!$this->trafficSource) {
            throw new DomainException('TrafficSource is not loaded.');
        }
        return $this->trafficSource;
    }

    public function setTrafficSource(TrafficSource $trafficSource): self
    {
        $this->trafficSource = $trafficSource;
        return $this;
    }

    public function toArray(): array
    {
        $data =  [
            'id' => $this->getId(),
            'date' => $this->getDate()->format('d-m-Y'),
            'amount' => $this->getAmount()->getValue(),
        ];

        if ($this->company) {
            $data['company'] =  $this->company->toArray();
        }

        if ($this->campaign) {
            $data['campaign'] =  $this->campaign->toArray();
        }

        if ($this->trafficSource) {
            $data['trafficSource'] =  $this->trafficSource->toArray();
        }

        return $data;
    }
}
