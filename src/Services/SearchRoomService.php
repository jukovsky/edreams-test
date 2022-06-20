<?php

namespace App\Services;

use App\Interfaces\Provider;
use App\SearchRequest;

class SearchRoomService
{
    /**
     * @var Provider[]
     */
    private array $providers;

    public function addProvider(Provider $provider): void
    {
        $this->providers[] = $provider;
    }

    public function searchRoomByRequest(SearchRequest $searchRequest): array
    {
        $result = [];
        $fares = [];
        $cheapestPrice = 0;
        $highestMargin = 0;

        foreach ($this->providers as $provider) {
            $providerResult = $provider->getRoomsByRequest($searchRequest);
            if (count($providerResult)) {
                $fares = array_merge($fares, $providerResult);
            }
        }

        foreach ($fares as $fare) {
            $isBestFare = !$cheapestPrice || $cheapestPrice > $fare->getPrice() || $highestMargin < $fare->getMargin();
            if ($isBestFare) {
                $cheapestPrice = $fare->getPrice();
                $highestMargin = $fare->getMargin();
            }
        }

        foreach ($fares as $fare) {
            $isFareSuitable = $cheapestPrice === $fare->getPrice() && $highestMargin === $fare->getMargin();
            if ($isFareSuitable) {
                $result[] = $fare->asArray();
            }
        }

        return $result;
    }
}