<?php

namespace App\Rooms;

use App\Interfaces\Room;
use JetBrains\PhpStorm\ArrayShape;

class SimpleRoom implements Room
{
    private int $id;
    private int $hotelId;
    private string $hotelName;
    private int $size;

    public function __construct(int $id, int $hotelId, string $hotelName, int $size)
    {
        $this->id = $id;
        $this->hotelId = $hotelId;
        $this->hotelName = $hotelName;
        $this->size = $size;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHotelId(): int
    {
        return $this->hotelId;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getHotelName(): string
    {
        return $this->hotelName;
    }

    public function isSuitable(int $adults): bool
    {
        return $this->size >= $adults;
    }
}