<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;

class Company
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $document,
        private Email $email,
        private string $phone,
        private string $password,

        /** @var Campaign[] */
        private array $campaigns = [],

        /** @var TrafficExpense[] */
        private array $trafficExpenses = []
    ) {}

    protected $hidden = ['password'];

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): self
    {
        $this->document = $document;
        return $this;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function addCampaign(Campaign $campaign): static
    {
        if (!in_array($campaign, $this->campaigns, true)) {
            $this->campaigns[] = $campaign;
            $campaign->setCompany($this);
        }
        return $this;
    }

    public function removeCampaign(Campaign $campaign): static
    {
        $key = array_search($campaign, $this->campaigns, true);
        if ($key !== false) {
            unset($this->campaigns[$key]);
        }
        return $this;
    }

    public function addtrafficExpense(TrafficExpense $trafficExpense): static
    {
        if (!in_array($trafficExpense, $this->trafficExpenses, true)) {
            $this->trafficExpenses[] = $trafficExpense;
            $trafficExpense->setCompany($this);
        }
        return $this;
    }

    public function removetrafficExpense(TrafficExpense $trafficExpense): static
    {
        $key = array_search($trafficExpense, $this->trafficExpenses, true);
        if ($key !== false) {
            unset($this->trafficExpenses[$key]);
        }
        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'document' => $this->getDocument(),
            'email' => (string) $this->getEmail(),
            'phone' => $this->getPhone(),
        ];

        if ($this->campaigns) {
            $data['campaigns'] = array_map(function ($c) {
                return $c->toArray();
            }, $this->campaigns);
        }

        if ($this->trafficExpenses) {
            $data['trafficExpenses'] = array_map(function ($c) {
                return $c->toArray();
            }, $this->trafficExpenses);
        }

        return $data;
    }
}
