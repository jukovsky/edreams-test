<?php

namespace App;

use App\Interfaces\Room;

class Fare
{
    private float $margin;
    private float $price;
    private string $provider;
    private Room $room;

    public function __construct(string $provider, Room $room)
    {
        $this->price = 0;
        $this->provider = $provider;
        $this->room = $room;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function addPrice(float $price): void
    {
        $this->price += $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setMargin(float $margin): void
    {
        $this->margin = $margin;
    }

    public function getMargin(): float
    {
        return $this->margin;
    }

    public function asArray(): array
    {
        return [
            'Provider' => $this->getProvider(),
            'Hotel' => $this->room->getHotelName(),
            'Room' => $this->room->getId(),
            'Price' => $this->getPrice(),
        ];
    }
}