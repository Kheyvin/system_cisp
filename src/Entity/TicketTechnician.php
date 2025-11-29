<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Types\UuidType;
use App\Repository\TicketTechnicianRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: TicketTechnicianRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
    normalizationContext: ['groups' => ['ticket_technician:read']]
)]
class TicketTechnician
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['ticket_technician:read'])]
    private ?Uuid $id;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['ticket_technician:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['ticket_technician:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['ticket_technician:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: 'ticketTechnicians')]
    #[ORM\JoinColumn(name: '"id_ticket"')]
    #[Groups(['ticket_technician:read'])]
    private ?Ticket $id_ticket = null;

    #[ORM\ManyToOne(targetEntity: Technician::class, inversedBy: 'ticketTechnicians')]
    #[ORM\JoinColumn(name: '"id_technician"')]
    #[Groups(['ticket_technician:read'])]
    private ?Technician $id_technician = null;

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getIdTicket(): ?Ticket
    {
        return $this->id_ticket;
    }

    public function setIdTicket(?Ticket $id_ticket): static
    {
        $this->id_ticket = $id_ticket;

        return $this;
    }

    public function getIdTechnician(): ?Technician
    {
        return $this->id_technician;
    }

    public function setIdTechnician(?Technician $id_technician): static
    {
        $this->id_technician = $id_technician;

        return $this;
    }
}
