<?php

namespace App\DataTransferObject;

class PurchaseDTO
{
    public string $item;
    public int $client;
    public int $quantity;
    public float $price;
}
