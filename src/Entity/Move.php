<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\MoveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MoveRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
        ),
        new GetCollection(
            uriTemplate: '/',
        ),
        new Patch(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
        ),
        new Post(
            uriTemplate: '',
        )
    ],
    routePrefix: '/moves',
    normalizationContext: ["groups" => ["moves_read"]],
    denormalizationContext: ["groups" => ["moves_write"]]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])] // Attention ce filtre ne fonctionnera pas avec une route custom getCollection (il faudra faire le filtre à la main et l'intégrer dans la réponse comme je le fais pour Pokemon)
class Move
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["moves_read", "moves_write"])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(["moves_read", "moves_write"])]
    private ?int $number = null;

    #[ORM\Column(length: 2)]
    #[Groups(["moves_read", "moves_write"])]
    private ?string $classification = null;

    #[ORM\Column(length: 255)]
    #[Groups(["moves_read", "moves_write"])]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["moves_read", "moves_write"])]
    private ?string $category = null;

    #[ORM\Column]
    #[Groups(["moves_read", "moves_write"])]
    private ?int $power = null;

    #[ORM\Column]
    #[Groups(["moves_read", "moves_write"])]
    private ?int $accuracy = null;

    #[ORM\Column]
    #[Groups(["moves_read", "moves_write"])]
    private ?int $maxPP = null;

    #[ORM\Column]
    #[Groups(["moves_read", "moves_write"])]
    private ?int $currentPP = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["moves_read", "moves_write"])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["moves_read", "moves_write"])]
    private ?string $effect = null;

    /**
     * @var Collection<int, Pokemon>
     */
    #[ORM\ManyToMany(targetEntity: Pokemon::class, inversedBy: 'moves')]
    private Collection $pokemons;

    public function __construct()
    {
        $this->pokemons = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getClassification(): ?string
    {
        return $this->classification;
    }

    public function setClassification(string $classification): static
    {
        $this->classification = $classification;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getAccuracy(): ?int
    {
        return $this->accuracy;
    }

    public function setAccuracy(int $accuracy): static
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getMaxPP(): ?int
    {
        return $this->maxPP;
    }

    public function setMaxPP(int $pp): static
    {
        $this->maxPP = $pp;

        return $this;
    }

    public function getCurrentPP(): ?int
    {
        return $this->currentPP;
    }

    public function setCurrentPP(int $currentPP): static
    {
        $this->currentPP = $currentPP;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEffect(): ?string
    {
        return $this->effect;
    }

    public function setEffect(?string $effect): static
    {
        $this->effect = $effect;

        return $this;
    }

    /**
     * @return Collection<int, Pokemon>
     */
    public function getPokemons(): Collection
    {
        return $this->pokemons;
    }

    public function addPokemon(Pokemon $pokemon): static
    {
        if (!$this->pokemons->contains($pokemon)) {
            $this->pokemons->add($pokemon);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): static
    {
        $this->pokemons->removeElement($pokemon);

        return $this;
    }
}
