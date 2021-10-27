<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\AnnonceurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceurController extends AbstractController
{
    /**
     * @Route("/annonceur/{id}", name="annonceur_single", requirements={"id"="\d+"})
     */
    public function annonceur_single(AnnonceurRepository $annonceurRepository,AnnonceRepository $annonceRepository,
                                     int $id ): Response
    {
        $annonceur = $annonceurRepository->find($id);
        $annonces = $annonceRepository->findAnnoncesAPourvoir($annonceur);
        return $this->render('annonceur/_single_annonceur.html.twig', [
            'annonceur' => $annonceur,
            'annonces' => $annonces,
        ]);
    }
}