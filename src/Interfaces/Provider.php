<?php

namespace App\Interfaces;

use App\Fare;
use App\SearchRequest;

interface Provider
{
    /**
     * @return Fare[]
     */
    public function getRoomsByRequest(SearchRequest $searchRequest): array;

    public function getMarginForFare(Fare $fare): float;
}