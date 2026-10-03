<?php

namespace App\Service;

use App\Entity\MunicipalService;
use App\Repository\MunicipalServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class MunicipalServiceService
{
    public function __construct(
        private MunicipalServiceRepository $repository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function getAllServices(): array
    {
        return $this->repository->findAllOrderedByName();
    }

    public function countServices(): int
    {
        return $this->repository->countAllServices();
    }

    public function createService(MunicipalService $service): void
    {
        $this->entityManager->persist($service);
        $this->entityManager->flush();
    }

    public function updateService(MunicipalService $service): void
    {
        $this->entityManager->flush();
    }
    public function deleteService(MunicipalService $service): void
    {
        $this->entityManager->remove($service);
        $this->entityManager->flush();
    }
}
