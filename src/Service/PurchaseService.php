<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Purchase;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class PurchaseService
{
    public function __construct(
        private ClientRepository $clientRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function createPurchase(int $clientId, string $item, int $quantity, float $price): Purchase
    {
        $client = $this->clientRepository->find($clientId);

        if (!$client) {
            throw new ResourceNotFoundException();
        }

        $purchase = new Purchase();
        $purchase->setClient($client);
        $purchase->setItemName($item);
        $purchase->setQuantity($quantity);
        $purchase->setPrice((string) $price);

        $this->entityManager->persist($purchase);
        $this->entityManager->flush();

        return $purchase;
    }
}
