<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Annonceur;
use App\Entity\Chien;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        $annonces = $annonceRepository->findWithRelations();

        return $this->render('annonce/_liste_annonces.html.twig', [
            'annonces' => $annonces
        ]);
    }

    /**
     * Ici, on peut s'assurer que le paramètre page est un entier (l'expression régulière \d+ fait cette vérification)
     *
     * @Route("/annonce/{id}", name="annonces_single_annonce", requirements={"id"="\d+"})
     */
    public function details(AnnonceRepository $annonceRepository, int $id): Response
    {
        $annonce = $annonceRepository->find($id);
        return $this->render('annonce/_single_annonce.html.twig', [
            'annonce' => $annonce
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_annonce", requirements={"id"="\d+"})
     * @IsGranted("ROLE_ANNONCEUR")
     */
    public function delete(EntityManagerInterface $em, Annonce $annonce): Response
    {
        $annonceur = $this->getUser();

        if ($annonce->getAnnonceur()->getId() == $annonceur->getId()) {
            $em->remove($annonce);
            $em->flush();
        }

        return $this->redirectToRoute('annonceur_account');
    }

    /**
     * @Route("/update-annonce/{id}", name="update_annonce", requirements={"id"="\d+"})
     * @IsGranted("ROLE_ANNONCEUR")
     */
    public function update(EntityManagerInterface $em,
                           Request                $request,
                           AnnonceRepository      $annonceRepository, int $id): Response
    {
        $annonce = $annonceRepository->find($id);

        $form = $this->createForm(AnnonceType::class, $annonce, [
            'method' => 'post'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('success', 'Annonce modifiée !');

            return $this->redirectToRoute('annonceur_account');
        }

        return $this->render('annonce/_new_annonce_form.html.twig', [
            'form' => $form->createView()
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
        /** @var Annonceur $annonceur */
        $annonceur = $this->getUser();
        $annonce->setAnnonceur($annonceur);
        $annonce->setAPourvoir(true);
        $chien = new Chien();
        $chien->setAdopte(false);
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
            return $this->redirectToRoute('annonces_single_annonce',
                [
                    "id" => $annonce->getId()
                ]);
        }

        return $this->render('annonce/_new_annonce_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/checkDemandeAdoption/{id}", name="demandeAdoption", requirements={"id"="\d+"})
     */
    public function demandeAdoption(int $id): Response
    {
        $user = $this->getUser();

        if ($user) {
            return $this->redirectToRoute('demande_adoption', array("id" => $id));
        } else {
            return $this->redirectToRoute('adoptant_login');
        }
    }
}