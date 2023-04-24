<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Repository\TaxRateRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CountryCrudController extends AbstractCrudController
{
    public function __construct(private readonly TaxRateRepository $taxRateRepository)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Country::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');

        yield ArrayField::new('taxNumberPatterns')
        ->onlyOnIndex();

        yield AssociationField::new('taxNumberPatterns')
        ->hideOnIndex();


        yield NumberField::new('taxRateValue')
            ->setLabel('Tax Rate')
            ->formatValue(fn($value) => $value ? sprintf('%.2f%%', $value) : '---')
            ->onlyOnIndex();

        yield AssociationField::new('taxRate')
            ->hideOnIndex();
    }

}
