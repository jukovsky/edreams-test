<?php

namespace App\Providers;

use App\Fare;
use App\Interfaces\Provider;
use App\Interfaces\Room;
use App\Rooms\SimpleRoom;
use App\SearchRequest;
use DateInterval;
use DatePeriod;

class FantasticYurtsProvider implements Provider
{
    private string $name = 'Fantastic Yurts';
    private string $source = "./data/fantastic-yurts.json";
    /**
     * @var Room[]
     */
    private array $rooms = [];
    private array $dates = [];

    public function __construct()
    {
        $rawData = json_decode(file_get_contents($this->source), true);
        foreach ($rawData['lodgings'] as $hotelId => $hotelData) {
            foreach ($hotelData['rooms'] as $roomData) {
                $room = new SimpleRoom($roomData['Id'], $hotelId, $hotelData['Name'], $roomData['MaxPersons']);
                $this->rooms[$hotelId][$roomData['Id']] = $room;
                foreach ($roomData['availability'] as $date => $price) {
                    $this->dates[$date][] = [
                        'price' => $price,
                        'room' => $room,
                    ];
                }
            }
        }
    }

    public function getRoomsByRequest(SearchRequest $searchRequest): array
    {
        $result = [];

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($searchRequest->getFromDate(), $interval, $searchRequest->getToDate());

        $availableRoomsWithPrices = [];
        $numberOfDays = 0;
        foreach ($period as $day) {
            $numberOfDays++;
            $dayAvailableRoomsWithPrices = $this->dates[$day->format('Y-m-d')] ?? [];
            foreach ($dayAvailableRoomsWithPrices as $roomAndPrice) {
                ['room' => $room, 'price' => $price] = $roomAndPrice;
                $roomIsSuitable = $room->isSuitable($searchRequest->getAdults());
                if ($roomIsSuitable) {
                    $availableRoomsWithPrices[$room->getHotelId() . '-' . $room->getId()][] = $price;
                }
            }
        }
        foreach ($availableRoomsWithPrices as $hotelAndRoom => $prices) {
            if (count($prices) < $numberOfDays) {
                continue;
            }
            [$hotelId, $roomId] = explode('-', $hotelAndRoom);
            $fare = new Fare($this->name, $this->rooms[$hotelId][$roomId]);
            foreach ($prices as $price) {
                $fare->addPrice($price);
            }
            $fare->setMargin($this->getMarginForFare($fare));
            $result[] = $fare;
        }

        return $result;
    }

    public function getMarginForFare(Fare $fare): float
    {
        return $fare->getPrice() - 5;
    }
}