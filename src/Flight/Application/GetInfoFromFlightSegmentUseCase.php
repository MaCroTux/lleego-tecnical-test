<?php

namespace App\Flight\Application;

use App\Flight\Domain\Segment;
use App\Flight\Domain\SegmentRepository;

class GetInfoFromFlightSegmentUseCase
{
    public function __construct(private readonly SegmentRepository $segmentRepository)
    {
    }

    public function __invoke(): array
        {
            $flightSegments = [];
            foreach ($this->segmentRepository->getAllFlightSegmentsList() as $item) {
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