<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Form\ChienType;
use App\Service\AnnonceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChienController extends AbstractController
{
    /**
     * @Route("/chien", name="chien")
     */
    public function formChien(Request $request, EntityManagerInterface $em): Response
    {

        $chien = new Chien();

        $form = $this->createForm(ChienType::class, $chien, [
            'method' => 'POST',
            //  mettre l'action
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chien->setAdopte(false);
            $em->persist($chien);
            $em->flush();

            $this->addFlash('success', 'Chien ajouté !');

            return $this->redirectToRoute('/');
        }

        return $this->render('chien/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/chien_adopter/{id}", name="chien_adopter", requirements={"id"="\d+"})
     *
     */
    public function adopter(Chien $chien, EntityManagerInterface $em, AnnonceService $annonceService): Response
    {

        $chien->setAdopte(true);
        $em->persist($chien);
        $em->flush();
        $annonce = $chien->getAnnonce();
        $annonceService->checkAnnonceAPourvoir($annonce->getId());
        return $this->redirectToRoute("annonces_single_annonce", ['id' => $annonce->getId()]);
    }
}
