<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['car:read']])]
class Car
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['car:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['car:read'])]
    private ?string $number_plate = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['car:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['car:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['car:read'])]
    private ?\DateTime $deletedAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getNumberPlate(): ?string
    {
        return $this->number_plate;
    }

    public function setNumberPlate(string $number_plate): static
    {
        $this->number_plate = $number_plate;

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
}
