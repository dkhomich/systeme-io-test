<?php

namespace App\Service;

use App\Entity\Country;
use App\Entity\Product;
use App\Repository\TaxNumberPatternRepository;

class TaxCalculatorService
{
    private const TAX_AMOUNT_PRECISION = 2;

    public function __construct(
        private readonly TaxNumberPatternRepository $taxNumberPatternRepository
    ) {
    }

    public function calculate(Product $product, Country $country): float
    {
        if (function_exists('bcmul')) {
            // High-precision calculation if php-bcmath is installed
            return (float)bcmul(
                (string)$product->getPrice(),
                (string)$country->getTaxRate()->getValue() / 100,
                self::TAX_AMOUNT_PRECISION
            );
        } else {
            // Default fallback
            return round($product->getPrice() * $country->getTaxRate()->getValue() / 100, self::TAX_AMOUNT_PRECISION);
        }
    }

    public function getCountryByTaxNumber(string $taxNumber): ?Country
    {
        foreach ($this->taxNumberPatternRepository->findAll() as $taxNumberPattern) {
            if (preg_match($taxNumberPattern->getPattern(), $taxNumber)) {
                return $taxNumberPattern->getCountry();
            }
        }
        return null;
    }
}
