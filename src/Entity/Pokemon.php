<?php

namespace App\Entity;

use App\Controller\CountPokemonController;
use App\Repository\PokemonRepository;
use App\State\Processor\CreatePokemonProcessor;
use App\State\Provider\ReverseOrderPokemonProvider;
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
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
        ),
        new GetCollection(
            uriTemplate: '/',
            provider: ReverseOrderPokemonProvider::class
        ),
        new Get(
            uriTemplate: '/count',
            controller: countPokemonController::class,
            read: false
        ),
        new Patch(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
            security: 'is_granted("ROLE_ADMIN") === true',
        ),
        new Post(
            uriTemplate: '',
            security: 'is_granted("ROLE_USER") === true',
            processor: CreatePokemonProcessor::class
        )
    ],
    routePrefix: '/pokemons',
    normalizationContext: ["groups" => ["pokemons_read"]],
    denormalizationContext: ["groups" => ["pokemons_write"]],
    // order: ['nationalNumber' => 'ASC'] // Cette ligne peut remplacer le traitement dans le provider ReverseOrderPokemonProvider
)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    #[Assert\Range(notInRangeMessage: "Only 1st generation pokemon 1-151", min: 1, max: 151)]
    private ?int $nationalNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    #[Assert\NotBlank]
    #[Assert\Count(min: 1, max: 2)]
    #[Assert\All([
        new Assert\Choice(['choices' => ['Fire', 'Water', 'Grass', 'Electric', 'Ice', 'Fighting', 'Poison', 'Ground', 'Flying', 'Psychic', 'Bug', 'Rock', 'Ghost', 'Dragon', 'Dark', 'Steel', 'Fairy']],
            message: "Invalid type, types must be Fire, Water, Grass, Electric, Ice, Fighting, Poison, Ground, Flying, Psychic, Bug, Rock, Ghost, Dragon, Dark, Steel"),
    ])]
    private array $types = [];

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $level = null;

    #[ORM\Column]
    #[Groups(["pokemons_read", "pokemons_write"])]
    private ?int $maxHP = null;

    #[ORM\Column]
    #[Groups(["pokemons_read"])]
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
    #[Groups(["pokemons_read"])]
    private ?string $sprite = null;

    /**
     * @var Collection<int, Move>
     */
    #[ORM\ManyToMany(targetEntity: Move::class, mappedBy: 'pokemons')]
    #[Groups(["pokemons_read", "pokemons_write", "moves_read", "moves_write"])]
    private Collection $moves;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'evolutions')]
    #[Groups(["pokemons_write"])]
    private ?self $preEvolution = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'preEvolution')]
    private Collection $evolutions;

    public function __construct()
    {
        $this->moves = new ArrayCollection();
        $this->evolutions = new ArrayCollection();
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

    public function getPreEvolution(): ?self
    {
        return $this->preEvolution;
    }

    public function setPreEvolution(?self $preEvolution): static
    {
        $this->preEvolution = $preEvolution;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getEvolutions(): Collection
    {
        return $this->evolutions;
    }

    public function addEvolution(self $evolution): static
    {
        if (!$this->evolutions->contains($evolution)) {
            $this->evolutions->add($evolution);
            $evolution->setPreEvolution($this);
        }

        return $this;
    }

    public function removeEvolution(self $evolution): static
    {
        if ($this->evolutions->removeElement($evolution)) {
            // set the owning side to null (unless already changed)
            if ($evolution->getPreEvolution() === $this) {
                $evolution->setPreEvolution(null);
            }
        }

        return $this;
    }
}
