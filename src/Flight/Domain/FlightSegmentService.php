<?php

namespace App\Flight\Domain;

use Closure;
use DateTimeImmutable;

class FlightSegmentService
{
    public function __construct(private readonly SegmentRepository $segmentRepository)
    {
    }

    /**
     * @param string $origin
     * @param string $destination
     * @param DateTimeImmutable $date
     * @return Segment[] array
     */
    public function __invoke(
        string $origin,
        string $destination,
        DateTimeImmutable $date
    ): array {
        return array_filter(
            $this->segmentRepository->getAllFlightSegmentsList(),
            $this->isEqualOriginCodeAndIsEqualDestinationCodeAndEqualStartDate($origin, $destination, $date)
        );
    }

    private function isEqualOriginCodeAndIsEqualDestinationCodeAndEqualStartDate(
        string $origin,
        string $destination,
        DateTimeImmutable $date
    ): Closure {
        return function (Segment $segment) use ($origin, $destination, $date) {
            return $segment->getOriginCode() === $origin
                && $segment->getDestinationCode() === $destination
                && $segment->getStart()->format('Y-m-d') === $date->format('Y-m-d');
        };
    }
}