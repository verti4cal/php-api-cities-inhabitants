<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CitiesControllerTest extends WebTestCase
{
    public function testGetSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/cities', [
            'spender' => 'min',
            'clients' => 'max',
            'age' => 'max',
            'children' => 'max'
        ]);

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $parsed = json_decode($response->getContent(), true);
        $this->assertIsArray($parsed);
        $this->assertCount(3, $parsed);
    }

    public function testGetInvalidArgument(): void
    {
        $client = static::createClient();
        $client->request('GET', '/cities', [
            'spender' => 'bla',
            'clients' => 'max',
            'age' => 'max',
            'children' => 'max'
        ]);

        $this->assertResponseStatusCodeSame(500);
    }
}
