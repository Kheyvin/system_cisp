<?php

namespace App\Entity;

use App\Repository\ServicioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicioRepository::class)]
class Servicio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $direccion_instalacion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_contrato = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $fecha_instalacion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $estado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccionInstalacion(): ?string
    {
        return $this->direccion_instalacion;
    }

    public function setDireccionInstalacion(?string $direccion_instalacion): static
    {
        $this->direccion_instalacion = $direccion_instalacion;

        return $this;
    }

    public function getNumeroContrato(): ?string
    {
        return $this->numero_contrato;
    }

    public function setNumeroContrato(?string $numero_contrato): static
    {
        $this->numero_contrato = $numero_contrato;

        return $this;
    }

    public function getFechaInstalacion(): ?\DateTime
    {
        return $this->fecha_instalacion;
    }

    public function setFechaInstalacion(?\DateTime $fecha_instalacion): static
    {
        $this->fecha_instalacion = $fecha_instalacion;

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
}
