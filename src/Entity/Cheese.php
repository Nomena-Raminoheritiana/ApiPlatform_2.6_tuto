<?php

namespace App\Entity;

use App\Repository\CheeseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use function Symfony\Bundle\MakerBundle\Util\getShortName;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;

#[ORM\Entity(repositoryClass: CheeseRepository::class)]
#[ApiResource(
    shortName:'fromage',
    collectionOperations: [
       'GET' => [
          'normalization_context' => [
               'groups' => ['cheese:read:collection']
           ]
       ],
        'POST' => [
            'denormalization_context' => [
                'groups' => ['cheese:write:collection']
            ],
            'security' => "is_granted('IS_AUTHENTICATED_FULLY')"

        ]
    ],
    itemOperations: [
        'GET',
        'PUT' => [
            'denormalization_context' => [
                'groups' => ['cheese:item:update']
            ]
        ],
        'DELETE'
    ],
    attributes: [
      'pagination_items_per_page' => 1,
      'pagination_maximum_items_per_page' => 2,
      'pagination_client_items_per_page' => true
    ]

)]
#[ApiFilter(BooleanFilter::class, properties:["is_est_bon"])]
#[ApiFilter(SearchFilter::class, properties:[
    "user.nom" => "exact"
])]
class Cheese
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['cheese:read:collection','user:item:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:write','cheese:read:collection', 'user:item:read','user:item:update', 'cheese:item:update','cheese:write:collection'])]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:write','cheese:read:collection','user:item:read','user:item:update', 'cheese:item:update','cheese:write:collection'])]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    #[Groups(['cheese:read:collection', 'cheese:item:update','cheese:write:collection'])]
    private ?bool $is_est_bon = false;

    #[ORM\ManyToOne(inversedBy: 'cheeses', cascade:['persist'])]
    #[Groups(['cheese:read:collection','cheese:item:update','cheese:write:collection'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function isIsEstBon(): ?bool
    {
        return $this->is_est_bon;
    }

    public function setIsEstBon(bool $is_est_bon): self
    {
        $this->is_est_bon = $is_est_bon;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
