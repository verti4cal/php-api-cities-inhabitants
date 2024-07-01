<?php

namespace App\Controller;

use App\DataTransferObject\PurchaseDTO;
use App\Service\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/purchases', name: 'app_purchases')]
class PurchaseController extends AbstractController
{
    public function __construct(
        private PurchaseService $purchaseService,
        private SerializerInterface $serializer
    ) {
    }

    #[Route('', name: 'post', methods: ['POST'])]
    public function post(#[MapRequestPayload] PurchaseDTO $dto): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('purchase:read')
            ->toArray();

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->purchaseService->createPurchase(
                    $dto->client,
                    $dto->item,
                    $dto->quantity,
                    $dto->price
                ),
                'json',
                $context
            )
        );
    }
}
