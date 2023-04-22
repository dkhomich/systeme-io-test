<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: TaxNumberPattern::class, orphanRemoval: true)]
    private Collection $taxNumberPatterns;

    #[ORM\OneToOne(mappedBy: 'country', cascade: ['persist', 'remove'])]
    private ?TaxRate $taxRate = null;

    public function __construct()
    {
        $this->taxNumberPatterns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, TaxNumberPattern>
     */
    public function getTaxNumberPatterns(): Collection
    {
        return $this->taxNumberPatterns;
    }

    public function addTaxNumberPattern(TaxNumberPattern $taxNumberPattern): self
    {
        if (!$this->taxNumberPatterns->contains($taxNumberPattern)) {
            $this->taxNumberPatterns->add($taxNumberPattern);
            $taxNumberPattern->setCountry($this);
        }

        return $this;
    }

    public function removeTaxNumberPattern(TaxNumberPattern $taxNumberPattern): self
    {
        if ($this->taxNumberPatterns->removeElement($taxNumberPattern)) {
            // set the owning side to null (unless already changed)
            if ($taxNumberPattern->getCountry() === $this) {
                $taxNumberPattern->setCountry(null);
            }
        }

        return $this;
    }

    public function getTaxRate(): ?TaxRate
    {
        return $this->taxRate;
    }

    public function setTaxRate(TaxRate $taxRate): self
    {
        // set the owning side of the relation if necessary
        if ($taxRate->getCountry() !== $this) {
            $taxRate->setCountry($this);
        }

        $this->taxRate = $taxRate;

        return $this;
    }
}
