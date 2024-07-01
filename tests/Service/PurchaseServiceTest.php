<?php

namespace App\Tests\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Service\PurchaseService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class PurchaseServiceTest extends TestCase
{
    private MockObject & ClientRepository $clientRepository;
    private MockObject & EntityManagerInterface $entityManager;

    private PurchaseService $purchaseService;

    public function setUp(): void
    {
        $this->clientRepository = $this->createMock(ClientRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->purchaseService = new PurchaseService($this->clientRepository, $this->entityManager);
    }

    public function testCreatePurchase(): void
    {
        $this->clientRepository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(new Client());

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->anything());

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->purchaseService->createPurchase(1, 'test', 1, 1.0);
    }

    public function testCreatePurchaseResourceNotFound(): void
    {
        $this->expectException(ResourceNotFoundException::class);

        $this->clientRepository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->entityManager
            ->expects($this->never())
            ->method('persist');

        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $this->purchaseService->createPurchase(1, 'test', 1, 1.0);
    }
}
