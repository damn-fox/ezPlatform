<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

class LuckyController extends AbstractController
{


    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @Route("/show-rides")
     */
    public function number(): Response
    {

        $query = new LocationQuery;
        $criterion1 = new Criterion\ContentTypeIdentifier(["ride"]);
        $criterion4 = new Criterion\Visibility(Criterion\Visibility::VISIBLE);


        $query->query = new Criterion\LogicalAnd(
            [$criterion1,$criterion4]
        );

        $query->sortClauses = [
            new SortClause\DatePublished(LocationQuery::SORT_ASC),
        ];

        $query->limit = 100;

        $result = $this->searchService->findContentInfo($query);
        $totItem = $result->totalCount;
        $names = [];
        foreach ($result->searchHits as $searchHit) {
            $names [] = $searchHit->valueObject->name;
        }

        return $this->render('lucky/number.html.twig', [
            'totItem' => $totItem,
            'names' => $names
        ]);
    }
}