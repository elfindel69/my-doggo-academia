<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\AnnonceurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     */
    public function index(AnnonceurRepository $utilisateurRepository, AnnonceRepository $annonceRepository): Response
    {

        $annonceurs = $utilisateurRepository->findAll();
        $annonces = $annonceRepository->findLast();

        return $this->render('home.html.twig', [
            'annonces' => $annonces,
            'annonceurs' => $annonceurs,
        ]);
    }
}
