<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAdoptionController extends AbstractController
{
    /**
     * @Route("/demandeAdoption", name="demande_adoption")
     */
    public function index(): Response
    {
        return $this->render('demande_adoption/index.html.twig', [
            'controller_name' => 'DemandeAdoptionController',
        ]);
    }
}
