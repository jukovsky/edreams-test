<?php

namespace App;

use DateTime;

class SearchRequest
{
    private int $children;
    private int $adults;
    private DateTime $fromDate;
    private DateTime $toDate;

    public function __construct(int $children, int $adults, DateTime $fromDate, DateTime $toDate)
    {
        $this->children = $children;
        $this->adults = $adults;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function getChildren(): int
    {
        return $this->children;
    }

    public function getAdults(): int
    {
        return $this->adults;
    }

    public function getFromDate(): DateTime
    {
        return $this->fromDate;
    }

    public function getToDate(): DateTime
    {
        return $this->toDate;
    }
}