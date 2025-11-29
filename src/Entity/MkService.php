<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MkServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MkServiceRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['mk_service:read']])]
class MkService
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['mk_service:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mk_service:read'])]
    private ?string $name_mk = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['mk_service:read'])]
    private ?string $id_mk = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mk_service:read'])]
    private ?string $password_mk = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mk_service:read'])]
    private ?string $comment_mk = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mk_service:read'])]
    private ?string $plan_mk = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['mk_service:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['mk_service:read'])]
    private ?\DateTime $updateAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['mk_service:read'])]
    private ?\DateTime $deleteAt = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'mkServices')]
    #[ORM\JoinColumn(name: '"id_service"', nullable: false)]
    #[Groups(['mk_service:read'])]
    private ?Service $id_service = null;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'mkServices')]
    #[ORM\JoinColumn(name: '"id_zone"',nullable: false)]
    #[Groups(['mk_service:read'])]
    private ?Zone $id_zone = null;

    #[ORM\ManyToOne(targetEntity: Mikrotik::class, inversedBy: 'mkServices')]
    #[ORM\JoinColumn(name: '"id_mikrotik"',nullable: false)]
    // #[Groups(['mk_service:read'])]
    private ?Mikrotik $id_mikrotik = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getNameMk(): ?string
    {
        return $this->name_mk;
    }

    public function setNameMk(string $name_mk): static
    {
        $this->name_mk = $name_mk;

        return $this;
    }

    public function getIdMk(): ?string
    {
        return $this->id_mk;
    }

    public function setIdMk(?string $id_mk): static
    {
        $this->id_mk = $id_mk;

        return $this;
    }

    public function getPasswordMk(): ?string
    {
        return $this->password_mk;
    }

    public function setPasswordMk(string $password_mk): static
    {
        $this->password_mk = $password_mk;

        return $this;
    }

    public function getCommentMk(): ?string
    {
        return $this->comment_mk;
    }

    public function setCommentMk(string $comment_mk): static
    {
        $this->comment_mk = $comment_mk;

        return $this;
    }

    public function getPlanMk(): ?string
    {
        return $this->plan_mk;
    }

    public function setPlanMk(string $plan_mk): static
    {
        $this->plan_mk = $plan_mk;

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

    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTime $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getDeleteAt(): ?\DateTime
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTime $deleteAt): static
    {
        $this->deleteAt = $deleteAt;

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

    public function getIdZone(): ?Zone
    {
        return $this->id_zone;
    }

    public function setIdZone(?Zone $id_zone): static
    {
        $this->id_zone = $id_zone;

        return $this;
    }

    public function getIdMikrotik(): ?Mikrotik
    {
        return $this->id_mikrotik;
    }

    public function setIdMikrotik(?Mikrotik $id_mikrotik): static
    {
        $this->id_mikrotik = $id_mikrotik;

        return $this;
    }
}
