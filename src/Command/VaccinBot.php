<?php

namespace App\Command;

use App\Service\GetDataService;
use App\Service\TwitterApiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VaccinBot extends Command
{
    private $getData;
    private $twitterApi;
    protected static $defaultName = 'bot:post';

    public function __construct(GetDataService $getData, TwitterApiService $twitterApi)
    {
        parent::__construct();
        $this->getData = $getData;
        $this->twitterApi = $twitterApi;
    }

    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = $this->getData->fromGouv();
        $this->twitterApi->post($content);
        return Command::SUCCESS ;
    }
}
