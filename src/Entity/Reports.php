<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReportsRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ReportsRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
    normalizationContext: ['groups' => ['reports:read']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id_service' => 'exact',
])]
class Reports
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['reports:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['reports:read'])]
    private ?string $report = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['reports:read'])]
    private ?bool $error = null;

    #[ORM\Column(length: 255)]
    #[Groups(['reports:read'])]
    private ?string $state = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['reports:read'])]
    private ?string $message = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['reports:read'])]
    private ?string $request = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['reports:read'])]
    private ?string $response = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['reports:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['reports:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['reports:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[ORM\JoinColumn(name: '"id_service"', nullable: false)]
    #[Groups(['reports:read'])]
    private ?Service $id_service = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[ORM\JoinColumn(name: '"id_user"', nullable: false)]
    #[Groups(['reports:read'])]
    private ?Users $id_user = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getReport(): ?string
    {
        return $this->report;
    }

    public function setReport(string $report): static
    {
        $this->report = $report;

        return $this;
    }

    public function isError(): ?bool
    {
        return $this->error;
    }

    public function setError(?bool $error): static
    {
        $this->error = $error;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(?string $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): static
    {
        $this->response = $response;

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

    public function getIdUser(): ?users
    {
        return $this->id_user;
    }

    public function setIdUser(?users $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }
}
