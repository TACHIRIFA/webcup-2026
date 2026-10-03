<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** * @extends ServiceEntityRepository<News> */ class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }
    /** * @return News[] */ public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('news')->orderBy('news.publishAt', 'DESC')->getQuery()->getResult();
    }
    public function countAllNews(): int
    {
        return (int) $this->createQueryBuilder('news')->select('COUNT(news.id)')->getQuery()->getSingleScalarResult();
    }
}
