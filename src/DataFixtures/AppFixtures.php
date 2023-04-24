<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Product;
use App\Entity\TaxNumberPattern;
use App\Entity\TaxRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (
            [
                [
                    'name' => 'Germany',
                    'taxRate' => 19,
                    'taxNumberPattern' => '~^DE[\d]{9}$~ui',
                ],
                [
                    'name' => 'Italy',
                    'taxRate' => 22,
                    'taxNumberPattern' => '~^IT[\d]{11}$~ui',
                ],
                [
                    'name' => 'Greece',
                    'taxRate' => 24,
                    'taxNumberPattern' => '~^GR[\d]{9}$~ui',
                ],
            ] as $fixture
        ) {
            $country = (new Country())
                ->setName($fixture['name']);
            $taxRate = (new TaxRate())
                ->setValue($fixture['taxRate'])
                ->addCountry($country);
            $taxNumberPattern = (new TaxNumberPattern())
                ->setPattern($fixture['taxNumberPattern'])
                ->setCountry($country);

            $manager->persist($country);
            $manager->persist($taxRate);
            $manager->persist($taxNumberPattern);
        }


        $product = (new Product())
            ->setName('Headphones')
            ->setPrice(100);

        $manager->persist($product);

        $product = (new Product())
            ->setName('Phone case')
            ->setPrice(20);

        $manager->persist($product);


        $manager->flush();
    }
}
