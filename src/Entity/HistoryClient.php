<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\HistoryClientRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: HistoryClientRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['history_client:read']])]
class HistoryClient
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['history_client:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['history_client:read'])]
    private ?string $field_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['history_client:read'])]
    private ?string $old_value = null;

    #[ORM\Column(length: 255)]
    #[Groups(['history_client:read'])]
    private ?string $new_value = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['history_client:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['history_client:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['history_client:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(inversedBy: 'historyClients')]
    #[ORM\JoinColumn(name: '"client_id"',nullable: false)]
    #[Groups(['history_client:read'])]
    private ?Client $client_id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getFieldName(): ?string
    {
        return $this->field_name;
    }

    public function setFieldName(string $field_name): static
    {
        $this->field_name = $field_name;

        return $this;
    }

    public function getOldValue(): ?string
    {
        return $this->old_value;
    }

    public function setOldValue(string $old_value): static
    {
        $this->old_value = $old_value;

        return $this;
    }

    public function getNewValue(): ?string
    {
        return $this->new_value;
    }

    public function setNewValue(string $new_value): static
    {
        $this->new_value = $new_value;

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

    public function getClientId(): ?client
    {
        return $this->client_id;
    }

    public function setClientId(?client $client_id): static
    {
        $this->client_id = $client_id;

        return $this;
    }
}
