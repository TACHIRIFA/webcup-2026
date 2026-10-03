<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @return User[]
     */
    public function getAllUsers(): array
    {
        return $this->repository->findAllOrderedByName();
    }

    public function countUsers(): int
    {
        return $this->repository->countAllUsers();
    }

    public function updateUser(User $user): void
    {
        $this->entityManager->flush();
    }

    public function deleteUser(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
