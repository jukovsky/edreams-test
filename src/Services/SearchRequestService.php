<?php

namespace App\Services;

use App\SearchRequest;
use DateTime;
use Exception;
use Slim\Psr7\Request;

class SearchRequestService
{
    /**
     * @throws Exception
     */
    public function searchRequestFromRequest(Request $request): SearchRequest
    {
        $queryParams = $request->getQueryParams();
        $children = $queryParams['children'] ?? 0;
        $adults = $queryParams['adults'] ?? 1;
        $fromDate = isset($queryParams['fromDate']) ? new DateTime($queryParams['fromDate']) : new DateTime('today');
        $toDate = isset($queryParams['toDate']) ? new DateTime($queryParams['toDate']) : new DateTime('tomorrow');
        $toDate->setTime(0, 0 , 1);

        return new SearchRequest($children, $adults, $fromDate, $toDate);
    }
}