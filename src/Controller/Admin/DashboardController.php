<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Adoptant;
use App\Entity\Annonceur;
use App\Entity\Race;
use App\Repository\AdminRepository;
use App\Repository\AdoptantRepository;
use App\Repository\AnnonceurRepository;
use App\Repository\RaceRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    private AdminRepository $adminRepository;
    private AdoptantRepository $adoptantRepository;
    private RaceRepository $raceRepository;
    private AnnonceurRepository $annonceurRepository;

    public function __construct(AdminRepository $adminRepository, AdoptantRepository $adoptantRepository
        , AnnonceurRepository                   $annonceurRepository, RaceRepository $raceRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->adoptantRepository = $adoptantRepository;
        $this->annonceurRepository = $annonceurRepository;
        $this->raceRepository = $raceRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $nbAdmins = $this->adminRepository->countElements();
        $nbAdoptants = $this->adoptantRepository->countElements();
        $nbAnnonceurs = $this->annonceurRepository->countElements();
        $nbRaces = $this->raceRepository->countElements();
        return $this->render('admin/admin-dashboard.html.twig', [
            'nbAdmins' => $nbAdmins,
            'nbAdoptants' => $nbAdoptants,
            'nbAnnonceurs' => $nbAnnonceurs,
            'nbRaces' => $nbRaces
        ]);
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
