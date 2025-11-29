<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServicePlanRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ServicePlanRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['service_plan:read']])]
class ServicePlan
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['service_plan:read'])]
    private ?Uuid $id;

    #[ORM\Column]
    #[Groups(['service_plan:read'])]
    private ?bool $is_active = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['service_plan:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['service_plan:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['service_plan:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'servicePlans')]
    #[ORM\JoinColumn(name: '"id_service"', nullable: false)]
    #[Groups(['service_plan:read'])]
    private ?Service $id_service = null;

    #[ORM\ManyToOne(targetEntity: DetailPlan::class, inversedBy: 'servicePlans')]
    #[ORM\JoinColumn(name: '"id_detail_plan"', nullable: false)]
    #[Groups(['service_plan:read'])]
    private ?DetailPlan $id_detail_plan = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

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

    public function getIdService(): ?Service
    {
        return $this->id_service;
    }

    public function setIdService(?Service $id_service): static
    {
        $this->id_service = $id_service;

        return $this;
    }

    public function getIdDetailPlan(): ?DetailPlan
    {
        return $this->id_detail_plan;
    }

    public function setIdDetailPlan(?DetailPlan $id_detail_plan): static
    {
        $this->id_detail_plan = $id_detail_plan;

        return $this;
    }
}
