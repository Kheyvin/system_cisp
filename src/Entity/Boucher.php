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
use App\Repository\BoucherRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: BoucherRepository::class)]
#[ApiResource(
    order: ['issue_date' => 'DESC'],
    normalizationContext: ['groups' => ['boucher:read']])]
#[ApiFilter(SearchFilter::class, properties: [
    'id_service' => 'exact',
    'state' => 'exact',
    'issue_date' => 'exact',
])]
class Boucher
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['boucher:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['boucher:read'])]
    private ?string $document_type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boucher:read'])]
    private ?string $correlative = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boucher:read'])]
    private ?string $currency = null;

    #[ORM\Column]
    #[Groups(['boucher:read'])]
    private ?\DateTime $issue_date = null;

    #[ORM\Column]
    #[Groups(['boucher:read'])]
    private ?\DateTime $expiration_date = null;

    #[ORM\Column]
    #[Groups(['boucher:read'])]
    private ?int $amount = null;

    #[ORM\Column(length: 255)]
    #[Groups(['boucher:read'])]
    private ?string $state = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['boucher:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['boucher:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['boucher:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'bouchers')]
    #[ORM\JoinColumn(name: '"id_service"', nullable: false)]
    #[Groups(['boucher:read'])]
    private ?Service $id_service = null;

    #[ORM\ManyToOne(targetEntity: DetailPlan::class, inversedBy: 'bouchers')]
    #[ORM\JoinColumn(name: '"id_detail_plan"', nullable: false)]
    #[Groups(['boucher:read'])]
    private ?DetailPlan $id_detail_plan = null;

    /**
     * @var Collection<int, Invoice>
     */
    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: 'id_boucher')]
    private Collection $invoices;

    /**
     * @var Collection<int, DiscontPerDay>
     */
     #[ORM\OneToMany(targetEntity: DiscontPerDay::class, mappedBy: 'boucher')]
    private Collection $discontPerDays;

    /**
     * @var Collection<int, Charge>
     */
    #[ORM\OneToMany(targetEntity: Charge::class, mappedBy: 'boucher')]
    private Collection $charges;

    /**
     * @var Collection<int, ChamgeAmountBoucher>
     */
    #[ORM\OneToMany(targetEntity: ChamgeAmountBoucher::class, mappedBy: 'id_boucher')]
    private Collection $chamgeAmountBouchers;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->discontPerDays = new ArrayCollection();
        $this->charges = new ArrayCollection();
        $this->chamgeAmountBouchers = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getCorrelative(): ?string
    {
        return $this->correlative;
    }

    public function setCorrelative(string $correlative): static
    {
        $this->correlative = $correlative;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getIssueDate(): ?\DateTime
    {
        return $this->issue_date;
    }

    public function setIssueDate(\DateTime $issue_date): static
    {
        $this->issue_date = $issue_date;

        return $this;
    }

    public function getExpirationDate(): ?\DateTime
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTime $expiration_date): static
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

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

    public function getIdService(): ?Service
    {
        return $this->id_service;
    }

    public function setIdService(?Service $id_service): static
    {
        $this->id_service = $id_service;

        return $this;
    }

    public function getIdDetailPlan(): ?DetailPlan
    {
        return $this->id_detail_plan;
    }

    public function setIdDetailPlan(?DetailPlan $id_detail_plan): static
    {
        $this->id_detail_plan = $id_detail_plan;

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
            $invoice->setIdBoucher($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getIdBoucher() === $this) {
                $invoice->setIdBoucher(null);
            }
        }

        return $this;
    }

    public function getDiscontPerDays(): Collection
    {
        return $this->discontPerDays;
    }

    public function addDiscontPerDay(DiscontPerDay $discontPerDay): static
    {
        if (!$this->discontPerDays->contains($discontPerDay)) {
            $this->discontPerDays->add($discontPerDay);
            $discontPerDay->setBoucher($this);
        }

        return $this;
    }

    public function removeDiscontPerDay(DiscontPerDay $discontPerDay): static
    {
        if ($this->discontPerDays->removeElement($discontPerDay)) {
            // set the owning side to null (unless already changed)
            if ($discontPerDay->getBoucher() === $this) {
                $discontPerDay->setBoucher(null);
            }
        }

        return $this;
    }

    public function getCharges(): Collection
    {
        return $this->charges;
    }

    public function addCharge(Charge $charge): self
    {
        if (!$this->charges->contains($charge)) {
            $this->charges->add($charge);
            $charge->setBoucher($this);
        }

        return $this;
    }

    public function removeCharge(Charge $charge): self
    {
        if ($this->charges->removeElement($charge)) {
            // set the owning side to null (unless already changed)
            if ($charge->getBoucher() === $this) {
                $charge->setBoucher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChamgeAmountBoucher>
     */
    public function getChamgeAmountBouchers(): Collection
    {
        return $this->chamgeAmountBouchers;
    }

    public function addChamgeAmountBoucher(ChamgeAmountBoucher $chamgeAmountBoucher): static
    {
        if (!$this->chamgeAmountBouchers->contains($chamgeAmountBoucher)) {
            $this->chamgeAmountBouchers->add($chamgeAmountBoucher);
            $chamgeAmountBoucher->setIdBoucher($this);
        }

        return $this;
    }

    public function removeChamgeAmountBoucher(ChamgeAmountBoucher $chamgeAmountBoucher): static
    {
        if ($this->chamgeAmountBouchers->removeElement($chamgeAmountBoucher)) {
            // set the owning side to null (unless already changed)
            if ($chamgeAmountBoucher->getIdBoucher() === $this) {
                $chamgeAmountBoucher->setIdBoucher(null);
            }
        }

        return $this;
    }
}
