<?php

namespace App\Tests\Service;

use App\Entity\Client;
use App\Enum\GenderEnum;
use App\Repository\ClientRepository;
use App\Service\ClientService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ClientServiceTest extends TestCase
{
    private MockObject & ClientRepository $clientRepository;
    private MockObject & EntityManagerInterface $entityManager;

    private ClientService $clientService;

    public function setUp(): void
    {
        $this->clientRepository = $this->createMock(ClientRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->clientService = new ClientService($this->clientRepository, $this->entityManager);
    }

    public function testCreateClient(): void
    {
        $client = new Client();
        $client->setFirstName('John');
        $client->setFamilyName('Doe');
        $client->setAge(30);
        $client->setGender(GenderEnum::Male);
        $client->setIBAN('FR1234567890123456789012345');
        $client->setCity('Paris');
        $client->setChildren(2);

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($client);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $result = $this->clientService->createClient('John', 'Doe', 30, 'male', 'FR1234567890123456789012345', 'Paris', 2);
        $this->assertEquals($client, $result);
    }

    public function testUpdateClient(): void
    {
        $client = new Client();
        $client->setFirstName('John');
        $client->setFamilyName('Doe');
        $client->setAge(30);
        $client->setGender(GenderEnum::Male);
        $client->setIBAN('FR1234567890123456789012345');
        $client->setCity('Paris');
        $client->setChildren(2);

        $this->clientRepository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($client);

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($client);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $result = $this->clientService->updateClient(1, 'John', 'Doe', 30, 'male', 'FR1234567890123456789012346', 'Paris', 2);
        $this->assertEquals('FR1234567890123456789012346', $result->getIban());
    }

    public function testUpdateClientNotFound(): void
    {
        $this->clientRepository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->expectException(ResourceNotFoundException::class);
        $this->clientService->updateClient(1, 'John', 'Doe', 30, 'male', 'FR1234567890123456789012346', 'Paris', 2);
    }

    public function testDeleteClient(): void
    {
        $this->clientRepository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(new Client());

        $this->entityManager
            ->expects($this->once())
            ->method('remove')
            ->with(new Client());

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->clientService->deleteClient(1);
    }

    public function testDeleteClientNotFound(): void
    {
        $this->clientRepository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->expectException(ResourceNotFoundException::class);
        $this->clientService->deleteClient(1);
    }

    public function testFindClients(): void
    {
        $this->clientRepository
            ->expects($this->once())
            ->method('findByFilter')
            ->willReturn([
                new Client()
            ]);

        $result = $this->clientService->findClients('Cologne', 2, 'fibonacci', 'max', 'max');

        $this->assertCount(1, $result);
        $this->assertInstanceOf(Client::class, $result[0]);
    }

    public function testFindClientsInvalidArgumentAge(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->clientService->findClients('Cologne', 2, 'bla', 'max', 'max');
    }

    public function testFindClientsInvalidArgumentExpenses(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->clientService->findClients('Cologne', 2, 'fibonacci', 'bla', 'max');
    }

    public function testFindClientsInvalidArgumentItems(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->clientService->findClients('Cologne', 2, 'fibonacci', 'max', 'bla');
    }
}
