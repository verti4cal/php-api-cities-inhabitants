<?php

namespace App\Controller;

use App\DataTransferObject\ClientDTO;
use App\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/clients', name: 'app_client_')]
class ClientController extends AbstractController
{
    public function __construct(
        private ClientService $clientService,
        private SerializerInterface $serializer
    ) {
    }

    #[Route('', name: 'get', methods: ['GET'])]
    public function get(Request $request): JsonResponse
    {
        $city = $request->query->get('city');
        $children = $request->query->get('children');
        $age = $request->query->get('age');
        $expenses = $request->query->get('expenses');
        $items = $request->query->get('items');

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('client:read')
            ->toArray();

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->clientService->findClients(
                    $city,
                    $children,
                    $age,
                    $expenses,
                    $items
                ),
                'json',
                $context
            )
        );
    }

    #[Route('', name: 'post', methods: ['POST'])]
    public function post(#[MapRequestPayload] ClientDTO $dto): JsonResponse
    {
        return $this->json($this->clientService->createClient(
            $dto->firstName,
            $dto->familyName,
            $dto->age,
            $dto->gender,
            $dto->IBAN,
            $dto->city,
            $dto->children
        ));
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->clientService->deleteClient($id);
        return $this->json(null, 204);
    }

    #[Route('/{id}', name: 'put', methods: ['PUT'])]
    public function put(int $id, #[MapRequestPayload] ClientDTO $dto): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('client:read')
            ->toArray();

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->clientService->updateClient(
                    $id,
                    $dto->firstName,
                    $dto->familyName,
                    $dto->age,
                    $dto->gender,
                    $dto->IBAN,
                    $dto->city,
                    $dto->children
                ),
                'json',
                $context
            )
        );
    }
}
