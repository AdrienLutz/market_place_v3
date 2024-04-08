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
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ProduitsCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
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
        yield MenuItem::linkToCrud('Categories', 'fas fa-paperclip', Categories::class);
        yield MenuItem::linkToCrud('Références', 'fas fa-calculator', References::class);
        yield MenuItem::linkToCrud('Distributeurs', 'fas fa-file', Distributeurs::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', User::class);

    }
}
