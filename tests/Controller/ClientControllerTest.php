<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    public function testGetSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/clients', [
            'age' => 'fibonacci',
        ]);

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $parsed = json_decode($response->getContent(), true);
        $this->assertIsArray($parsed);
        $this->assertCount(1, $parsed);
    }

    public function testGetInvalidArgument(): void
    {
        $client = static::createClient();
        $client->request('GET', '/clients', [
            'age' => 'bla',
        ]);

        $this->assertResponseStatusCodeSame(500);
    }

    public function testPostSuccess(): void
    {
        $client = static::createClient();
        $client->request('POST', '/clients', [
            'firstName' => 'John',
            'familyName' => 'Doe',
            'age' => 30,
            'gender' => 'male',
            'IBAN' => 'FR7630006000011234567890189',
            'city' => 'Cologne',
            'children' => 2
        ]);

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
    }

    public function testDeleteSuccess(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/clients/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(204);
    }

    public function testPutSuccess(): void
    {
        $dto = [
            'firstName' => 'John',
            'familyName' => 'Doe',
            'age' => 30,
            'gender' => 'male',
            'IBAN' => 'FR7630006000011234567890189',
            'city' => 'Cologne',
            'children' => 2
        ];

        $client = static::createClient();
        $client->request('PUT', '/clients/2', $dto);

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $parsed = json_decode($response->getContent(), true);
        $this->assertEquals($dto['IBAN'], $parsed['iban']);
        $this->assertEquals($dto['city'], $parsed['city']);
        $this->assertEquals($dto['children'], $parsed['children']);
        $this->assertEquals($dto['firstName'], $parsed['firstName']);
        $this->assertEquals($dto['familyName'], $parsed['familyName']);
        $this->assertEquals($dto['age'], $parsed['age']);
        $this->assertEquals($dto['gender'], $parsed['gender']);
    }
}
