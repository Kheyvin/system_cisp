<?php

namespace App\Entity;

use App\Repository\SolicitudRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolicitudRepository::class)]
class Solicitud
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $asunto = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prioridad = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notas_resolucion = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $fecha_creacion = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $fecha_actualizacion = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $fecha_cierre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getAsunto(): ?string
    {
        return $this->asunto;
    }

    public function setAsunto(?string $asunto): static
    {
        $this->asunto = $asunto;

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

    public function getPrioridad(): ?string
    {
        return $this->prioridad;
    }

    public function setPrioridad(?string $prioridad): static
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    public function getNotasResolucion(): ?string
    {
        return $this->notas_resolucion;
    }

    public function setNotasResolucion(?string $notas_resolucion): static
    {
        $this->notas_resolucion = $notas_resolucion;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTime
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(?\DateTime $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getFechaActualizacion(): ?\DateTime
    {
        return $this->fecha_actualizacion;
    }

    public function setFechaActualizacion(?\DateTime $fecha_actualizacion): static
    {
        $this->fecha_actualizacion = $fecha_actualizacion;

        return $this;
    }

    public function getFechaCierre(): ?\DateTime
    {
        return $this->fecha_cierre;
    }

    public function setFechaCierre(?\DateTime $fecha_cierre): static
    {
        $this->fecha_cierre = $fecha_cierre;

        return $this;
    }
}
