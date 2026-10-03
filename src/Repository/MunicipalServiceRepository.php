<?php

namespace App\Repository;

use App\Entity\MunicipalService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MunicipalService>
 */
class MunicipalServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MunicipalService::class);
    }

    /**
     * @return MunicipalService[]
     */
    public function findAllOrderedByName(): array
    {
        return $this->createQueryBuilder('service')
            ->orderBy('service.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function countAllServices(): int
    {
        return (int) $this->createQueryBuilder('service')
            ->select('COUNT(service.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
