<?php

namespace App\Entity;

use App\Entity\PhoneService;
use App\Entity\BoucherConfig;
use App\Entity\DiscontPerDay;
use App\Entity\ContactService;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
    normalizationContext: ['groups' => ['service:read']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'status' => 'exact',
    'id_zone' => 'exact',
    'id_user' => 'exact',
])]

class Service
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['service:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['service:read'])]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['service:read'])]
    private ?\DateTime $installation_date = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['service:read'])]
    private ?int $day_month_invoice = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['service:read'])]
    private ?string $band = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['service:read'])]
    private ?int $contract_number = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['service:read'])]
    private ?int $receipt_number = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['service:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['service:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['service:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'services')]
    #[ORM\JoinColumn(name: '"id_client"', nullable: false)]
    #[Groups(['service:read'])]
    private ?Client $id_client = null;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'services')]
    #[ORM\JoinColumn(name: '"id_zone"', nullable: false)]
    #[Groups(['service:read'])]
    private ?Zone $id_zone = null;
    
    #[ORM\ManyToOne(targetEntity: Technician::class, inversedBy: 'services')]
    #[ORM\JoinColumn(name: '"id_technician"')]
    #[Groups(['service:read'])]
    private ?Technician $id_technician = null;

    /**
     * @var Collection<int, PhoneService>
     */
    #[ORM\OneToMany(targetEntity: PhoneService::class, mappedBy: 'id_service')]
    private Collection $phoneServices;

    /**
     * @var Collection<int, BoucherConfig>
     */
    #[ORM\OneToMany(targetEntity: BoucherConfig::class, mappedBy: 'id_service')]
    private Collection $boucherConfigs;

    /**
     * @var Collection<int, ContactService>
     */
    #[ORM\OneToMany(targetEntity: ContactService::class, mappedBy: 'id_service')]
    private Collection $contactServices;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'id_service')]
    private Collection $comments;

    /**
     * @var Collection<int, Reports>
     */
    #[ORM\OneToMany(targetEntity: Reports::class, mappedBy: 'id_service')]
    private Collection $reports;

    /**
     * @var Collection<int, Boucher>
     */
    #[ORM\OneToMany(targetEntity: Boucher::class, mappedBy: 'id_service')]
    private Collection $bouchers;

    /**
     * @var Collection<int, Invoice>
     */
    #[ORM\OneToMany(targetEntity: Invoice::class, mappedBy: 'id_service')]
    private Collection $invoices;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'id_service')]
    private Collection $tickets;

    /**
     * @var Collection<int, ServicePlan>
     */
    #[ORM\OneToMany(targetEntity: ServicePlan::class, mappedBy: 'id_service')]
    private Collection $servicePlans;

    /**
     * @var Collection<int, DiscontPerDay>
     */
    #[ORM\OneToMany(targetEntity: DiscontPerDay::class, mappedBy: 'service')]
    #[Groups(['service:read'])]
    private Collection $discontPerDays;

    /**
     * @var Collection<int, Charge>
     */
    #[ORM\OneToMany(targetEntity: Charge::class, mappedBy: 'service')]
    #[Groups(['service:read'])]
    private Collection $charges;

    /**
     * @var Collection<int, MkService>
     */
    #[ORM\OneToMany(targetEntity: MkService::class, mappedBy: 'id_service')]
    private Collection $mkServices;

    public function __construct()
    {
        $this->phoneServices = new ArrayCollection();
        $this->boucherConfigs = new ArrayCollection();
        $this->contactServices = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->bouchers = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->servicePlans = new ArrayCollection();
        $this->discontPerDays = new ArrayCollection();
        $this->charges = new ArrayCollection();
        $this->mkServices = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getInstallationDate(): ?\DateTime
    {
        return $this->installation_date;
    }

    public function setInstallationDate(?\DateTime $installation_date): static
    {
        $this->installation_date = $installation_date;

        return $this;
    }

    public function getDayMonthInvoice(): ?int
    {
        return $this->day_month_invoice;
    }

    public function setDayMonthInvoice(?int $day_month_invoice): static
    {
        $this->day_month_invoice = $day_month_invoice;

        return $this;
    }

    public function getBand(): ?string
    {
        return $this->band;
    }

    public function setBand(?string $band): static
    {
        $this->band = $band;

        return $this;
    }

    public function getContractNumber(): ?int
    {
        return $this->contract_number;
    }

    public function setContractNumber(?int $contract_number): static
    {
        $this->contract_number = $contract_number;

        return $this;
    }

    public function getReceiptNumber(): ?int
    {
        return $this->receipt_number;
    }

    public function setReceiptNumber(?int $receipt_number): static
    {
        $this->receipt_number = $receipt_number;

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

        public function getIdClient(): ?client
    {
        return $this->id_client;
    }

    public function setIdClient(?client $id_client): static
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getIdZone(): ?zone
    {
        return $this->id_zone;
    }

    public function setIdZone(?zone $id_zone): static
    {
        $this->id_zone = $id_zone;

        return $this;
    }

    /**
     * @return Collection<int, PhoneService>
     */
    public function getPhoneServices(): Collection
    {
        return $this->phoneServices;
    }

    public function addPhoneService(PhoneService $phoneService): static
    {
        if (!$this->phoneServices->contains($phoneService)) {
            $this->phoneServices->add($phoneService);
            $phoneService->setIdService($this);
        }

        return $this;
    }

    public function removePhoneService(PhoneService $phoneService): static
    {
        if ($this->phoneServices->removeElement($phoneService)) {
            // set the owning side to null (unless already changed)
            if ($phoneService->getIdService() === $this) {
                $phoneService->setIdService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoucherConfig>
     */
    public function getBoucherConfigs(): Collection
    {
        return $this->boucherConfigs;
    }

    public function addBoucherConfig(BoucherConfig $boucherConfig): static
    {
        if (!$this->boucherConfigs->contains($boucherConfig)) {
            $this->boucherConfigs->add($boucherConfig);
            $boucherConfig->setIdService($this);
        }

        return $this;
    }

    public function removeBoucherConfig(BoucherConfig $boucherConfig): static
    {
        if ($this->boucherConfigs->removeElement($boucherConfig)) {
            // set the owning side to null (unless already changed)
            if ($boucherConfig->getIdService() === $this) {
                $boucherConfig->setIdService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContactService>
     */
    public function getContactServices(): Collection
    {
        return $this->contactServices;
    }

    public function addContactService(ContactService $contactService): static
    {
        if (!$this->contactServices->contains($contactService)) {
            $this->contactServices->add($contactService);
            $contactService->setIdService($this);
        }

        return $this;
    }

    public function removeContactService(ContactService $contactService): static
    {
        if ($this->contactServices->removeElement($contactService)) {
            // set the owning side to null (unless already changed)
            if ($contactService->getIdService() === $this) {
                $contactService->setIdService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setIdService($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getIdService() === $this) {
                $comment->setIdService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reports>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Reports $report): static
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setIdService($this);
        }

        return $this;
    }

    public function removeReport(Reports $report): static
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getIdService() === $this) {
                $report->setIdService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Boucher>
     */
    public function getBouchers(): Collection
    {
        return $this->bouchers;
    }

    public function addBoucher(Boucher $boucher): static
    {
        if (!$this->bouchers->contains($boucher)) {
            $this->bouchers->add($boucher);
            $boucher->setIdService($this);
        }

        return $this;
    }

    public function removeBoucher(Boucher $boucher): static
    {
        if ($this->bouchers->removeElement($boucher)) {
            // set the owning side to null (unless already changed)
            if ($boucher->getIdService() === $this) {
                $boucher->setIdService(null);
            }
        }

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
            $invoice->setIdService($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getIdService() === $this) {
                $invoice->setIdService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setIdService($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getIdService() === $this) {
                $ticket->setIdService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ServicePlan>
     */
    public function getServicePlans(): Collection
    {
        return $this->servicePlans;
    }

    public function addServicePlan(ServicePlan $servicePlan): static
    {
        if (!$this->servicePlans->contains($servicePlan)) {
            $this->servicePlans->add($servicePlan);
            $servicePlan->setIdService($this);
        }

        return $this;
    }

    public function removeServicePlan(ServicePlan $servicePlan): static
    {
        if ($this->servicePlans->removeElement($servicePlan)) {
            // set the owning side to null (unless already changed)
            if ($servicePlan->getIdService() === $this) {
                $servicePlan->setIdService(null);
            }
        }

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

    public function getDiscontPerDays(): Collection
    {
        return $this->discontPerDays;
    }

    public function addDiscontPerDay(DiscontPerDay $discontPerDay): static
    {
        if (!$this->discontPerDays->contains($discontPerDay)) {
            $this->discontPerDays->add($discontPerDay);
            $discontPerDay->setService($this);
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
            $charge->setService($this);
        }

        return $this;
    }

    public function removeCharge(Charge $charge): self
    {
        if ($this->charges->removeElement($charge)) {
            // set the owning side to null (unless already changed)
            if ($charge->getService() === $this) {
                $charge->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MkService>
     */
    public function getMkServices(): Collection
    {
        return $this->mkServices;
    }

    public function addMkService(MkService $mkService): static
    {
        if (!$this->mkServices->contains($mkService)) {
            $this->mkServices->add($mkService);
            $mkService->setIdService($this);
        }

        return $this;
    }

    public function removeMkService(MkService $mkService): static
    {
        if ($this->mkServices->removeElement($mkService)) {
            // set the owning side to null (unless already changed)
            if ($mkService->getIdService() === $this) {
                $mkService->setIdService(null);
            }
        }

        return $this;
    }

}