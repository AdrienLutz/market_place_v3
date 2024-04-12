<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Distributeurs;
use App\Entity\Produits;
use App\Entity\References;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ProduitsCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Market Place V3 Administration')
            ->setTitle('<img src="../../../public/img/logo_sf6.png" alt="symfony_6" title="symfony 6" />')
            ->renderSidebarMinimized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Produits', 'fa brands fa-product-hunt', Produits::class);
        yield MenuItem::linkToCrud('Références', 'fas fa-calculator', References::class);
        // les ROLE_USER ne peuvent voir que les produits et les références
        if ($this->isGranted("ROLE_ADMIN)"))
        yield MenuItem::linkToCrud('Categories', 'fas fa-paperclip', Categories::class);
        yield MenuItem::linkToCrud('Distributeurs', 'fas fa-file', Distributeurs::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', User::class);

    }
}
