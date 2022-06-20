<?php

namespace App\Controllers;


use App\Providers\FantasticYurtsProvider;
use App\Providers\FraughtLodgingsProvider;
use App\Services\SearchRequestService;
use App\Services\SearchRoomService;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SearchController
{
    /**
     * @throws Exception
     */
    public function searchAction(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $searchRequestService = new SearchRequestService();
        $searchRequest = $searchRequestService->searchRequestFromRequest($request);

        $searchRoomService = new SearchRoomService();
        $searchRoomService->addProvider(new FraughtLodgingsProvider());
        $searchRoomService->addProvider(new FantasticYurtsProvider());

        $payload = json_encode($searchRoomService->searchRoomByRequest($searchRequest));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}