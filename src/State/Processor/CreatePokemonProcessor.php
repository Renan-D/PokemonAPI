<?php

namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;

class CreatePokemonProcessor implements ProcessorInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }


    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var Pokemon $data */ // Permet d'avoir de l'autocomplétion sur l'entité Pokemon

        $data->setCurrentHP($data->getMaxHP());

        $formattedNumero = sprintf('%03d', $data->getNationalNumber());
        $data->setSprite("https://assets.pokemon.com/assets/cms2/img/pokedex/full/$formattedNumero.png");

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}