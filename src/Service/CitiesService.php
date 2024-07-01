<?php

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;

class CitiesService
{
    public function __construct(private ClientRepository $clientRepository)
    {
    }

    /**
     * 
     * @param string|null $spender 
     * @param string|null $clients 
     * @param string|null $age 
     * @param string|null $children 
     * @return Client[]
     */
    public function findByFilter(
        string $spender = null,
        string $clients = null,
        string $age = null,
        string $children = null
    ): array {
        if (!empty($spender) && !in_array($spender, ['min', 'max'])) {
            throw new \InvalidArgumentException();
        }

        if (!empty($clients) && !in_array($clients, ['min', 'max'])) {
            throw new \InvalidArgumentException();
        }

        if (!empty($age) && !in_array($age, ['min', 'max'])) {
            throw new \InvalidArgumentException();
        }

        if (!empty($children) && !in_array($children, ['min', 'max'])) {
            throw new \InvalidArgumentException();
        }

        return $this->clientRepository->findCitiesByFilter($spender, $clients, $age, $children);
    }
}
