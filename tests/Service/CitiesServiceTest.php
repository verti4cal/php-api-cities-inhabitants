<?php

namespace App\Tests\Service;

use App\Repository\ClientRepository;
use App\Service\CitiesService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CitiesServiceTest extends TestCase
{
    private MockObject & ClientRepository $clientRepository;

    private CitiesService $citiesService;

    public function setUp(): void
    {
        $this->clientRepository = $this->createMock(ClientRepository::class);
        $this->citiesService = new CitiesService($this->clientRepository);
    }

    public function testFindByFilterSuccess(): void
    {
        $cities = ["Leipzig", "Stuttgart", "Munich"];
        $this->clientRepository
            ->expects($this->any())
            ->method('findCitiesByFilter')
            ->willReturn($cities);

        $result = $this->citiesService->findByFilter('max', 'max', 'max', 'max');
        $this->assertIsArray($result);
        $this->assertEquals(3, count($result));
        $this->assertEquals($cities, $result);
    }

    public function testFindByFilterInvalidArgumentSpender(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->citiesService->findByFilter('bla', 'max', 'max', 'max');
    }

    public function testFindByFilterInvalidArgumentClients(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->citiesService->findByFilter('max', 'bla', 'max', 'max');
    }

    public function testFindByFilterInvalidArgumentAge(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->citiesService->findByFilter('max', 'max', 'bla', 'max');
    }

    public function testFindByFilterInvalidArgumentChildren(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->citiesService->findByFilter('max', 'max', 'max', 'bla');
    }
}
