<?php

namespace App\Controller\Admin;

use App\Entity\TaxRate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class TaxRateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TaxRate::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->update(
                Crud::PAGE_INDEX,
                Action::DELETE,
                fn(Action $action) => $this->hideDeleteButtonOnTaxRatesWithCountries($action)
            )
            ->update(
                Crud::PAGE_DETAIL,
                Action::DELETE,
                fn(Action $action) => $this->hideDeleteButtonOnTaxRatesWithCountries($action)
            );
    }


    public function configureFields(string $pageName): iterable
    {
        yield NumberField::new('value');
        yield ArrayField::new('countries')
            ->onlyOnIndex();
    }

    private function hideDeleteButtonOnTaxRatesWithCountries(Action $action): Action
    {
        $action->displayIf(static fn(TaxRate $taxRate) => $taxRate->getCountries()->count() === 0);
        return $action;
    }
}
