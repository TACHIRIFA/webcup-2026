<?php

namespace App\Repository;

use App\Entity\ContactMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** * @extends ServiceEntityRepository<ContactMessage> */ class ContactMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactMessage::class);
    }
    /** * @return ContactMessage[] */ public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('message')->orderBy('message.id', 'DESC')->getQuery()->getResult();
    }
    public function countAllMessages(): int
    {
        return (int) $this->createQueryBuilder('message')->select('COUNT(message.id)')->getQuery()->getSingleScalarResult();
    }
}
