<?php

namespace App\Entity;

use App\Repository\NotificacionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificacionRepository::class)]
class Notificacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mensaje = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enviado_por = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $fecha_creacion = null;

    #[ORM\ManyToOne(inversedBy: 'notificacions')]
    private ?Cliente $cliente = null;

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

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    public function setMensaje(?string $mensaje): static
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    public function getEnviadoPor(): ?string
    {
        return $this->enviado_por;
    }

    public function setEnviadoPor(?string $enviado_por): static
    {
        $this->enviado_por = $enviado_por;

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

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }
}
