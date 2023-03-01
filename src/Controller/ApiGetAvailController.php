<?php

namespace App\Controller;

use App\Flight\Application\GetInfoFromFlightSegmentUseCase;
use App\Flight\Application\GetInfoFromFlightSegmentUseResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiGetAvailController extends AbstractController
{
    public function __construct(private readonly GetInfoFromFlightSegmentUseCase $getInfoFromFlightSegmentUseCase)
    {
    }

    #[Route('/api/avail', name: 'api_get_avail')]
    public function index(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $segmentRequest = new SegmentRequest($request);
        $errors = $validator->validate($segmentRequest);

        if (count($errors) > 0) {
            return $this->json([
                'error' => $errors->get(0)->getMessageTemplate(),
            ], 400);
        }

        $flightList = $this->getInfoFromFlightSegmentUseCase->__invoke(
            $segmentRequest->getOrigin(),
            $segmentRequest->getDestination(),
            $segmentRequest->getDate()
        );

        return $this->json(
            array_map(
                fn (GetInfoFromFlightSegmentUseResponse $response) => $response->toArray(),
                $flightList
            )
        );
    }
}
