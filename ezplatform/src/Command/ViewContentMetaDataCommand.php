<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use eZ\Publish\API\Repository\ContentService;

class ViewContentMetaDataCommand extends Command
{
    private $contentService;

    public function __construct(ContentService $contentService)
    {
        parent::__construct();
        $this->contentService = $contentService;
    }

    protected function configure()
    {
        $this
            ->setName('demo:content')
            ->setDescription('get content')
            ->addArgument(
            'contentId',
            InputArgument::REQUIRED,
            'Which content you want to know the name?'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $contentId = $input->getArgument('contentId');

        $contentInfo = $this->contentService->loadContentInfo($contentId);

        $output->writeln("Name: $contentInfo->name");

        return 0;

    }

}
