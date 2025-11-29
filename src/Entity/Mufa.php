<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MufaRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: MufaRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['mufa:read']])]
class Mufa
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['mufa:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['mufa:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mufa:read'])]
    private ?string $latitud = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mufa:read'])]
    private ?string $longitud = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mufa:read'])]
    private ?string $puerto = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['mufa:read'])]
    private ?int $number = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['mufa:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['mufa:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['mufa:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'mufas')]
    #[ORM\JoinColumn(name: '"id_zone"',nullable: false)]
    #[Groups(['mufa:read'])]
    private ?Zone $id_zone = null;

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

    public function getLatitud(): ?string
    {
        return $this->latitud;
    }

    public function setLatitud(string $latitud): static
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(string $longitud): static
    {
        $this->longitud = $longitud;

        return $this;
    }

    public function getPuerto(): ?string
    {
        return $this->puerto;
    }

    public function setPuerto(string $puerto): static
    {
        $this->puerto = $puerto;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): static
    {
        $this->number = $number;

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

    public function getIdZone(): ?zone
    {
        return $this->id_zone;
    }

    public function setIdZone(?zone $id_zone): static
    {
        $this->id_zone = $id_zone;

        return $this;
    }
}
