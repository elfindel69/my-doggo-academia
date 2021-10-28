<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonces", name="annonces_annonces")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces2 = $annonceRepository->findBy(
            ['aPourvoir' => true]
        );

        $annonces = $annonceRepository->findAll();
        return $this->render('annonce/_liste_annonces.html.twig', [
            'annonces' => $annonces2
        ]);
    }
    /**
     * Ici, on peut s'assurer que le paramètre page est un entier (l'expression régulière \d+ fait cette vérification)
     *
     * @Route("/annonce/{id}", name="annonces_single_annonce", requirements={"id"="\d+"})
     */
    public function details(AnnonceRepository $annonceRepository,int $id): Response{
        $annonce = $annonceRepository->find($id);
        return $this->render('annonce/_single_annonce.html.twig', [
            'annonce' => $annonce
        ]);
    }

}