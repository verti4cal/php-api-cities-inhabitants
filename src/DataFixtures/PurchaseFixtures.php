<?php

namespace App\DataFixtures;

use App\Entity\Purchase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PurchaseFixtures extends Fixture
{

    const PURCHASES = [
        [
            "ID" => 1,
            "ClientID" => 1,
            "ItemName" => "Football",
            "Quantity" => 3,
            "Price" => 20
        ],
        [
            "ID" => 2,
            "ClientID" => 2,
            "ItemName" => "Basketball",
            "Quantity" => 5,
            "Price" => 25
        ],
        [
            "ID" => 3,
            "ClientID" => 3,
            "ItemName" => "Tennis Racket",
            "Quantity" => 2,
            "Price" => 50
        ],
        [
            "ID" => 4,
            "ClientID" => 4,
            "ItemName" => "Baseball Bat",
            "Quantity" => 7,
            "Price" => 30
        ],
        [
            "ID" => 5,
            "ClientID" => 5,
            "ItemName" => "Golf Ball",
            "Quantity" => 1,
            "Price" => 4
        ],
        [
            "ID" => 6,
            "ClientID" => 6,
            "ItemName" => "Hockey Stick",
            "Quantity" => 4,
            "Price" => 60
        ],
        [
            "ID" => 7,
            "ClientID" => 7,
            "ItemName" => "Volleyball",
            "Quantity" => 6,
            "Price" => 15
        ],
        [
            "ID" => 8,
            "ClientID" => 8,
            "ItemName" => "Swim Goggles",
            "Quantity" => 8,
            "Price" => 10
        ],
        [
            "ID" => 9,
            "ClientID" => 9,
            "ItemName" => "Yoga Mat",
            "Quantity" => 9,
            "Price" => 20
        ],
        [
            "ID" => 10,
            "ClientID" => 10,
            "ItemName" => "Dumbbells",
            "Quantity" => 3,
            "Price" => 45
        ],
        [
            "ID" => 11,
            "ClientID" => 11,
            "ItemName" => "Jump Rope",
            "Quantity" => 5,
            "Price" => 8
        ],
        [
            "ID" => 12,
            "ClientID" => 12,
            "ItemName" => "Boxing Gloves",
            "Quantity" => 2,
            "Price" => 35
        ],
        [
            "ID" => 13,
            "ClientID" => 13,
            "ItemName" => "Skateboard",
            "Quantity" => 7,
            "Price" => 75
        ],
        [
            "ID" => 14,
            "ClientID" => 14,
            "ItemName" => "Rollerblades",
            "Quantity" => 1,
            "Price" => 80
        ],
        [
            "ID" => 15,
            "ClientID" => 15,
            "ItemName" => "Bicycle Helmet",
            "Quantity" => 4,
            "Price" => 40
        ],
        [
            "ID" => 16,
            "ClientID" => 1,
            "ItemName" => "Soccer Cleats",
            "Quantity" => 6,
            "Price" => 55
        ],
        [
            "ID" => 17,
            "ClientID" => 2,
            "ItemName" => "Running Shoes",
            "Quantity" => 8,
            "Price" => 65
        ],
        [
            "ID" => 18,
            "ClientID" => 3,
            "ItemName" => "Gym Bag",
            "Quantity" => 9,
            "Price" => 30
        ],
        [
            "ID" => 19,
            "ClientID" => 4,
            "ItemName" => "Water Bottle",
            "Quantity" => 3,
            "Price" => 10
        ],
        [
            "ID" => 20,
            "ClientID" => 5,
            "ItemName" => "Sweatband",
            "Quantity" => 5,
            "Price" => 5
        ],
        [
            "ID" => 21,
            "ClientID" => 6,
            "ItemName" => "Treadmill",
            "Quantity" => 2,
            "Price" => 600
        ],
        [
            "ID" => 22,
            "ClientID" => 7,
            "ItemName" => "Exercise Bike",
            "Quantity" => 7,
            "Price" => 450
        ],
        [
            "ID" => 23,
            "ClientID" => 8,
            "ItemName" => "Elliptical",
            "Quantity" => 1,
            "Price" => 700
        ],
        [
            "ID" => 24,
            "ClientID" => 9,
            "ItemName" => "Weight Bench",
            "Quantity" => 4,
            "Price" => 150
        ],
        [
            "ID" => 25,
            "ClientID" => 10,
            "ItemName" => "Kettlebell",
            "Quantity" => 6,
            "Price" => 35
        ],
        [
            "ID" => 26,
            "ClientID" => 11,
            "ItemName" => "Resistance Bands",
            "Quantity" => 8,
            "Price" => 15
        ],
        [
            "ID" => 27,
            "ClientID" => 12,
            "ItemName" => "Foam Roller",
            "Quantity" => 9,
            "Price" => 25
        ],
        [
            "ID" => 28,
            "ClientID" => 13,
            "ItemName" => "Punching Bag",
            "Quantity" => 3,
            "Price" => 100
        ],
        [
            "ID" => 29,
            "ClientID" => 14,
            "ItemName" => "Speed Ladder",
            "Quantity" => 5,
            "Price" => 20
        ],
        [
            "ID" => 30,
            "ClientID" => 15,
            "ItemName" => "Agility Cones",
            "Quantity" => 2,
            "Price" => 10
        ],
        [
            "ID" => 31,
            "ClientID" => 1,
            "ItemName" => "Medicine Ball",
            "Quantity" => 7,
            "Price" => 30
        ],
        [
            "ID" => 32,
            "ClientID" => 2,
            "ItemName" => "Balance Ball",
            "Quantity" => 1,
            "Price" => 25
        ],
        [
            "ID" => 33,
            "ClientID" => 3,
            "ItemName" => "Step Platform",
            "Quantity" => 4,
            "Price" => 40
        ],
        [
            "ID" => 34,
            "ClientID" => 4,
            "ItemName" => "Pull-Up Bar",
            "Quantity" => 6,
            "Price" => 50
        ],
        [
            "ID" => 35,
            "ClientID" => 5,
            "ItemName" => "Ab Wheel",
            "Quantity" => 8,
            "Price" => 15
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PURCHASES as $purchase) {
            $purchaseEntity = new Purchase();
            $purchaseEntity->setClient($this->getReference('client_' . $purchase['ClientID']));
            $purchaseEntity->setItemName($purchase['ItemName']);
            $purchaseEntity->setQuantity($purchase['Quantity']);
            $purchaseEntity->setPrice((string) $purchase['Price']);
            $manager->persist($purchaseEntity);
        }

        $manager->flush();
    }

    /**
     * 
     * @return array<int, string>
     */
    public function getDependencies(): array
    {
        return [
            ClientFixtures::class,
        ];
    }
}
