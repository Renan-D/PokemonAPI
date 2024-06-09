<?php

namespace App\Service;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;

class PokemonService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function createPokemon(Pokemon $data): Pokemon
    {
        $data->setCurrentHP($data->getMaxHP());

        $formattedNumero = sprintf('%03d', $data->getNationalNumber());
        $data->setSprite("https://assets.pokemon.com/assets/cms2/img/pokedex/full/$formattedNumero.png");

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }

}