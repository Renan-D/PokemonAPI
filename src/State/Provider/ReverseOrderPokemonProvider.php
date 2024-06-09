<?php

namespace App\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\PokemonRepository;

class ReverseOrderPokemonProvider implements ProviderInterface
{
    public function __construct(private readonly PokemonRepository $pokemonRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->pokemonRepository->findBy([], ['nationalNumber' => 'DESC']);
    }
}


