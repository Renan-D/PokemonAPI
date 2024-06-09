<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CountPokemonController extends AbstractController
{
    public function __construct(private readonly PokemonRepository $pokemonRepository)
    {
    }

    public function __invoke(): JsonResponse
    {
        return $this->json(['count' => $this->pokemonRepository->count()]);
    }
}