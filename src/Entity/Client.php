<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['client:read']])]
#[ApiResource]
class Client
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['client:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read'])]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read'])]
    private ?string $document_type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read'])]
    private ?string $document_number = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['client:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['client:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['client:read'])]
    private ?\DateTime $deletedAt = null;

    /**
     * @var Collection<int, HistoryClient>
     */
    #[ORM\OneToMany(targetEntity: HistoryClient::class, mappedBy: 'client_id')]
    private Collection $historyClients;

    /**
     * @var Collection<int, Service>
     */
    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'id_client')]
    private Collection $services;

    public function __construct()
    {
        $this->historyClients = new ArrayCollection();
        $this->services = new ArrayCollection();
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

    /**
     * @return Collection<int, HistoryClient>
     */
    public function getHistoryClients(): Collection
    {
        return $this->historyClients;
    }

    public function addHistoryClient(HistoryClient $historyClient): static
    {
        if (!$this->historyClients->contains($historyClient)) {
            $this->historyClients->add($historyClient);
            $historyClient->setClientId($this);
        }

        return $this;
    }

    public function removeHistoryClient(HistoryClient $historyClient): static
    {
        if ($this->historyClients->removeElement($historyClient)) {
            // set the owning side to null (unless already changed)
            if ($historyClient->getClientId() === $this) {
                $historyClient->setClientId(null);
            }
        }

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
            $service->setIdClient($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getIdClient() === $this) {
                $service->setIdClient(null);
            }
        }

        return $this;
    }
}
