<?php

namespace App\Controller;

use App\Entity\Annonceur;
use App\Repository\AnnonceRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     */
    public function index(UtilisateurRepository $utilisateurRepository, AnnonceRepository $annonceRepository): Response
    {
        $annonceurs = $utilisateurRepository->findAnnonceurs();
        $annonces = $annonceRepository->findLast();

        return $this->render('home.html.twig', [
            'annonces' => $annonces,
            'annonceurs' => $annonceurs,
        ]);
    }
}
