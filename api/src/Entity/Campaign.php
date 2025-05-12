<?php

namespace App\Entity;

use App\Entity\Enum\CampaignStatus;
use App\Repository\CampaignRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CampaignRepository::class)]
#[ORM\Table(name: 'campaigns')]
class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['campaign'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'campaigns')]
    private ?Company $company = null;

    #[ORM\Column(length: 100)]
    #[Groups(['campaign'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['campaign'])]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['campaign'])]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(enumType: CampaignStatus::class)]
    #[Groups(['campaign'])]
    private ?CampaignStatus $status = null;

    /**
     * @var Collection<int, TrafficTransaction>
     */
    #[ORM\OneToMany(targetEntity: TrafficTransaction::class, mappedBy: 'campaign')]
    private Collection $trafficTransactions;

    public function __construct(
        string $name,
        Company $company,
        CampaignStatus $status,
        DateTimeImmutable $startDate
    ) {
        $this->setName($name);
        $this->setCompany($company);
        $this->setStatus($status);
        $this->setStartDate($startDate);
        $this->trafficTransactions = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatus(): ?CampaignStatus
    {
        return $this->status;
    }

    public function setStatus(CampaignStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, TrafficTransaction>
     */
    public function getTrafficTransactions(): Collection
    {
        return $this->trafficTransactions;
    }

    public function addTrafficTransaction(TrafficTransaction $trafficTransaction): static
    {
        if (!$this->trafficTransactions->contains($trafficTransaction)) {
            $this->trafficTransactions->add($trafficTransaction);
            $trafficTransaction->setCampaign($this);
        }

        return $this;
    }

    public function removeTrafficTransaction(TrafficTransaction $trafficTransaction): static
    {
        if ($this->trafficTransactions->removeElement($trafficTransaction)) {
            // set the owning side to null (unless already changed)
            if ($trafficTransaction->getCampaign() === $this) {
                $trafficTransaction->setCampaign(null);
            }
        }

        return $this;
    }
}
