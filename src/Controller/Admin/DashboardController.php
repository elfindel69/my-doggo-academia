<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Adoptant;
use App\Entity\Annonceur;
use App\Entity\Race;
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
        return $this->render('admin/admin-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('My Doggo Academia');

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Admins', 'fas fa-list', Admin::class);
        yield MenuItem::linkToCrud('Adoptants', 'fas fa-list', Adoptant::class);
        yield MenuItem::linkToCrud('Annonceurs', 'fas fa-list', Annonceur::class);
        yield MenuItem::linkToCrud('Races de Chiens', 'fas fa-list', Race::class);
        return [
            MenuItem::linkToLogout('Logout', 'fa fa-exit'),
        ];
    }
}
