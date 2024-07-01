<?php

namespace App\Service;

use App\Repository\ClientRepository;

class CitiesService
{
    public function __construct(private ClientRepository $clientRepository)
    {
    }

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
