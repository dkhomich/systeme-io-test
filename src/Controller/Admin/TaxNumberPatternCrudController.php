<?php

namespace App\Controller\Admin;

use App\Entity\TaxNumberPattern;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TaxNumberPatternCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TaxNumberPattern::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('pattern')
            ->setHelp('Enter a valid RegEx pattern');
        yield AssociationField::new('country');
    }

}
