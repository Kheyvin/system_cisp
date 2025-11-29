<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\TechnicianRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: TechnicianRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['technician:read']])]
class Technician
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['technician:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['technician:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['technician:read'])]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['technician:read'])]
    private ?string $document_type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['technician:read'])]
    private ?string $document_number = null;

    #[ORM\Column(length: 255)]
    #[Groups(['technician:read'])]
    private ?string $state = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['technician:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['technician:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['technician:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'technicians')]
    #[ORM\JoinColumn(name: '"id_user"', nullable: false)]
    #[Groups(['technician:read'])]
    private ?Users $id_user = null;

    /**
     * @var Collection<int, Service>
     */
    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'id_technician')]
    private Collection $services;

    /**
     * @var Collection<int, TicketTechnician>
     */
    #[ORM\OneToMany(targetEntity: TicketTechnician::class, mappedBy: 'id_technician')]
    private Collection $ticketTechnicians;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->ticketTechnicians = new ArrayCollection();
    }

    public function getId(): ?Uuid
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

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getDocumentType(): ?string
    {
        return $this->document_type;
    }

    public function setDocumentType(string $document_type): static
    {
        $this->document_type = $document_type;

        return $this;
    }

    public function getDocumentNumber(): ?string
    {
        return $this->document_number;
    }

    public function setDocumentNumber(string $document_number): static
    {
        $this->document_number = $document_number;

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

    public function getIdUser(): ?Users
    {
        return $this->id_user;
    }

    public function setIdUser(?Users $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setIdTechnician($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getIdTechnician() === $this) {
                $service->setIdTechnician(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TicketTechnician>
     */
    public function getTicketTechnicians(): Collection
    {
        return $this->ticketTechnicians;
    }

    public function addTicketTechnician(TicketTechnician $ticketTechnician): static
    {
        if (!$this->ticketTechnicians->contains($ticketTechnician)) {
            $this->ticketTechnicians->add($ticketTechnician);
            $ticketTechnician->setIdTechnician($this);
        }

        return $this;
    }

    public function removeTicketTechnician(TicketTechnician $ticketTechnician): static
    {
        if ($this->ticketTechnicians->removeElement($ticketTechnician)) {
            // set the owning side to null (unless already changed)
            if ($ticketTechnician->getIdTechnician() === $this) {
                $ticketTechnician->setIdTechnician(null);
            }
        }

        return $this;
    }
}
