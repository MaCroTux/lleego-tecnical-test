<?php

namespace App\Flight\Infrastructure;

use App\Flight\Domain\Segment;
use App\Flight\Domain\SegmentRepository;
use App\Flight\Domain\XmlReadException;
use DateTimeImmutable;
use Exception;
use SimpleXMLElement;

class SegmentReadFileNoSoapRepository implements SegmentRepository
{
    private SimpleXMLElement $xmlData;

    /**
     * @throws XmlReadException
     */
    public function __construct(string $xmlFileName)
    {
        try {
            $this->xmlData = simplexml_load_string(
                file_get_contents(__DIR__ . $xmlFileName)
            );
        } catch (Exception $e) {
            throw new XmlReadException('Error reading XML: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /** @return Segment[] */
    public function getAllFlightSegmentsList(): array
    {
        return $this->getFlightSegments();
    }

    /** @return Segment[] */
    private function getFlightSegments(): array
    {
        $flightSegments = [];
        foreach ($this->xmlData->DataLists->FlightSegmentList->children() as $item) {
            $flightSegments[] = $this->parseXmlToSegment($item);
        }

        return $flightSegments;
    }

    private function parseXmlToSegment(SimpleXMLElement $item): Segment
    {
        return new Segment(
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
}