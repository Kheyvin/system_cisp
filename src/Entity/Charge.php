<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ChargeRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ChargeRepository::class)]
#[ORM\Table(name: 'charges')]
#[ApiResource(normalizationContext: ['groups' => ['charge:read']])]
class Charge
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['charge:read','service:read','chargeType:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(name: 'charge_date', type: 'datetime')]
    #[Groups(['charge:read','service:read','chargeType:read'])]
    private ?\DateTime $chargeDate = null;

    #[ORM\ManyToOne(targetEntity: ChargeType::class)]
    #[ORM\JoinColumn(name: '"id_charge_type"', nullable: false)]
    #[Groups(['charge:read','service:read'])]
    private ?ChargeType $chargeType = null;

    #[ORM\Column(name: 'comment', type: 'string', length: 255, nullable: true)]
    #[Groups(['charge:read','service:read','chargeType:read'])]
    private ?string $comment = null;

    #[ORM\Column(name: 'amount', type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['charge:read','service:read','chargeType:read'])]
    private ?string $amount = null;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: '"id_service"', referencedColumnName: 'id', nullable: false)]
    #[Groups(['charge:read','chargeType:read'])]
    private ?Service $service = null;

    #[ORM\ManyToOne(targetEntity: Boucher::class)]
    #[ORM\JoinColumn(name: '"id_boucher"', referencedColumnName: 'id', nullable: true)]
    #[Groups(['charge:read','service:read','chargeType:read'])]
    private ?Boucher $boucher = null;

    #[ORM\Column(name: '"createdAt"', type: 'datetime')]
    #[Groups(['charge:read','service:read','chargeType:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: 'datetime')]
    #[Groups(['charge:read','service:read','chargeType:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: 'datetime', nullable: true)]
    #[Groups(['charge:read','service:read','chargeType:read'])]
    private ?\DateTime $deletedAt = null;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->chargeDate = new \DateTime();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    // Getters and Setters
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getChargeDate(): ?\DateTime
    {
        return $this->chargeDate;
    }

    public function setChargeDate(\DateTime $chargeDate): self
    {
        $this->chargeDate = $chargeDate;
        return $this;
    }

    public function getChargeType(): ?ChargeType
    {
        return $this->chargeType;
    }

    public function setChargeType(?ChargeType $chargeType): self
    {
        $this->chargeType = $chargeType;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;
        return $this;
    }

    public function getBoucher(): ?Boucher
    {
        return $this->boucher;
    }

    public function setBoucher(?Boucher $boucher): self
    {
        $this->boucher = $boucher;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}
