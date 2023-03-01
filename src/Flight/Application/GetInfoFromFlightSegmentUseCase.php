<?php

namespace App\Flight\Application;

use DateTimeImmutable;
use SimpleXMLElement;

class GetInfoFromFlightSegmentUseCase
{
    private SimpleXMLElement $xmlData;

    public function __construct(string $xmlFileName)
    {
        $this->xmlData = simplexml_load_string(
            file_get_contents(__DIR__ . $xmlFileName)
        );
    }

    public function __invoke(): array
        {
            $flightSegments = [];
            foreach ($this->xmlData->DataLists->FlightSegmentList->children() as $item) {
                $flightSegments[] = new GetInfoFromFlightSegmentUseResponse(
                    (string) $item->Departure->AirportCode,
                    (string) $item->Departure->AirportName,
                    (string) $item->Arrival->AirportCode,
                    (string) $item->Arrival->AirportName,
                    new DateTimeImmutable((string) $item->Departure->Date),
                    new DateTimeImmutable((string) $item->Arrival->Date),
                    (string) $item->MarketingCarrier->FlightNumber,
                    (string) $item->MarketingCarrier->AirlineID,
                    (string) $item->MarketingCarrier->Name,
                );
            }

            return $flightSegments;
        }
}