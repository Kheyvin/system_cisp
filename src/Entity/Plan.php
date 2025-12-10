<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
#[ORM\Table(name: '`plan`')]
class Plan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(nullable: true)]
    private ?int $velocidad_mbps = null;

    #[ORM\Column(nullable: true)]
    private ?float $precio_regular = null;

    #[ORM\Column(nullable: true)]
    private ?float $precio_promocional = null;

    #[ORM\Column(nullable: true)]
    private ?int $porcentaje_descuento = null;

    #[ORM\Column]
    private array $caracteristicas = [];

    #[ORM\Column(nullable: true)]
    private ?bool $activo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getVelocidadMbps(): ?int
    {
        return $this->velocidad_mbps;
    }

    public function setVelocidadMbps(?int $velocidad_mbps): static
    {
        $this->velocidad_mbps = $velocidad_mbps;

        return $this;
    }

    public function getPrecioRegular(): ?float
    {
        return $this->precio_regular;
    }

    public function setPrecioRegular(?float $precio_regular): static
    {
        $this->precio_regular = $precio_regular;

        return $this;
    }

    public function getPrecioPromocional(): ?float
    {
        return $this->precio_promocional;
    }

    public function setPrecioPromocional(?float $precio_promocional): static
    {
        $this->precio_promocional = $precio_promocional;

        return $this;
    }

    public function getPorcentajeDescuento(): ?int
    {
        return $this->porcentaje_descuento;
    }

    public function setPorcentajeDescuento(?int $porcentaje_descuento): static
    {
        $this->porcentaje_descuento = $porcentaje_descuento;

        return $this;
    }

    public function getCaracteristicas(): array
    {
        return $this->caracteristicas;
    }

    public function setCaracteristicas(array $caracteristicas): static
    {
        $this->caracteristicas = $caracteristicas;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(?bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }
}
