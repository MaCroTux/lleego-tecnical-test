<?php

namespace App\Flight\Domain;

use DateTimeImmutable;

class Segment
{
    public function __construct(
        private readonly string $originCode,
        private readonly string $originName,
        private readonly string $destinationCode,
        private readonly string $destinationName,
        private readonly DateTimeImmutable $start,
        private readonly DateTimeImmutable $end,
        private readonly string $transportNumber,
        private readonly string $companyCode,
        private readonly string $companyName
    ) {}

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
     * @return DateTimeImmutable
     */
    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
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
}
