<?php

namespace App\Form\Model;

use App\Entity\Country;
use App\Entity\Product;

class TaxCalculatorFormModel
{
    private Product $product;
    private string $taxNumber;
    private ?Country $country = null;
    private ?float $taxAmount = null;


    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): TaxCalculatorFormModel
    {
        $this->product = $product;
        return $this;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): TaxCalculatorFormModel
    {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): TaxCalculatorFormModel
    {
        $this->country = $country;
        return $this;
    }

    public function getTaxAmount(): ?float
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(?float $taxAmount): TaxCalculatorFormModel
    {
        $this->taxAmount = $taxAmount;
        return $this;
    }
}
