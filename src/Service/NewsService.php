<?php

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewsService
{
    public function __construct(
        private NewsRepository $repository,
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @return News[]
     */
    public function getAllNews(): array
    {
        return $this->repository->findAllOrderedByDate();
    }

    public function countNews(): int
    {
        return $this->repository->countAllNews();
    }

    public function createNews(News $news): void
    {
        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }

    public function updateNews(News $news): void
    {
        $this->entityManager->flush();
    }

    public function deleteNews(News $news): void
    {
        $this->entityManager->remove($news);
        $this->entityManager->flush();
    }
}
