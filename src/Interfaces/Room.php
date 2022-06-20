<?php

namespace App\Interfaces;

interface Room
{
    public function getId(): int;
    public function getHotelId(): int;
    public function getSize(): int;
    public function getHotelName(): string;
    public function isSuitable(int $adults): bool;
}