<?php


namespace Unit\Service;

use App\Entity\Country;
use App\Entity\Product;
use App\Entity\TaxNumberPattern;
use App\Entity\TaxRate;
use App\Repository\TaxNumberPatternRepository;
use App\Service\TaxCalculatorService;
use PHPUnit\Framework\TestCase;

class TaxCalculatorServiceTest extends TestCase
{
    /**
     * @dataProvider calculateDataProvider
     */
    public function testCalculateReturnsRightTax(Product $product, Country $country, float $expectedTaxAmount): void
    {
        $taxNumberPatternRepoMock = $this->createMock(TaxNumberPatternRepository::class);
        $calculateService = new TaxCalculatorService($taxNumberPatternRepoMock);

        $this->assertSame($expectedTaxAmount, $calculateService->calculate($product, $country));
    }

    /**
     * @dataProvider taxNumberPatternDataProvider
     */
    public function testTaxNumberPatternMatchingWorks(string $taxNumber, ?string $countryName): void
    {
        $countries = $this->makeCountriesData();
        $taxNumberPatterns = array_column($countries, 'taxNumberPattern');


        $taxNumberPatternRepoMock = $this->createConfiguredMock(
            TaxNumberPatternRepository::class,
            [
                'findAll' => $taxNumberPatterns,
            ]
        );

        $calculateService = new TaxCalculatorService($taxNumberPatternRepoMock);

        $this->assertSame(
            $calculateService->getCountryByTaxNumber($taxNumber),
            $countryName ? $this->getCountry($countryName, $countries) : null
        );
    }

    public function calculateDataProvider(): iterable
    {
        $countries = $this->makeCountriesData();
        $headPhones = (new Product())->setName('Headphones')->setPrice(100.00);
        $phoneCase = (new Product())->setName('Phone case')->setPrice(20.00);

        yield 'Headphones in Germany' => [$headPhones, $this->getCountry('Germany', $countries), 19.0];
        yield 'Headphones in Italy' => [$headPhones, $this->getCountry('Italy', $countries), 22.0];
        yield 'Headphones in Greece' => [$headPhones, $this->getCountry('Greece', $countries), 24.0];
        yield 'Phone case in Germany' => [$phoneCase, $this->getCountry('Germany', $countries), 3.8];
        yield 'Phone case in Italy' => [$phoneCase, $this->getCountry('Italy', $countries), 4.4];
        yield 'Phone case in Greece' => [$phoneCase, $this->getCountry('Greece', $countries), 4.8];
    }

    public function taxNumberPatternDataProvider(): iterable
    {
        yield 'Valid German tax number uppercase' => ['DE123456789', 'Germany'];
        yield 'Valid German tax number lowercase' => ['de123456789', 'Germany'];
        yield 'Valid Italian tax number uppercase' => ['IT12345678900', 'Italy'];
        yield 'Valid Italian tax number mixed case' => ['iT12345678900', 'Italy'];
        yield 'Valid Greek tax number uppercase' => ['GR123456789', 'Greece'];
        yield 'Valid Greek tax number mixed case' => ['Gr123456789', 'Greece'];
        yield 'Invalid Greek tax number mixed case' => ['Gr12345678900', null];
    }

    private function makeCountriesData(): array
    {
        $countries = [];
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

            $country->setTaxRate($taxRate);

            $countries[$country->getName()] = [
                'country' => $country,
                'taxRate' => $taxRate,
                'taxNumberPattern' => $taxNumberPattern,
            ];
        }

        return $countries;
    }

    private function getCountry(string $countryName, array $countries): Country
    {
        return $countries[$countryName]['country'];
    }
}
