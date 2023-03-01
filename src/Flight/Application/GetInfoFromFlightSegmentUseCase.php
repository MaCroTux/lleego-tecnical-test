<?php

namespace App\Flight\Application;

use App\Flight\Domain\FlightSegmentService;
use App\Flight\Domain\InvalidDateException;
use DateTimeImmutable;
use Exception;

class GetInfoFromFlightSegmentUseCase
{
    public function __construct(private readonly FlightSegmentService $flightSegmentService)
    {
    }

    /**
     * @return GetInfoFromFlightSegmentUseResponse[]
     * @throws InvalidDateException
     */
    public function __invoke(string $origin, string $destination, string $date): array
    {
        try {
            $datetime = new DateTimeImmutable($date);
        } catch (Exception $e) {
            throw new InvalidDateException('Invalid date format', $e->getCode(), $e);
        }

        $flightSegments = [];
        foreach ($this->flightSegmentService->__invoke($origin, $destination, $datetime) as $item) {
            $flightSegments[] = new GetInfoFromFlightSegmentUseResponse(
                $item->getOriginCode(),
                $item->getOriginName(),
                $item->getDestinationCode(),
                $item->getDestinationName(),
                $item->getStart(),
                $item->getEnd(),
                $item->getTransportNumber(),
                $item->getCompanyCode(),
                $item->getCompanyName(),
            );
        }

        return $flightSegments;
    }
}