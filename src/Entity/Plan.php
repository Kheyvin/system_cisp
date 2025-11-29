<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlanRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['plan:read']])]
class Plan
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['plan:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['plan:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['plan:read'])]
    private ?string $plan_mk = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['plan:read'])]
    private ?string $state = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['plan:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['plan:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['plan:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(inversedBy: 'plans')]
    #[ORM\JoinColumn(name: '"id_zone"', nullable: false)]
    #[Groups(['plan:read'])]
    private ?Zone $id_zone = null;

    /**
     * @var Collection<int, DetailPlan>
     */
    #[ORM\OneToMany(targetEntity: DetailPlan::class, mappedBy: 'id_plan')]
    private Collection $detailPlans;

    public function __construct()
    {
        $this->detailPlans = new ArrayCollection();
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

    public function getPlanMk(): ?string
    {
        return $this->plan_mk;
    }

    public function setPlanMk(?string $plan_mk): static
    {
        $this->plan_mk = $plan_mk;

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

    public function getIdZone(): ?Zone
    {
        return $this->id_zone;
    }

    public function setIdZone(?Zone $id_zone): static
    {
        $this->id_zone = $id_zone;

        return $this;
    }

    /**
     * @return Collection<int, DetailPlan>
     */
    public function getDetailPlans(): Collection
    {
        return $this->detailPlans;
    }

    public function addDetailPlan(DetailPlan $detailPlan): static
    {
        if (!$this->detailPlans->contains($detailPlan)) {
            $this->detailPlans->add($detailPlan);
            $detailPlan->setIdPlan($this);
        }

        return $this;
    }

    public function removeDetailPlan(DetailPlan $detailPlan): static
    {
        if ($this->detailPlans->removeElement($detailPlan)) {
            // set the owning side to null (unless already changed)
            if ($detailPlan->getIdPlan() === $this) {
                $detailPlan->setIdPlan(null);
            }
        }

        return $this;
    }
}
