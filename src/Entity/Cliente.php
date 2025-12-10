<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellido = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo_documento = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero_documento = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correo = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $celular = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto_perfil = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $fecha_registro = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $estado = null;

    /**
     * @var Collection<int, Notificacion>
     */
    #[ORM\OneToMany(targetEntity: Notificacion::class, mappedBy: 'cliente')]
    private Collection $notificacions;

    public function __construct()
    {
        $this->notificacions = new ArrayCollection();
    }

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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getTipoDocumento(): ?string
    {
        return $this->tipo_documento;
    }

    public function setTipoDocumento(?string $tipo_documento): static
    {
        $this->tipo_documento = $tipo_documento;

        return $this;
    }

    public function getNumeroDocumento(): ?string
    {
        return $this->numero_documento;
    }

    public function setNumeroDocumento(?string $numero_documento): static
    {
        $this->numero_documento = $numero_documento;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): static
    {
        $this->correo = $correo;

        return $this;
    }

    public function getCelular(): ?string
    {
        return $this->celular;
    }

    public function setCelular(?string $celular): static
    {
        $this->celular = $celular;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getFotoPerfil(): ?string
    {
        return $this->foto_perfil;
    }

    public function setFotoPerfil(?string $foto_perfil): static
    {
        $this->foto_perfil = $foto_perfil;

        return $this;
    }

    public function getFechaRegistro(): ?\DateTime
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro(?\DateTime $fecha_registro): static
    {
        $this->fecha_registro = $fecha_registro;

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

    /**
     * @return Collection<int, Notificacion>
     */
    public function getNotificacions(): Collection
    {
        return $this->notificacions;
    }

    public function addNotificacion(Notificacion $notificacion): static
    {
        if (!$this->notificacions->contains($notificacion)) {
            $this->notificacions->add($notificacion);
            $notificacion->setCliente($this);
        }

        return $this;
    }

    public function removeNotificacion(Notificacion $notificacion): static
    {
        if ($this->notificacions->removeElement($notificacion)) {
            // set the owning side to null (unless already changed)
            if ($notificacion->getCliente() === $this) {
                $notificacion->setCliente(null);
            }
        }

        return $this;
    }
}
