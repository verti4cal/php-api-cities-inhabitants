<?php

namespace App\Controller;

use App\Service\CitiesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/cities', name: 'app_cities_')]
class CitiesController extends AbstractController
{
    public function __construct(
        private CitiesService $citiesService,
        private SerializerInterface $serializer
    ) {
    }

    #[Route('', name: 'get', methods: ['GET'])]
    public function get(Request $request): JsonResponse
    {
        $spender = $request->query->get('spender');
        $clients = $request->query->get('clients');
        $age = $request->query->get('age');
        $children = $request->query->get('children');

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('cities:read')
            ->toArray();

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->citiesService->findByFilter(
                    $spender,
                    $clients,
                    $age,
                    $children
                ),
                'json',
                $context
            )
        );
    }
}
