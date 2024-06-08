<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
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
    routePrefix: '/pokemons',
    normalizationContext: ["groups" => ["pokemons_read"]],
    denormalizationContext: ["groups" => ["pokemons_write"]]
)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $nationalNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?string $name = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private array $types = [];

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $level = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $maxHP = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $currentHP = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $attack = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $defense = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $speed = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?string $sprite = null;

    /**
     * @var Collection<int, Move>
     */
    #[ORM\ManyToMany(targetEntity: Move::class, mappedBy: 'pokemons')]
    private Collection $moves;

    public function __construct()
    {
        $this->moves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNationalNumber(): ?int
    {
        return $this->nationalNumber;
    }

    public function setNationalNumber(int $nationalNumber): static
    {
        $this->nationalNumber = $nationalNumber;

        return $this;
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

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): static
    {
        $this->types = $types;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getMaxHP(): ?int
    {
        return $this->maxHP;
    }

    public function setMaxHP(int $maxHP): static
    {
        $this->maxHP = $maxHP;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): static
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): static
    {
        $this->defense = $defense;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): static
    {
        $this->speed = $speed;

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

    public function getSprite(): ?string
    {
        return $this->sprite;
    }

    public function setSprite(?string $sprite): static
    {
        $this->sprite = $sprite;

        return $this;
    }

    public function getCurrentHP(): ?int
    {
        return $this->currentHP;
    }

    public function setCurrentHP(int $currentHP): static
    {
        $this->currentHP = $currentHP;

        return $this;
    }

    /**
     * @return Collection<int, Move>
     */
    public function getMoves(): Collection
    {
        return $this->moves;
    }

    public function addMove(Move $move): static
    {
        if (!$this->moves->contains($move)) {
            $this->moves->add($move);
            $move->addPokemon($this);
        }

        return $this;
    }

    public function removeMove(Move $move): static
    {
        if ($this->moves->removeElement($move)) {
            $move->removePokemon($this);
        }

        return $this;
    }
}
