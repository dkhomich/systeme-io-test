<?php

namespace App\Entity;

use App\Repository\TaxRateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaxRateRepository::class)]
class TaxRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?float $value = null;

    #[ORM\OneToMany(mappedBy: 'taxRate', targetEntity: Country::class)]
    private Collection $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->countries->contains($country)) {
            $this->countries->add($country);
            $country->setTaxRate($this);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->countries->removeElement($country)) {
            // set the owning side to null (unless already changed)
            if ($country->getTaxRate() === $this) {
                $country->setTaxRate(null);
            }
        }

        return $this;
    }
}
