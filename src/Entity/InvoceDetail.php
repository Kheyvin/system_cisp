<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\InvoceDetailRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: InvoceDetailRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['invoce_detail:read']])]
#[ORM\Table(name: '"invoce-detail"')]
class InvoceDetail
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['invoce_detail:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['invoce_detail:read'])]
    private ?string $tipo_documento = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoce_detail:read'])]
    private ?string $serie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoce_detail:read'])]
    private ?string $numero = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoce_detail:read'])]
    private ?string $tipo_operacion = null;

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private ?\DateTime $fecha_de_emision = null;

    #[ORM\Column(length: 255)]
    #[Groups(['invoce_detail:read'])]
    private ?string $moneda = null;

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private ?int $porcentaje_de_venta = null;

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private ?bool $enviar_automaticamente_al_cliente = null;

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private array $datos_del_emisor = [];

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private array $cliente = [];

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private array $totales = [];

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private array $items = [];

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private array $acciones = [];

    #[ORM\Column]
    #[Groups(['invoce_detail:read'])]
    private array $termino_de_pago = [];

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['invoce_detail:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['invoce_detail:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['invoce_detail:read'])]
    private ?\DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'invoceDetails')]
    #[ORM\JoinColumn(name: '"id_invoice"', referencedColumnName: '"id_invoice"', nullable: false)]
    #[Groups(['invoce_detail:read'])]
    private ?Invoice $id_invoice = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTipoDocumento(): ?string
    {
        return $this->tipo_documento;
    }

    public function setTipoDocumento(string $tipo_documento): static
    {
        $this->tipo_documento = $tipo_documento;

        return $this;
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

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTipoOperacion(): ?string
    {
        return $this->tipo_operacion;
    }

    public function setTipoOperacion(string $tipo_operacion): static
    {
        $this->tipo_operacion = $tipo_operacion;

        return $this;
    }

    public function getFechaDeEmision(): ?\DateTime
    {
        return $this->fecha_de_emision;
    }

    public function setFechaDeEmision(\DateTime $fecha_de_emision): static
    {
        $this->fecha_de_emision = $fecha_de_emision;

        return $this;
    }

    public function getMoneda(): ?string
    {
        return $this->moneda;
    }

    public function setMoneda(string $moneda): static
    {
        $this->moneda = $moneda;

        return $this;
    }

    public function getPorcentajeDeVenta(): ?int
    {
        return $this->porcentaje_de_venta;
    }

    public function setPorcentajeDeVenta(int $porcentaje_de_venta): static
    {
        $this->porcentaje_de_venta = $porcentaje_de_venta;

        return $this;
    }

    public function isEnviarAutomaticamenteAlCliente(): ?bool
    {
        return $this->enviar_automaticamente_al_cliente;
    }

    public function setEnviarAutomaticamenteAlCliente(bool $enviar_automaticamente_al_cliente): static
    {
        $this->enviar_automaticamente_al_cliente = $enviar_automaticamente_al_cliente;

        return $this;
    }

    public function getDatosDelEmisor(): array
    {
        return $this->datos_del_emisor;
    }

    public function setDatosDelEmisor(array $datos_del_emisor): static
    {
        $this->datos_del_emisor = $datos_del_emisor;

        return $this;
    }

    public function getCliente(): array
    {
        return $this->cliente;
    }

    public function setCliente(array $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getTotales(): array
    {
        return $this->totales;
    }

    public function setTotales(array $totales): static
    {
        $this->totales = $totales;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function getAcciones(): array
    {
        return $this->acciones;
    }

    public function setAcciones(array $acciones): static
    {
        $this->acciones = $acciones;

        return $this;
    }

    public function getTerminoDePago(): array
    {
        return $this->termino_de_pago;
    }

    public function setTerminoDePago(array $termino_de_pago): static
    {
        $this->termino_de_pago = $termino_de_pago;

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

    public function getIdInvoice(): ?Invoice
    {
        return $this->id_invoice;
    }

    public function setIdInvoice(?Invoice $id_invoice): static
    {
        $this->id_invoice = $id_invoice;

        return $this;
    }
}
