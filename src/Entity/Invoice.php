<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\InvoiceRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['invoice:read']])]
class Invoice
{
    #[ORM\Id]
    #[ORM\Column(name: '"id_invoice"', type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['invoice:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['invoice:read'])]
    private ?string $serie = null;

    #[ORM\Column]
    #[Groups(['invoice:read'])]
    private ?int $numero = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['invoice:read'])]
    private ?bool $is_error = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['invoice:read'])]
    private ?string $error_message = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['invoice:read'])]
    private ?bool $is_sent_sunat = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['invoice:read'])]
    private ?bool $is_created_invoice_in_sunat = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['invoice:read'])]
    private ?bool $response_success = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['invoice:read'])]
    private ?string $response_message = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['invoice:read'])]
    private ?array $response_sunat_information = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['invoice:read'])]
    private ?string $xml = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['invoice:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['invoice:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['invoice:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Payments::class, inversedBy: 'invoices')]
    #[ORM\JoinColumn(name: '"id_payment"', nullable: false)]
    #[Groups(['invoice:read'])]
    private ?Payments $id_payment = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'invoices')]
    #[ORM\JoinColumn(name: '"id_service"', nullable: false)]
    #[Groups(['invoice:read'])]
    private ?Service $id_service = null;

    #[ORM\ManyToOne(targetEntity: Boucher::class, inversedBy: 'invoices')]
    #[ORM\JoinColumn(name: '"id_boucher"', nullable: false)]
    #[Groups(['invoice:read'])]
    private ?Boucher $id_boucher = null;

    /**
     * @var Collection<int, InvoceDetail>
     */
    #[ORM\OneToMany(targetEntity: InvoceDetail::class, mappedBy: 'id_invoice')]
    private Collection $invoceDetails;

    public function __construct()
    {
        $this->invoceDetails = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function setSerie(string $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function isError(): ?bool
    {
        return $this->is_error;
    }

    public function setIsError(?bool $is_error): static
    {
        $this->is_error = $is_error;

        return $this;
    }

    public function getErrorMessage(): ?string
    {
        return $this->error_message;
    }

    public function setErrorMessage(?string $error_message): static
    {
        $this->error_message = $error_message;

        return $this;
    }

    public function isSentSunat(): ?bool
    {
        return $this->is_sent_sunat;
    }

    public function setIsSentSunat(?bool $is_sent_sunat): static
    {
        $this->is_sent_sunat = $is_sent_sunat;

        return $this;
    }

    public function isCreatedInvoiceInSunat(): ?bool
    {
        return $this->is_created_invoice_in_sunat;
    }

    public function setIsCreatedInvoiceInSunat(?bool $is_created_invoice_in_sunat): static
    {
        $this->is_created_invoice_in_sunat = $is_created_invoice_in_sunat;

        return $this;
    }

    public function isResponseSuccess(): ?bool
    {
        return $this->response_success;
    }

    public function setResponseSuccess(?bool $response_success): static
    {
        $this->response_success = $response_success;

        return $this;
    }

    public function getResponseMessage(): ?string
    {
        return $this->response_message;
    }

    public function setResponseMessage(?string $response_message): static
    {
        $this->response_message = $response_message;

        return $this;
    }

    public function getResponseSunatInformation(): ?array
    {
        return $this->response_sunat_information;
    }

    public function setResponseSunatInformation(?array $response_sunat_information): static
    {
        $this->response_sunat_information = $response_sunat_information;

        return $this;
    }

    public function getXml(): ?string
    {
        return $this->xml;
    }

    public function setXml(?string $xml): static
    {
        $this->xml = $xml;

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

    public function getIdPayment(): ?Payments
    {
        return $this->id_payment;
    }

    public function setIdPayment(?Payments $id_payment): static
    {
        $this->id_payment = $id_payment;

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

    public function getIdBoucher(): ?Boucher
    {
        return $this->id_boucher;
    }

    public function setIdBoucher(?Boucher $id_boucher): static
    {
        $this->id_boucher = $id_boucher;

        return $this;
    }

    /**
     * @return Collection<int, InvoceDetail>
     */
    public function getInvoceDetails(): Collection
    {
        return $this->invoceDetails;
    }

    public function addInvoceDetail(InvoceDetail $invoceDetail): static
    {
        if (!$this->invoceDetails->contains($invoceDetail)) {
            $this->invoceDetails->add($invoceDetail);
            $invoceDetail->setIdInvoice($this);
        }

        return $this;
    }

    public function removeInvoceDetail(InvoceDetail $invoceDetail): static
    {
        if ($this->invoceDetails->removeElement($invoceDetail)) {
            // set the owning side to null (unless already changed)
            if ($invoceDetail->getIdInvoice() === $this) {
                $invoceDetail->setIdInvoice(null);
            }
        }

        return $this;
    }
}
