<?php

namespace App\Service;

use App\Entity\Client;
use App\Enum\GenderEnum;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ClientService
{
    public function __construct(
        private ClientRepository $clientRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function createClient(
        string $firstName,
        string $familyName,
        int $age,
        string $gender,
        string $IBAN,
        string $city,
        int $children
    ): Client {
        $client = new Client();
        $client->setFirstName($firstName);
        $client->setFamilyName($familyName);
        $client->setAge($age);
        $client->setGender(GenderEnum::tryFrom(strtolower($gender)));
        $client->setIBAN($IBAN);
        $client->setCity($city);
        $client->setChildren($children);
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    public function updateClient(
        int $id,
        string $firstName,
        string $familyName,
        int $age,
        string $gender,
        string $IBAN,
        string $city,
        int $children
    ): Client {
        $client = $this->clientRepository->find($id);

        if (!$client) {
            throw new ResourceNotFoundException();
        }

        $client->setFirstName($firstName);
        $client->setFamilyName($familyName);
        $client->setAge($age);
        $client->setGender(GenderEnum::tryFrom(strtolower($gender)));
        $client->setIBAN($IBAN);
        $client->setCity($city);
        $client->setChildren($children);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    public function deleteClient(int $id): void
    {
        $client = $this->clientRepository->find($id);

        if (!$client) {
            throw new ResourceNotFoundException();
        }

        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }

    /**
     * 
     * @param string|null $city 
     * @param int|null $children 
     * @param null|int|string $age 
     * @param null|int|string $expenses 
     * @param null|int|string $items 
     * @return Client[]
     */
    public function findClients(
        string $city = null,
        int $children = null,
        int | string $age = null,
        int | string $expenses = null,
        int | string $items = null
    ): array {
        if (!empty($age)) {
            if (!in_array($age, ['fibonacci', 'min', 'max'])) {
                throw new \InvalidArgumentException();
            }
        }

        if (!empty($expenses)) {
            if (!is_numeric($expenses) && !in_array($expenses, ['min', 'max'])) {
                throw new \InvalidArgumentException();
            }
        }

        if (!empty($items)) {
            if (!is_numeric($items) && !in_array($items, ['min', 'max'])) {
                throw new \InvalidArgumentException();
            }
        }

        return $this->clientRepository->findByFilter($city, $children, $age, $expenses, $items);
    }
}
