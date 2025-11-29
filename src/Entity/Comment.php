<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommentRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
    normalizationContext: ['groups' => ['comment:read']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id_service' => 'exact',
])]
class Comment
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['comment:read']) ]
    private ?Uuid $id;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['comment:read'])]
    private ?string $message = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['comment:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['comment:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['comment:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(name: '"id_service"',nullable: false)]
    #[Groups(['comment:read'])]
    private ?Service $id_service = null;

    #[ORM\ManyToOne(targetEntity: TypeOfComment::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(name: '"id_type_of_comment"',nullable: false)]
    #[Groups(['comment:read'])]
    private ?Typeofcomment $id_type_of_comment = null;

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function setDeletedAt(\DateTime $deletedAt): static
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

    public function getIdTypeOfComment(): ?typeofcomment
    {
        return $this->id_type_of_comment;
    }

    public function setIdTypeOfComment(?typeofcomment $id_type_of_comment): static
    {
        $this->id_type_of_comment = $id_type_of_comment;

        return $this;
    }
}
