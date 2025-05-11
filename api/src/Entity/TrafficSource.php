<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TrafficSourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TrafficSourceRepository::class)]
#[ApiResource]
#[ORM\Table(name: 'traffic_sources')]
class TrafficSource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tSource'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['tSource'])]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Groups(['tSource'])]
    private ?string $image = null;

    /**
     * @var Collection<int, TrafficReturn>
     */
    #[ORM\OneToMany(targetEntity: TrafficReturn::class, mappedBy: 'trafficSource')]
    private Collection $trafficReturns;

    public function __construct(
        string $name,
        string $image,
    ) {
        $this->setName($name);
        $this->setImage($image);
        $this->trafficReturns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, TrafficReturn>
     */
    public function getTrafficReturns(): Collection
    {
        return $this->trafficReturns;
    }

    public function addTrafficReturn(TrafficReturn $trafficReturn): static
    {
        if (!$this->trafficReturns->contains($trafficReturn)) {
            $this->trafficReturns->add($trafficReturn);
            $trafficReturn->setTrafficSource($this);
        }

        return $this;
    }

    public function removeTrafficReturn(TrafficReturn $trafficReturn): static
    {
        if ($this->trafficReturns->removeElement($trafficReturn)) {
            // set the owning side to null (unless already changed)
            if ($trafficReturn->getTrafficSource() === $this) {
                $trafficReturn->setTrafficSource(null);
            }
        }

        return $this;
    }
}
