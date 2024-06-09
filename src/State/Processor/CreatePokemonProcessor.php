<?php

namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Service\PokemonService;

class CreatePokemonProcessor implements ProcessorInterface
{
    public function __construct(private readonly PokemonService $pokemonService)
    {
    }


    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->pokemonService->createPokemon($data);
    }
}