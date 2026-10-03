<?php

namespace App\Command;

use App\Service\WebcupApiClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-webcup-api',
    description: 'Teste la connexion à l API Webcup',
)]
class TestWebcupApiCommand extends Command
{
    public function __construct(
        private WebcupApiClient $webcupApiClient,
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        try {
            $data = $this->webcupApiClient->getRequests();

            $io->success('Connexion à l API Webcup réussie.');

            $io->section('Réponse de l API');

            $io->writeln(
                json_encode(
                    $data,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );

            return Command::SUCCESS;
        } catch (\Throwable $exception) {

            $io->error('Impossible de contacter l API Webcup.');

            $io->writeln(
                $exception->getMessage()
            );

            return Command::FAILURE;
        }
    }
}
