<?php

namespace App\Flight\Application;

use DateTimeImmutable;

class GetInfoFromFlightSegmentUseResponse
{
    /**
     * @param string $originCode
     * @param string $originName
     * @param string $destinationCode
     * @param string $destinationName
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @param string $transportNumber
     * @param string $companyCode
     * @param string $companyName
     */
    public function __construct(
        private readonly string   $originCode,
        private readonly string   $originName,
        private readonly string   $destinationCode,
        private readonly string   $destinationName,
        private readonly DateTimeImmutable $start,
        private readonly DateTimeImmutable $end,
        private readonly string   $transportNumber,
        private readonly string   $companyCode,
        private readonly string   $companyName,
    ) {
    }

    /**
     * @return string
     */
    public function getOriginCode(): string
    {
        return $this->originCode;
    }

    /**
     * @return string
     */
    public function getOriginName(): string
    {
        return $this->originName;
    }

    /**
     * @return string
     */
    public function getDestinationCode(): string
    {
        return $this->destinationCode;
    }

    /**
     * @return string
     */
    public function getDestinationName(): string
    {
        return $this->destinationName;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getEnd(): string
    {
        return $this->end->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getTransportNumber(): string
    {
        return $this->transportNumber;
    }

    /**
     * @return string
     */
    public function getCompanyCode(): string
    {
        return $this->companyCode;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function toArray(): array
    {
        return [
            'originCode' => $this->getOriginCode(),
            'originName' => $this->getOriginName(),
            'destinationCode' => $this->getDestinationCode(),
            'destinationName' => $this->getDestinationName(),
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
            'transportNumber' => $this->getTransportNumber(),
            'companyCode' => $this->getCompanyCode(),
            'companyName' => $this->getCompanyName(),
        ];
    }
}