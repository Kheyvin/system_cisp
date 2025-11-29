<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\DiscontPerDayRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: DiscontPerDayRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['discontspd:read']])]
#[ORM\Table(name: '"discontPerDay"')]
class DiscontPerDay
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?Uuid $id;

    #[ORM\Column(name: 'start_day', type: 'datetime')]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?\DateTime $startDay = null;

    #[ORM\Column(name: 'end_day', type: 'datetime')]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?\DateTime $endDay = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'discontPerDays')]
    #[ORM\JoinColumn(name: '"id_service"', referencedColumnName: 'id', nullable: false)]
    #[Groups(['discontspd:read'])]
    private ?Service $service = null;

    #[ORM\ManyToOne(targetEntity: Boucher::class, inversedBy: 'discontPerDays')]
    #[ORM\JoinColumn(name: '"id_boucher"', referencedColumnName: 'id', nullable: true)]
    #[Groups(['discontspd:read','service:read'])]
    private ?Boucher $boucher = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?string $comment = null;

    #[ORM\Column(name: 'cost_per_day', type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?String $costPerDay = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?String $amount = null;

    #[ORM\Column(name: '"createdAt"', type: 'datetime')]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: 'datetime')]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: 'datetime', nullable: true)]
    #[Groups(['discontspd:read','service:read','boucher:read'])]
    private ?\DateTime $deletedAt = null;

    // Getters and Setters
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getStartDay(): ?\DateTime
    {
        return $this->startDay;
    }

    public function setStartDay(\DateTime $startDay): self
    {
        $this->startDay = $startDay;
        return $this;
    }


    public function getEndDay(): ?\DateTime
    {
        return $this->endDay;
    }

    public function setEndDay(\DateTime $endDay): self
    {
        $this->endDay = $endDay;
        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(Service $service): self
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCostPerDay(): ?float
    {
        return $this->costPerDay;
    }

    public function setCostPerDay(?float $costPerDay): self
    {
        $this->costPerDay = $costPerDay;
        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;
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
