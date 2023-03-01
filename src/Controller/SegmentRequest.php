<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class SegmentRequest
{
    private readonly string $origin;
    private readonly string $destination;
    private readonly string $date;

    public function __construct(Request $request)
    {
        $this->origin = $request->query->get('origin') ?? '';
        $this->destination = $request->query->get('destination') ?? '';
        $this->date = $request->query->get('date') ?? '';
    }

    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    public function getOrigin(): string
    {
        return $this->origin;
    }

    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    public function getDestination(): string
    {
        return $this->destination;
    }

    #[Assert\NotBlank]
    #[Assert\Date]
    public function getDate(): string
    {
        return $this->date;
    }
}