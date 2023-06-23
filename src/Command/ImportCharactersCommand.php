<?php

namespace App\Command;

use App\Entity\Characters;
use App\Service\StarWarService;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
 
#[AsCommand(
    name: 'starwars:import',
    description: 'description',
)]
class ImportCharactersCommand extends Command
{

    private $StarWarService;

    public function __construct(StarWarService $StarWarService)
    {
        $this->StarWarService = $StarWarService;

        parent::__construct();
    }




    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $charactersData = $this->StarWarService->createCharacter();

        return Command::SUCCESS;
    }
}
