<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Chien;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route ("/nouvelleAnnonce", name="nouvelle_annonce")
     */
    public function form(Request $request, EntityManagerInterface $em): Response
    {
        $annonce = new Annonce();
        $annonce->setDateCreation(new DateTime());
        $annonce->setDateMaJ(new DateTime());
        $annonce->setAnnonceur($this->getUser());
        $chien = new Chien();
        $annonce->addChien($chien);// pour avoir un premier chien dans le formulaire

        $form = $this->createForm(AnnonceType::class, $annonce, [
            'method' => 'post',
            // rajouter une action
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonce);
            $em->flush();
            $this->addFlash('success', 'Annonce ajoutée avec succès');
            return $this->redirectToRoute('annonces_single_annonce' ,
                [
                   "id" => $annonce->getId()
                ]);
        }

        return $this->render('annonce/_new_annonce_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}