<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PaymentsRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: PaymentsRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
    normalizationContext: ['groups' => ['payments:read']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id_boucher' => 'exact',
])]
class Payments
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['payments:read'])]
    private ?Uuid $id;

    #[ORM\Column(type: 'uuid')]
    #[Groups(['payments:read'])]
    private ?Uuid $id_boucher = null;

    #[ORM\Column(length: 255)]
    #[Groups(['payments:read'])]
    private ?string $payment_type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['payments:read'])]
    private ?string $issue_bank = null;

    #[ORM\Column(length: 255)]
    #[Groups(['payments:read'])]
    private ?string $recipient_bank = null;

    #[ORM\Column(length: 255)]
    #[Groups(['payments:read'])]
    private ?string $operation_code = null;

    #[ORM\Column]
    #[Groups(['payments:read'])]
    private ?bool $is_interbank = null;

    #[ORM\Column]
    #[Groups(['payments:read'])]
    private ?\DateTime $payment_date = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['payments:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['payments:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['payments:read'])]
    private ?\DateTime $deletedAt = null;

    /**
     * @var Collection<int, Invoice>
     */
    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: 'id_payment')]
    private Collection $invoices;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getIdBoucher(): ?Uuid
    {
        return $this->id_boucher;
    }

    public function setIdBoucher(Uuid $id_boucher): static
    {
        $this->id_boucher = $id_boucher;

        return $this;
    }

    public function getPaymentType(): ?string
    {
        return $this->payment_type;
    }

    public function setPaymentType(string $payment_type): static
    {
        $this->payment_type = $payment_type;

        return $this;
    }

    public function getIssueBank(): ?string
    {
        return $this->issue_bank;
    }

    public function setIssueBank(string $issue_bank): static
    {
        $this->issue_bank = $issue_bank;

        return $this;
    }

    public function getRecipientBank(): ?string
    {
        return $this->recipient_bank;
    }

    public function setRecipientBank(string $recipient_bank): static
    {
        $this->recipient_bank = $recipient_bank;

        return $this;
    }

    public function getOperationCode(): ?string
    {
        return $this->operation_code;
    }

    public function setOperationCode(string $operation_code): static
    {
        $this->operation_code = $operation_code;

        return $this;
    }

    public function isInterbank(): ?bool
    {
        return $this->is_interbank;
    }

    public function setIsInterbank(bool $is_interbank): static
    {
        $this->is_interbank = $is_interbank;

        return $this;
    }

    public function getPaymentDate(): ?\DateTime
    {
        return $this->payment_date;
    }

    public function setPaymentDate(\DateTime $payment_date): static
    {
        $this->payment_date = $payment_date;

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
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setIdPayment($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getIdPayment() === $this) {
                $invoice->setIdPayment(null);
            }
        }

        return $this;
    }
}
