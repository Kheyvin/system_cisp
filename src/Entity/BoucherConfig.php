<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\BoucherConfigRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: BoucherConfigRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['boucher_config:read']])]
class BoucherConfig
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['boucher_config:read'])]
    private ?Uuid $id;

    #[ORM\Column]
    #[Groups(['boucher_config:read'])]
    private ?bool $is_special = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['boucher_config:read'])]
    private ?int $amount = null;

    #[ORM\Column]
    #[Groups(['boucher_config:read'])]
    private ?bool $is_sunat = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['boucher_config:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['boucher_config:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'boucherConfigs')]
    #[ORM\JoinColumn(name: '"id_service"', nullable: false)]
    #[Groups(['boucher_config:read'])]
    private ?Service $id_service = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function isSpecial(): ?bool
    {
        return $this->is_special;
    }

    public function setIsSpecial(bool $is_special): static
    {
        $this->is_special = $is_special;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function isSunata(): ?bool
    {
        return $this->is_sunat;
    }

    public function setIsSunata(bool $is_sunat): static
    {
        $this->is_sunat = $is_sunat;

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

    public function getIdService(): ?service
    {
        return $this->id_service;
    }

    public function setIdService(?service $id_service): static
    {
        $this->id_service = $id_service;

        return $this;
    }
}
