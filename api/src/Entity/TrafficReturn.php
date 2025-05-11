<?php

namespace App\Entity;

use App\Repository\TrafficReturnRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TrafficReturnRepository::class)]
#[ORM\Table(name: 'traffic_returns')]
class TrafficReturn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tReturn', 'tSource'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trafficReturns')]
    #[Groups(['company'])]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'trafficReturns')]
    #[Groups(['campaign'])]
    private ?Campaign $campaign = null;

    #[ORM\ManyToOne(inversedBy: 'trafficReturns')]
    #[Groups(['tSource'])]
    private ?TrafficSource $trafficSource = null;

    #[ORM\Column]
    #[Groups(['tReturn', 'tSource'])]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['tReturn', 'tSource'])]
    private ?string $amount = null;

    public function __construct(
        Company $company,
        Campaign $campaign,
        TrafficSource $trafficSource,
        string $amount,
        \DateTimeImmutable $date
    ) {
        $this->setCompany($company);
        $this->setCampaign($campaign);
        $this->setTrafficSource($trafficSource);
        $this->setAmount($amount);
        $this->setDate($date);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): static
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getTrafficSource(): ?TrafficSource
    {
        return $this->trafficSource;
    }

    public function setTrafficSource(?TrafficSource $trafficSource): static
    {
        $this->trafficSource = $trafficSource;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
