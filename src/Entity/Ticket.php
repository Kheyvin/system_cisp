<?php

namespace App\Entity;

use App\Entity\Service;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use App\Entity\TicketTechnician;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\TicketRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
    normalizationContext: ['groups' => ['ticket:read']])]
#[ApiFilter(SearchFilter::class, properties: [
    'id_service' => 'exact',
    'code' => 'partial',
])]
class Ticket
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['ticket:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read'])]
    private ?string $subject = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read'])]
    private ?string $id_user = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read'])]
    private ?string $observations = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read'])]
    private ?string $area = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read'])]
    private ?string $service_type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read'])]
    private ?string $priority = null;

    #[ORM\Column]
    #[Groups(['ticket:read'])]
    private ?\DateTime $technical_visit_date = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['ticket:read'])]
    private ?\DateTime $expiration_date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read'])]
    private ?string $state = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ticket:read'])]
    private ?string $code = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['ticket:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['ticket:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['ticket:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(name: '"id_service"', nullable: false)]
    #[Groups(['ticket:read'])]
    private ?Service $id_service = null;

    /**
     * @var Collection<int, TicketTechnician>
     */
    #[ORM\OneToMany(targetEntity: TicketTechnician::class, mappedBy: 'id_ticket')]
    private Collection $ticketTechnicians;

    public function __construct()
    {
        $this->ticketTechnicians = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getIdUser(): ?string
    {
        return $this->id_user;
    }

    public function setIdUser(string $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(string $observations): static
    {
        $this->observations = $observations;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): static
    {
        $this->area = $area;

        return $this;
    }

    public function getServiceType(): ?string
    {
        return $this->service_type;
    }

    public function setServiceType(string $service_type): static
    {
        $this->service_type = $service_type;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getTechnicalVisitDate(): ?\DateTime
    {
        return $this->technical_visit_date;
    }

    public function setTechnicalVisitDate(\DateTime $technical_visit_date): static
    {
        $this->technical_visit_date = $technical_visit_date;

        return $this;
    }

    public function getExpirationDate(): ?\DateTime
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(?\DateTime $expiration_date): static
    {
        $this->expiration_date = $expiration_date;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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

    public function getIdService(): ?Service
    {
        return $this->id_service;
    }

    public function setIdService(?Service $id_service): static
    {
        $this->id_service = $id_service;

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
            $ticketTechnician->setIdTicket($this);
        }

        return $this;
    }

    public function removeTicketTechnician(TicketTechnician $ticketTechnician): static
    {
        if ($this->ticketTechnicians->removeElement($ticketTechnician)) {
            // set the owning side to null (unless already changed)
            if ($ticketTechnician->getIdTicket() === $this) {
                $ticketTechnician->setIdTicket(null);
            }
        }

        return $this;
    }
}
