<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['zone:read']])]
#[ApiResource]
class Zone
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['zone:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['zone:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['zone:read'])]
    private ?string $abbreviation = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['zone:read'])]
    private ?bool $active = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['zone:read'])]
    private ?string $state = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['zone:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['zone:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['zone:read'])]
    private ?\DateTime $deletedAt = null;

    /**
     * @var Collection<int, Service>
     */
    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'id_zone')]
    private Collection $services;

    /**
     * @var Collection<int, Mufa>
     */
    #[ORM\OneToMany(targetEntity: Mufa::class, mappedBy: 'id_zone')]
    private Collection $mufas;

    /**
     * @var Collection<int, Plan>
     */
    #[ORM\OneToMany(targetEntity: Plan::class, mappedBy: 'id_zone')]
    private Collection $plans;

    /**
     * @var Collection<int, MkService>
     */
    #[ORM\OneToMany(targetEntity: MkService::class, mappedBy: 'id_zone')]
    private Collection $mkServices;

    #[ORM\ManyToOne(targetEntity: Mikrotik::class, inversedBy: 'zones')]
    #[ORM\JoinColumn(name: '"id_mikrotik"',nullable: false)]
    #[Groups(['zone:read'])]
    private ?Mikrotik $id_mikrotik = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->mufas = new ArrayCollection();
        $this->plans = new ArrayCollection();
        $this->mkServices = new ArrayCollection();
    }

    public function getId(): ?Uuid
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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): static
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

        public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setIdZone($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getIdZone() === $this) {
                $service->setIdZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mufa>
     */
    public function getMufas(): Collection
    {
        return $this->mufas;
    }

    public function addMufa(Mufa $mufa): static
    {
        if (!$this->mufas->contains($mufa)) {
            $this->mufas->add($mufa);
            $mufa->setIdZone($this);
        }

        return $this;
    }

    public function removeMufa(Mufa $mufa): static
    {
        if ($this->mufas->removeElement($mufa)) {
            // set the owning side to null (unless already changed)
            if ($mufa->getIdZone() === $this) {
                $mufa->setIdZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Plan>
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function addPlan(Plan $plan): static
    {
        if (!$this->plans->contains($plan)) {
            $this->plans->add($plan);
            $plan->setIdZone($this);
        }

        return $this;
    }

    public function removePlan(Plan $plan): static
    {
        if ($this->plans->removeElement($plan)) {
            // set the owning side to null (unless already changed)
            if ($plan->getIdZone() === $this) {
                $plan->setIdZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MkService>
     */
    public function getMkServices(): Collection
    {
        return $this->mkServices;
    }

    public function addMkService(MkService $mkService): static
    {
        if (!$this->mkServices->contains($mkService)) {
            $this->mkServices->add($mkService);
            $mkService->setIdZone($this);
        }

        return $this;
    }

    public function removeMkService(MkService $mkService): static
    {
        if ($this->mkServices->removeElement($mkService)) {
            // set the owning side to null (unless already changed)
            if ($mkService->getIdZone() === $this) {
                $mkService->setIdZone(null);
            }
        }

        return $this;
    }

    public function getIdMikrotik(): ?Mikrotik
    {
        return $this->id_mikrotik;
    }

    public function setIdMikrotik(?Mikrotik $id_mikrotik): static
    {
        $this->id_mikrotik = $id_mikrotik;

        return $this;
    }
}
