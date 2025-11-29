<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MikrotikRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MikrotikRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['mikrotik:read']])]
class Mikrotik
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['mikrotik:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(name: '"name"', length: 255)]
    #[Groups(['mikrotik:read'])]
    private ?string $name = null;

    #[ORM\Column(name: '"IP"', length: 255)]
    #[Groups(['mikrotik:read'])]
    private ?string $ip = null;

    #[ORM\Column(name: '"user"',length: 255)]
    #[Groups(['mikrotik:read'])] 
    private ?string $usuario = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mikrotik:read'])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mikrotik:read'])]
    private ?string $port = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['mk_service:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['mk_service:read'])]
    private ?\DateTime $updateAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['mk_service:read'])]
    private ?\DateTime $deleteAt = null;

    /**
     * @var Collection<int, MkService>
     */
    #[ORM\OneToMany(targetEntity: MkService::class, mappedBy: 'id_mikrotik')]
    #[Groups(['mk_service:read'])]
    private Collection $mkServices;

    /**
     * @var Collection<int, Zone>
     */
    #[ORM\OneToMany(targetEntity: Zone::class, mappedBy: 'id_mikrotik')]
    #[Groups(['mk_service:read'])]
    private Collection $zones;

    public function __construct()
    {
        $this->mkServices = new ArrayCollection();
        $this->zones = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPort(): ?string
    {
        return $this->port;
    }

    public function setPort(string $port): static
    {
        $this->port = $port;

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

    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTime $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getDeleteAt(): ?\DateTime
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTime $deleteAt): static
    {
        $this->deleteAt = $deleteAt;

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
            $mkService->setIdMikrotik($this);
        }

        return $this;
    }

    public function removeMkService(MkService $mkService): static
    {
        if ($this->mkServices->removeElement($mkService)) {
            // set the owning side to null (unless already changed)
            if ($mkService->getIdMikrotik() === $this) {
                $mkService->setIdMikrotik(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Zone>
     */
    public function getZones(): Collection
    {
        return $this->zones;
    }

    public function addZone(Zone $zone): static
    {
        if (!$this->zones->contains($zone)) {
            $this->zones->add($zone);
            $zone->setIdMikrotik($this);
        }

        return $this;
    }

    public function removeZone(Zone $zone): static
    {
        if ($this->zones->removeElement($zone)) {
            // set the owning side to null (unless already changed)
            if ($zone->getIdMikrotik() === $this) {
                $zone->setIdMikrotik(null);
            }
        }

        return $this;
    }
}
