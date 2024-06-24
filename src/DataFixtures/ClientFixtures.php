<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Enum\GenderEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    const CLIENTS = [
        [
            "ID" => 1,
            "FirstName" => "John",
            "FamilyName" => "Doe",
            "Age" => 45,
            "Gender" => "Male",
            "IBAN" => "DE91100000000123",
            "City" => "Berlin",
            "NumberOfChildren" => 2
        ],
        [
            "ID" => 2,
            "FirstName" => "Jane",
            "FamilyName" => "Smith",
            "Age" => 30,
            "Gender" => "Female",
            "IBAN" => "DE91100000000123",
            "City" => "Berlin",
            "NumberOfChildren" => 1
        ],
        [
            "ID" => 3,
            "FirstName" => "Alice",
            "FamilyName" => "Johnson",
            "Age" => 50,
            "Gender" => "Female",
            "IBAN" => "DE91100000000123",
            "City" => "Munich",
            "NumberOfChildren" => 3
        ],
        [
            "ID" => 4,
            "FirstName" => "Bob",
            "FamilyName" => "Williams",
            "Age" => 35,
            "Gender" => "Male",
            "IBAN" => "DE91100000000123",
            "City" => "Munich",
            "NumberOfChildren" => 0
        ],
        [
            "ID" => 5,
            "FirstName" => "Charlie",
            "FamilyName" => "Brown",
            "Age" => 40,
            "Gender" => "Male",
            "IBAN" => "DE91100000000123",
            "City" => "Hamburg",
            "NumberOfChildren" => 2
        ],
        [
            "ID" => 6,
            "FirstName" => "Mary",
            "FamilyName" => "Davis",
            "Age" => 25,
            "Gender" => "Female",
            "IBAN" => "DE91100000000123",
            "City" => "Hamburg",
            "NumberOfChildren" => 1
        ],
        [
            "ID" => 7,
            "FirstName" => "Robert",
            "FamilyName" => "Miller",
            "Age" => 55,
            "Gender" => "Male",
            "IBAN" => "DE91100000000123",
            "City" => "Frankfurt",
            "NumberOfChildren" => 3
        ],
        [
            "ID" => 8,
            "FirstName" => "Linda",
            "FamilyName" => "Wilson",
            "Age" => 60,
            "Gender" => "Female",
            "IBAN" => "DE91100000000123",
            "City" => "Frankfurt",
            "NumberOfChildren" => 0
        ],
        [
            "ID" => 9,
            "FirstName" => "David",
            "FamilyName" => "Moore",
            "Age" => 20,
            "Gender" => "Male",
            "IBAN" => "DE91100000000123",
            "City" => "Cologne",
            "NumberOfChildren" => 1
        ],
        [
            "ID" => 10,
            "FirstName" => "Susan",
            "FamilyName" => "Taylor",
            "Age" => 65,
            "Gender" => "Female",
            "IBAN" => "DE91100000000123",
            "City" => "Cologne",
            "NumberOfChildren" => 2
        ],
        [
            "ID" => 11,
            "FirstName" => "James",
            "FamilyName" => "Anderson",
            "Age" => 70,
            "Gender" => "Male",
            "IBAN" => "DE91100000000123",
            "City" => "Stuttgart",
            "NumberOfChildren" => 3
        ],
        [
            "ID" => 12,
            "FirstName" => "Patricia",
            "FamilyName" => "Thomas",
            "Age" => 75,
            "Gender" => "Female",
            "IBAN" => "DE91100000000123",
            "City" => "Stuttgart",
            "NumberOfChildren" => 0
        ],
        [
            "ID" => 13,
            "FirstName" => "Michael",
            "FamilyName" => "Jackson",
            "Age" => 80,
            "Gender" => "Male",
            "IBAN" => "DE91100000000123",
            "City" => "Düsseldorf",
            "NumberOfChildren" => 1
        ],
        [
            "ID" => 14,
            "FirstName" => "Sarah",
            "FamilyName" => "White",
            "Age" => 85,
            "Gender" => "Female",
            "IBAN" => "DE91100000000123",
            "City" => "Düsseldorf",
            "NumberOfChildren" => 2
        ],
        [
            "ID" => 15,
            "FirstName" => "William",
            "FamilyName" => "Harris",
            "Age" => 90,
            "Gender" => "Male",
            "IBAN" => "DE91100000000123",
            "City" => "Leipzig",
            "NumberOfChildren" => 3
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CLIENTS as $client) {
            $clientEntity = new Client();
            $clientEntity->setFirstName($client['FirstName']);
            $clientEntity->setFamilyName($client['FamilyName']);
            $clientEntity->setAge($client['Age']);
            $clientEntity->setGender(GenderEnum::tryFrom(strtolower($client['Gender'])));
            $clientEntity->setIBAN($client['IBAN']);
            $clientEntity->setCity($client['City']);
            $clientEntity->setChildren($client['NumberOfChildren']);
            $manager->persist($clientEntity);

            $this->addReference('client_' . $client['ID'], $clientEntity);
        }

        $manager->flush();
    }
}
