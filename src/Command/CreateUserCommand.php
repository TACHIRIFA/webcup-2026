<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create a new application user',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('Adresse e-mail');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $io->error('Veuillez saisir une adresse e-mail valide.');

            return Command::FAILURE;
        }

        $existingUser = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if ($existingUser) {
            $io->error('Un utilisateur avec cette adresse e-mail existe déjà.');

            return Command::FAILURE;
        }

        $password = $io->askHidden('Mot de passe');

        if (!$password) {
            $io->error('Le mot de passe ne peut pas être vide.');

            return Command::FAILURE;
        }

        $user = new User();

        $user->setEmail($email);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $password)
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf(
            'Utilisateur "%s" créé avec succès.',
            $email
        ));

        return Command::SUCCESS;
    }
}
