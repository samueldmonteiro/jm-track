<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_DOCUMENT', fields: ['document'])]
#[ORM\Table(name: 'companies')]
class Company implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['company'])]
    private ?string $document = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['company'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Ignore]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Groups(['company'])]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Groups(['company'])]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    #[Groups(['company'])]
    private ?string $phone = null;

    #[ORM\Column]
    #[Groups(['company'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['company'])]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Campaign>
     */
    #[ORM\OneToMany(targetEntity: Campaign::class, mappedBy: 'company')]
    private Collection $campaigns;

    /**
     * @var Collection<int, TrafficReturn>
     */
    #[ORM\OneToMany(targetEntity: TrafficReturn::class, mappedBy: 'company')]
    private Collection $trafficReturns;

    public function __construct(
        string $name,
        string $document,
        string $email,
        string $password,
        string $phone,
        DateTimeImmutable $createdAt,
    ) {
        $this->setName($name);
        $this->setDocument($document);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setPhone($phone);
        $this->setCreatedAt($createdAt);
        $this->campaigns = new ArrayCollection();
        $this->trafficReturns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(string $document): static
    {
        $this->document = $document;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->document;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Campaign>
     */
    public function getCampaigns(): Collection
    {
        return $this->campaigns;
    }

    public function addCampaign(Campaign $campaign): static
    {
        if (!$this->campaigns->contains($campaign)) {
            $this->campaigns->add($campaign);
            $campaign->setCompany($this);
        }

        return $this;
    }

    public function removeCampaign(Campaign $campaign): static
    {
        if ($this->campaigns->removeElement($campaign)) {
            // set the owning side to null (unless already changed)
            if ($campaign->getCompany() === $this) {
                $campaign->setCompany(null);
            }
        }

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
            $trafficReturn->setCompany($this);
        }

        return $this;
    }

    public function removeTrafficReturn(TrafficReturn $trafficReturn): static
    {
        if ($this->trafficReturns->removeElement($trafficReturn)) {
            // set the owning side to null (unless already changed)
            if ($trafficReturn->getCompany() === $this) {
                $trafficReturn->setCompany(null);
            }
        }

        return $this;
    }

}
