<?php

namespace App\Controller;

use App\Entity\Annonceur;
use App\Form\AdoptantCompleteFormType;
use App\Form\AnnonceurCompleteFormType;
use App\Repository\AnnonceRepository;
use App\Repository\AnnonceurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @Route("/annonceurs", name="annonceurs_liste")
     */
    public function annonceurs(AnnonceurRepository $annonceurRepository):Response{
        $annonceurs = $annonceurRepository->findAll();
        return $this->render('annonceur/_liste_annonceurs.html.twig', [
            'annonceurs' => $annonceurs

        ]);
    }
    /**
     * @Route("/moncompte-annonceur", name="annonceur_account")
     */
    public function annonceur_account(AnnonceRepository $annonceRepository): Response
    {
        $annonceur = $this->getUser();
        $annonces = $annonceRepository->findBy(
            ['annonceur' => $annonceur],
            ['dateCreation' => 'DESC']
        );

        return $this->render("annonceur/annonceur_account.html.twig", [
            'annonceur' => $annonceur,
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/edit-account-annonceur", name="annonceur_update")
     */
    public function completeFormAdoptant(Request $request, EntityManagerInterface $em): Response
    {
        $annonceur = $this->getUser();

        $form = $this->createForm(AnnonceurCompleteFormType::class, $annonceur, [
            'method' => 'post'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonceur);
            $em->flush();

            $this->addFlash('success', 'Compte mis à jour ! 👍');

            return $this->redirectToRoute('default_index');
        }

        return $this->render('annonceur/_annonceur_update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
