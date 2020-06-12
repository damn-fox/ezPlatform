<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

class ShowRideCommand extends Command
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        parent::__construct();
        $this->searchService = $searchService;
    }

    protected function configure()
    {
        $this
            ->setName('show:info')
            ->setDescription('query rides')
            ->addArgument(
                'contentType',
                InputArgument::REQUIRED,
                'Which content you want to know the name?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $contentType = $input->getArgument('contentType');

        $query = new LocationQuery;
        $criterion1 = new Criterion\ContentTypeIdentifier(["$contentType"]);
        $criterion4 = new Criterion\Visibility(Criterion\Visibility::VISIBLE);


        $query->query = new Criterion\LogicalAnd(
            [$criterion1,$criterion4]
        );

        $query->sortClauses = [
            new SortClause\DatePublished(LocationQuery::SORT_ASC),
        ];

        $query->limit = 100;

        $result = $this->searchService->findContentInfo($query);
        $output->writeln('Found ' . $result->totalCount . ' items');
        foreach ($result->searchHits as $searchHit) {
            $name = $searchHit->valueObject->name;
            $output->writeln($name);
        }
        return 0;
    }

}
