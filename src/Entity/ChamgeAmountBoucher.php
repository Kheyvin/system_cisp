<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Types\UuidType;
use App\Repository\ChamgeAmountBoucherRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ChamgeAmountBoucherRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
    normalizationContext: ['groups' => ['chamge_amount_boucher:read']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id_boucher' => 'exact',
])]
class ChamgeAmountBoucher
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['chamge_amount_boucher:read'])]
    private ?Uuid $id;

    #[ORM\Column(name: '"newAmount"', length: 255)]
    #[Groups(['chamge_amount_boucher:read'])]
    private ?string $newAmount = null;

    #[ORM\Column(length: 255)]
    #[Groups(['chamge_amount_boucher:read'])]
    private ?string $currency = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['chamge_amount_boucher:read'])]
    private ?string $description = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['chamge_amount_boucher:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['chamge_amount_boucher:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['chamge_amount_boucher:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Boucher::class, inversedBy: 'chamgeAmountBouchers')]
    #[ORM\JoinColumn(name: '"id_boucher"')]
    #[Groups(['chamge_amount_boucher:read'])]
    private ?Boucher $id_boucher = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getNewAmount(): ?string
    {
        return $this->newAmount;
    }

    public function setNewAmount(?string $newAmount): static
    {
        $this->newAmount = $newAmount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getIdBoucher(): ?Boucher
    {
        return $this->id_boucher;
    }

    public function setIdBoucher(?Boucher $id_boucher): static
    {
        $this->id_boucher = $id_boucher;

        return $this;
    }
}
