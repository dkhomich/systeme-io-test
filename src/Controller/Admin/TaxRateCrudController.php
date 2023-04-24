<?php

namespace App\Controller\Admin;

use App\Entity\TaxRate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TaxRateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TaxRate::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield NumberField::new('value');
        yield AssociationField::new('country');
    }

}
