<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Entity\Product;
use App\Entity\TaxNumberPattern;
use App\Entity\TaxRate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Homepage', 'fa fa-home', $this->generateUrl('app_tax_calculator_index'));
        yield MenuItem::linkToCrud('Countries', 'fas fa-globe', Country::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-cart-shopping', Product::class);
        yield MenuItem::linkToCrud('Tax Number Patterns', 'fas fa-newspaper', TaxNumberPattern::class);
        yield MenuItem::linkToCrud('Tax Rates', 'fas fa-percent', TaxRate::class);
    }
}
