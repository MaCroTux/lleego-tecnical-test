<?php

namespace App\Tests\Flight\Application;

use App\Flight\Application\GetInfoFromFlightSegmentUseCase;
use App\Flight\Application\GetInfoFromFlightSegmentUseResponse;
use App\Flight\Domain\FlightSegmentService;
use App\Flight\Domain\InvalidDateException;
use App\Flight\Domain\XmlReadException;
use App\Flight\Infrastructure\SegmentReadFileNoSoapRepository;
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

    public function testGetInfoFromFlightSegment(): void
    {
        $origin = 'MAD';
        $destination = 'BIO';
        $date = '2022-06-01';

        $sut = new GetInfoFromFlightSegmentUseCase(
            new FlightSegmentService(
                new SegmentReadFileNoSoapRepository(
                    '/../../../ExampleFiles/MAD_BIO_OW_1PAX_RS_NO_SOAP.xml'
                )
            )
        );

        $responseList = $sut->__invoke($origin, $destination, $date);

        foreach ($responseList as $index=>$response) {
            $this->assertResponse($response, $index);
        }
    }

    /**
     * @dataProvider providerFlightSegmentWithFilters
     */
    public function testGetInfoFromFlightSegmentWithFilter(
        string $origin,
        string $destination,
        string $date,
        int $numberResult
    ): void {
        $sut = new GetInfoFromFlightSegmentUseCase(
            new FlightSegmentService(
                new SegmentReadFileNoSoapRepository(
                    '/../../../ExampleFiles/MAD_BIO_OW_1PAX_RS_NO_SOAP.xml'
                )
            )
        );

        $responseList = $sut->__invoke($origin, $destination, $date);
        $this->assertCount($numberResult, $responseList);
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

    public function testShouldFailWhenXmlFileIsNotReadable(): void
    {
        $this->expectException(XmlReadException::class);

        new GetInfoFromFlightSegmentUseCase(
            new FlightSegmentService(
                new SegmentReadFileNoSoapRepository(
                    '/../../../ExampleFiles/MAD_BIO_OW_1PAX_RS_NO_SOAP_ERROR.xml'
                )
            )
        );
    }

    public function testShouldThrowInvalidDateFormarExceptionWhenDateStringIsInvalid(): void
    {
        $this->expectException(InvalidDateException::class);

        $sut = new GetInfoFromFlightSegmentUseCase(
            new FlightSegmentService(
                new SegmentReadFileNoSoapRepository(
                    '/../../../ExampleFiles/MAD_BIO_OW_1PAX_RS_NO_SOAP.xml'
                )
            )
        );

        $sut->__invoke('MAD', 'BIO', '202/06/01');
    }

    public function providerFlightSegmentWithFilters(): array
    {
        return [
            'When this parameters, use case return 5 results' => [
                'MAD',
                'BIO',
                '2022-06-01',
                5
            ],
            'When origin parameter is wrong, use case return 0 results' => [
                '--',
                'BIO',
                '2022-06-01',
                0
            ],
            'When destination parameters is wrong, use case return 0 results' => [
                'MAD',
                '--',
                '2022-06-01',
                0
            ],
            'When date parameters is wrong, use case return 0 results' => [
                'MAD',
                'BIO',
                '2023-06-01',
                0
            ],
        ];
    }
}