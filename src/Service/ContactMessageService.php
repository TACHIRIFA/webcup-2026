<?php

namespace App\Service;

use App\Entity\ContactMessage;
use App\Repository\ContactMessageRepository;
use Doctrine\ORM\EntityManagerInterface;

class ContactMessageService
{
    public function __construct(private ContactMessageRepository $repository, private EntityManagerInterface $entityManager,) {}
    /** * @return ContactMessage[] */ public function getAllMessages(): array
    {
        return $this->repository->findAllOrderedByDate();
    }
    public function countMessages(): int
    {
        return $this->repository->countAllMessages();
    }
    public function createMessage(ContactMessage $message): void
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }
}
