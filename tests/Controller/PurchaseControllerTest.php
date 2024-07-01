<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaseControllerTest extends WebTestCase
{
    public function testPostSuccess(): void
    {
        $client = static::createClient();
        $client->request('POST', '/purchases', [
            'client' => 3,
            'item' => 'Football',
            'quantity' => 30,
            'price' => 23.5,
        ]);

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
    }
}
