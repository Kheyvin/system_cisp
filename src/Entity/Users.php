<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\EventListener\PasswordHashListener;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\sys_admin\Api\LoginApiController;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\EntityListeners([PasswordHashListener::class])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USER_NAME', fields: ['user_name'])]
#[ApiResource(normalizationContext: ['groups' => ['users:read']], operations: [
        new Get(),
        new Post(),
        new GetCollection(),
        new Delete(),
        new Patch(),
        new Get(
            uriTemplate: '/auth/user',
            controller: LoginApiController::class,
            security: "is_granted('IS_AUTHENTICATED_FULLY')",
            name: 'auth_user'
        )
    ])]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['users:read'])]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['users:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['users:read'])]
    private ?string $last_name = null;

    #[ORM\Column(name: 'user_name', length: 255)]
    #[Groups(['users:read'])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(['users:read'])]
    private ?string $state = null;

    /**
     * @var string El rol del usuario (como string)
     */
    #[ORM\Column(name: 'role', type: 'string')]
    #[Groups(['users:read'])]
    private ?string $role = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['users:read'])]
    private ?string $password = null;

    #[ORM\Column(name: '"createdAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['users:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: '"updatedAt"', type: Types::DATETIME_MUTABLE)]
    #[Groups(['users:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(name: '"deletedAt"', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['users:read'])]
    private ?\DateTime $deletedAt = null;

    /**
     * @var Collection<int, Reports>
     */
    #[ORM\OneToMany(targetEntity: Reports::class, mappedBy: 'id_user')]
    private Collection $reports;

    /**
     * @var Collection<int, Technician>
     */
    #[ORM\OneToMany(targetEntity: Technician::class, mappedBy: 'id_user')]
    private Collection $technicians;

    public function __construct()
    {
        $this->reports = new ArrayCollection();
        $this->technicians = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->username;
    }

    public function setUserName(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [];
        
        if ($this->role) {
            // Agregar prefijo ROLE_ si no lo tiene
            $role = $this->role;
            if (strpos($role, 'ROLE_') !== 0) {
                $role = 'ROLE_' . $role;
            }
            $roles[] = $role;
        }
        
        // Garantizar que todo usuario al menos tenga ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        // Para la base de datos, solo guardamos un rol (el primero que no sea ROLE_USER)
        if (empty($roles)) {
            $this->role = null;
            return $this;
        }
        
        foreach ($roles as $role) {
            if ($role === 'ROLE_USER') {
                continue; // Ignorar ROLE_USER que se agrega automáticamente
            }
            
            // Si el rol tiene prefijo ROLE_, quitarlo para la base de datos
            if (strpos($role, 'ROLE_') === 0) {
                $this->role = substr($role, 5);
            } else {
                $this->role = $role;
            }
            
            break; // Solo tomamos el primer rol que no sea ROLE_USER
        }

        return $this;
    }
    
    public function getRole(): ?string
    {
        return $this->role;
    }
    
    public function setRole(?string $role): static
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

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
            $report->setIdUser($this);
        }

        return $this;
    }

    public function removeReport(Reports $report): static
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getIdUser() === $this) {
                $report->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Technician>
     */
    public function getTechnicians(): Collection
    {
        return $this->technicians;
    }

    public function addTechnician(Technician $technician): static
    {
        if (!$this->technicians->contains($technician)) {
            $this->technicians->add($technician);
            $technician->setIdUser($this);
        }

        return $this;
    }

    public function removeTechnician(Technician $technician): static
    {
        if ($this->technicians->removeElement($technician)) {
            // set the owning side to null (unless already changed)
            if ($technician->getIdUser() === $this) {
                $technician->setIdUser(null);
            }
        }

        return $this;
    }
}