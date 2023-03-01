<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiGetAvailControllerTest extends WebTestCase
{
    private const ENDPOINT_WITH_QUERY_STRING = '/api/avail?origin=MAD&destination=BIO&date=2022-06-01';
    private const ASSERTION = '[{"originCode":"MAD","originName":"Madrid Adolfo Suarez-Barajas","destinationCode":"BIO","destinationName":"Bilbao","start":"2022-06-01","end":"2022-06-01","transportNumber":"0426","companyCode":"IB","companyName":"Iberia"},{"originCode":"MAD","originName":"Madrid Adolfo Suarez-Barajas","destinationCode":"BIO","destinationName":"Bilbao","start":"2022-06-01","end":"2022-06-01","transportNumber":"0438","companyCode":"IB","companyName":"Iberia"},{"originCode":"MAD","originName":"Madrid Adolfo Suarez-Barajas","destinationCode":"BIO","destinationName":"Bilbao","start":"2022-06-01","end":"2022-06-01","transportNumber":"0440","companyCode":"IB","companyName":"Iberia"},{"originCode":"MAD","originName":"Madrid Adolfo Suarez-Barajas","destinationCode":"BIO","destinationName":"Bilbao","start":"2022-06-01","end":"2022-06-01","transportNumber":"0442","companyCode":"IB","companyName":"Iberia"},{"originCode":"MAD","originName":"Madrid Adolfo Suarez-Barajas","destinationCode":"BIO","destinationName":"Bilbao","start":"2022-06-01","end":"2022-06-01","transportNumber":"0448","companyCode":"IB","companyName":"Iberia"}]';

    public function testShouldReturnAValidJsonData(): void
    {
        $client = static::createClient();
        $client->request('GET', self::ENDPOINT_WITH_QUERY_STRING);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(
            self::ASSERTION,
            $client->getResponse()->getContent()
        );
    }

    /**
     * @dataProvider queryDataProvider
     */
    public function testShouldValidateWrongQueryData($url, $message): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(400);
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals('{"error":"' . $message . '"}', $client->getResponse()->getContent());
    }

    public function queryDataProvider(): array
    {
        return [
            [
                '/api/avail?origin=&destination=BIO&date=2022-06-01',
                'This value should not be blank.'
            ],
            [
                '/api/avail?origin=M&destination=BIO&date=2022-06-01',
                'This value is too short. It should have {{ limit }} character or more.|This value is too short. It should have {{ limit }} characters or more.'
            ],
            [
                '/api/avail?origin=MAD&destination=&date=2022-06-01',
                'This value should not be blank.'
            ],
            [
                '/api/avail?origin=MAD&destination=B&date=2022-06-01&date=wrong',
                'This value is too short. It should have {{ limit }} character or more.|This value is too short. It should have {{ limit }} characters or more.'
            ],
            [
                '/api/avail?origin=MAD&destination=BIO&date=wrong',
                'This value is not a valid date.'
            ],
        ];
    }
}