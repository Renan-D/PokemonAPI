<?php

namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProcessor implements ProcessorInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var User $data */

        $password = $data->getPassword();
        $data->setPassword($this->hasher->hashPassword($data, $password));

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}