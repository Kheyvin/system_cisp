<?php

namespace App\Entity;

use App\Entity\Service;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Types\UuidType;
use App\Repository\ContactServiceRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ContactServiceRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['contact_service:read']])]
class ContactService
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['contact_service:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['contact_service:read'])]
    private ?string $address = null;

    #[ORM\Column(name: '"references"',length: 255)]
    #[Groups(['contact_service:read'])]
    private ?string $references = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact_service:read'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact_service:read'])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['contact_service:read'])]
    private ?string $latitud = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['contact_service:read'])]
    private ?string $longitud = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['contact_service:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['contact_service:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['contact_service:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'boucherConfigs')]
    #[ORM\JoinColumn(name: '"id_service"',nullable: false)]
    #[Groups(['contact_service:read'])]
    private ?Service $id_service = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getReferences(): ?string
    {
        return $this->references;
    }

    public function setReferences(string $references): static
    {
        $this->references = $references;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getLatitud(): ?string
    {
        return $this->latitud;
    }

    public function setLatitud(?string $latitud): static
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(?string $longitud): static
    {
        $this->longitud = $longitud;

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
