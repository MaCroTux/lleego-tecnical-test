<?php

namespace App\Flight\Domain;

interface SegmentRepository
{
    /** @return Segment[] */
    public function getAllFlightSegmentsList(): array;
}