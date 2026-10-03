<?php

namespace App\Command;

use App\Entity\MunicipalService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:seed-municipal-services',
    description: 'Ajoute des services municipaux de démonstration',
)]
class SeedMunicipalServicesCommand
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $io = new SymfonyStyle($input, $output);

        $services = [
            [
                'name' => 'État civil',
                'category' => 'Administration',
                'description' => 'Gestion des actes de naissance, mariage et décès.',
                'adresse' => 'Hôtel de Ville',
                'phone' => '+269 773 00 00',
                'email' => 'etatcivil@terranova.local',
                'openingHours' => 'Lundi - Vendredi : 08h00 - 15h00',
            ],
            [
                'name' => 'Service des affaires sociales',
                'category' => 'Social',
                'description' => 'Accompagnement et orientation des citoyens pour les démarches sociales.',
                'adresse' => 'Centre administratif',
                'phone' => '+269 773 00 01',
                'email' => 'social@terranova.local',
                'openingHours' => 'Lundi - Vendredi : 08h00 - 15h00',
            ],
            [
                'name' => 'Service de l’urbanisme',
                'category' => 'Urbanisme',
                'description' => 'Gestion des demandes liées à l’urbanisme et aux constructions.',
                'adresse' => 'Hôtel de Ville',
                'phone' => '+269 773 00 02',
                'email' => 'urbanisme@terranova.local',
                'openingHours' => 'Lundi - Vendredi : 08h00 - 15h00',
            ],
            [
                'name' => 'Service de l’environnement',
                'category' => 'Environnement',
                'description' => 'Gestion des questions relatives à l’environnement et à la propreté de la ville.',
                'adresse' => 'Centre technique municipal',
                'phone' => '+269 773 00 03',
                'email' => 'environnement@terranova.local',
                'openingHours' => 'Lundi - Vendredi : 08h00 - 15h00',
            ],
            [
                'name' => 'Service des travaux publics',
                'category' => 'Infrastructures',
                'description' => 'Suivi des travaux, voiries et infrastructures municipales.',
                'adresse' => 'Centre technique municipal',
                'phone' => '+269 773 00 04',
                'email' => 'travaux@terranova.local',
                'openingHours' => 'Lundi - Vendredi : 08h00 - 15h00',
            ],
            [
                'name' => 'Service des finances',
                'category' => 'Finances',
                'description' => 'Gestion des questions relatives aux finances et aux paiements municipaux.',
                'adresse' => 'Hôtel de Ville',
                'phone' => '+269 773 00 05',
                'email' => 'finances@terranova.local',
                'openingHours' => 'Lundi - Vendredi : 08h00 - 15h00',
            ],
        ];

        foreach ($services as $data) {
            $service = new MunicipalService();

            $service->setName($data['name']);
            $service->setCategory($data['category']);
            $service->setDescription($data['description']);
            $service->setAdresse($data['adresse']);
            $service->setPhone($data['phone']);
            $service->setEmail($data['email']);
            $service->setOpeningHours($data['openingHours']);

            $this->entityManager->persist($service);
        }

        $this->entityManager->flush();

        $io->success(sprintf(
            '%d services municipaux ont été ajoutés avec succès.',
            count($services)
        ));

        return Command::SUCCESS;
    }
}
