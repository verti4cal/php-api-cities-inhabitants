<?php

namespace App\Entity;

use App\Enum\GenderEnum;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $familyName = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(enumType: GenderEnum::class)]
    private ?GenderEnum $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $iban = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(nullable: true)]
    private ?int $children = null;

    /**
     * @var Collection<int, Purchase>
     */
    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'client', orphanRemoval: true)]
    private Collection $purchases;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): static
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?GenderEnum
    {
        return $this->gender;
    }

    public function setGender(GenderEnum $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): static
    {
        $this->iban = $iban;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->children;
    }

    public function setChildren(?int $children): static
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return Collection<int, Purchase>
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): static
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases->add($purchase);
            $purchase->setClient($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): static
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getClient() === $this) {
                $purchase->setClient(null);
            }
        }

        return $this;
    }
}
