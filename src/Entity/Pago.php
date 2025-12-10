<?php

namespace App\Entity;

use App\Repository\PagoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagoRepository::class)]
class Pago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $monto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $metodo_pago = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $fecha_pago = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $estado = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonto(): ?float
    {
        return $this->monto;
    }

    public function setMonto(?float $monto): static
    {
        $this->monto = $monto;

        return $this;
    }

    public function getMetodoPago(): ?string
    {
        return $this->metodo_pago;
    }

    public function setMetodoPago(?string $metodo_pago): static
    {
        $this->metodo_pago = $metodo_pago;

        return $this;
    }

    public function getFechaPago(): ?\DateTime
    {
        return $this->fecha_pago;
    }

    public function setFechaPago(?\DateTime $fecha_pago): static
    {
        $this->fecha_pago = $fecha_pago;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
