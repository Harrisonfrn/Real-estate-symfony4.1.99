<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Option;
use App\Entity\Property;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('<img src="/images/HEARTHSTONE_PARTNERS_LOGO.PNG" style=" width:50%; ">');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Prorpiété');
        yield MenuItem::linkToCrud('Biens', 'fa fa-building', Property::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class);
        yield MenuItem::linkToCrud('Options', 'fa fa-list-alt', Option::class);

        
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Gérer les utilisateurs', 'fa fa-user', Users::class);
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
    }

}
