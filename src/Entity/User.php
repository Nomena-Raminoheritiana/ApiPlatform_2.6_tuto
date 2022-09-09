<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use  Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    shortName : 'personne',
    collectionOperations: [
            'GET',
            'POST' => [
                'dernomalization_context' => [
                    'groups' => ['user:write']
                ]
            ]
    ],
    itemOperations: [
        'GET' => [
            'normalization_context' => [
                'groups' => ['user:item:read']
            ]
        ],
        'PUT' => [
            'denormalization_context' => [
                'groups' => ['user:item:update']
            ]
        ],
        'DELETE'
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:write', 'user:item:read', 'cheese:item:update'])]
    private ?string $mail = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:write', 'user:item:read','cheese:item:update'])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:write','user:item:read', 'user:item:update', 'cheese:item:update'])]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:write','user:item:read','user:item:update'])]
    private ?int $age = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Cheese::class, cascade:['persist'] )]
    #[Groups(['user:write','user:item:read','user:item:update'])]
    private Collection $cheeses;

    #[ORM\ManyToMany(targetEntity: Numero::class, mappedBy: 'users')]
    private Collection $numeros;

    public function __construct()
    {
        $this->cheeses = new ArrayCollection();
        $this->numeros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->mail;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection<int, Cheese>
     */
    public function getCheeses(): Collection
    {
        return $this->cheeses;
    }

    public function addCheese(Cheese $cheese): self
    {
        if (!$this->cheeses->contains($cheese)) {
            $this->cheeses->add($cheese);
            $cheese->setUser($this);
        }

        return $this;
    }

    public function removeCheese(Cheese $cheese): self
    {
        if ($this->cheeses->removeElement($cheese)) {
            // set the owning side to null (unless already changed)
            if ($cheese->getUser() === $this) {
                $cheese->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Numero>
     */
    public function getNumeros(): Collection
    {
        return $this->numeros;
    }

    public function addNumero(Numero $numero): self
    {
        if (!$this->numeros->contains($numero)) {
            $this->numeros->add($numero);
            $numero->addUser($this);
        }

        return $this;
    }

    public function removeNumero(Numero $numero): self
    {
        if ($this->numeros->removeElement($numero)) {
            $numero->removeUser($this);
        }

        return $this;
    }
}
