<?php

namespace App\Tests\Flight\Application;

use App\Flight\Application\GetInfoFromFlightSegmentUseCase;
use App\Flight\Application\GetInfoFromFlightSegmentUseResponse;
use PHPUnit\Framework\TestCase;

class GetInfoFromFlightSegmentUseCaseTest extends TestCase
{
    private const ASSERTION_FLIGHT = [
        [
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            '2022-06-01',
            '2022-06-01',
            '0426',
            'IB',
            'Iberia',
        ],
        [
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            '2022-06-01',
            '2022-06-01',
            '0438',
            'IB',
            'Iberia',
        ],
        [
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            '2022-06-01',
            '2022-06-01',
            '0440',
            'IB',
            'Iberia',
        ],
        [
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            '2022-06-01',
            '2022-06-01',
            '0442',
            'IB',
            'Iberia',
        ],
        [
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            '2022-06-01',
            '2022-06-01',
            '0448',
            'IB',
            'Iberia',
        ],
        [
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            '2022-06-01',
            '2022-06-01',
            '0446',
            'IB',
            'Iberia',
        ],
        [
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            '2022-06-01',
            '2022-06-01',
            '0448',
            'IB',
            'Iberia',
        ],
    ];

    public function testGetInfoFromFlightSegmentUseCase(): void
    {
        $sut = new GetInfoFromFlightSegmentUseCase(
            '/../../../ExampleFiles/MAD_BIO_OW_1PAX_RS_NO_SOAP.xml'
        );

        $responseList = $sut->__invoke();

        foreach ($responseList as $index=>$response) {
            $this->assertResponse($response, $index);
        }
    }

    private function assertResponse(GetInfoFromFlightSegmentUseResponse $response, $index): void
    {
        $this->assertSame(self::ASSERTION_FLIGHT[$index][0], $response->getOriginCode());
        $this->assertSame(self::ASSERTION_FLIGHT[$index][1], $response->getOriginName());
        $this->assertSame(self::ASSERTION_FLIGHT[$index][2], $response->getDestinationCode());
        $this->assertSame(self::ASSERTION_FLIGHT[$index][3], $response->getDestinationName());
        $this->assertSame(self::ASSERTION_FLIGHT[$index][4], $response->getStart());
        $this->assertSame(self::ASSERTION_FLIGHT[$index][5], $response->getEnd());
        $this->assertSame(self::ASSERTION_FLIGHT[$index][6], $response->getTransportNumber());
        $this->assertSame(self::ASSERTION_FLIGHT[$index][7], $response->getCompanyCode());
        $this->assertSame(self::ASSERTION_FLIGHT[$index][8], $response->getCompanyName());
    }
}