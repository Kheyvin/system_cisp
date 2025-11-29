<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\DetailPlanRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: DetailPlanRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['detail_plan:read']])]
class DetailPlan
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['detail_plan:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['detail_plan:read'])]
    private ?string $type_plan = null;

    #[ORM\Column(length: 255)]
    #[Groups(['detail_plan:read'])]
    private ?string $speed = null;

    #[ORM\Column]
    #[Groups(['detail_plan:read'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['detail_plan:read'])]
    private ?bool $active = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['detail_plan:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['detail_plan:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['detail_plan:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Plan::class, inversedBy: 'detailPlans')]
    #[ORM\JoinColumn(name: '"id_plan"',nullable: false)]
    #[Groups(['detail_plan:read'])]
    private ?Plan $id_plan = null;

    /**
     * @var Collection<int, Boucher>
     */
    #[ORM\OneToMany(targetEntity: Boucher::class, mappedBy: 'id_detail_plan')]
    private Collection $bouchers;

    /**
     * @var Collection<int, ServicePlan>
     */
    #[ORM\OneToMany(targetEntity: ServicePlan::class, mappedBy: 'id_detail_plan')]
    private Collection $servicePlans;

    public function __construct()
    {
        $this->bouchers = new ArrayCollection();
        $this->servicePlans = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTypePlan(): ?string
    {
        return $this->type_plan;
    }

    public function setTypePlan(string $type_plan): static
    {
        $this->type_plan = $type_plan;

        return $this;
    }

    public function getSpeed(): ?string
    {
        return $this->speed;
    }

    public function setSpeed(string $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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

    public function setDeletedAt(\DateTime $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getIdPlan(): ?Plan
    {
        return $this->id_plan;
    }

    public function setIdPlan(?Plan $id_plan): static
    {
        $this->id_plan = $id_plan;

        return $this;
    }

    /**
     * @return Collection<int, Boucher>
     */
    public function getBouchers(): Collection
    {
        return $this->bouchers;
    }

    public function addBoucher(Boucher $boucher): static
    {
        if (!$this->bouchers->contains($boucher)) {
            $this->bouchers->add($boucher);
            $boucher->setIdDetailPlan($this);
        }

        return $this;
    }

    public function removeBoucher(Boucher $boucher): static
    {
        if ($this->bouchers->removeElement($boucher)) {
            // set the owning side to null (unless already changed)
            if ($boucher->getIdDetailPlan() === $this) {
                $boucher->setIdDetailPlan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ServicePlan>
     */
    public function getServicePlans(): Collection
    {
        return $this->servicePlans;
    }

    public function addServicePlan(ServicePlan $servicePlan): static
    {
        if (!$this->servicePlans->contains($servicePlan)) {
            $this->servicePlans->add($servicePlan);
            $servicePlan->setIdDetailPlan($this);
        }

        return $this;
    }

    public function removeServicePlan(ServicePlan $servicePlan): static
    {
        if ($this->servicePlans->removeElement($servicePlan)) {
            // set the owning side to null (unless already changed)
            if ($servicePlan->getIdDetailPlan() === $this) {
                $servicePlan->setIdDetailPlan(null);
            }
        }

        return $this;
    }
}
