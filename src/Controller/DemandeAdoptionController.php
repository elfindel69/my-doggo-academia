<?php

namespace App\Controller;

use App\Entity\DemandeAdoption;
use App\Form\DemandeAdoptionType;
use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAdoptionController extends AbstractController
{
    /**
     * @Route("/demandeAdoption/{id}", name="demande_adoption", requirements={"id"="\d+"})
     */
    public function adoption_request(Request $request, EntityManagerInterface $em, int $id, AnnonceRepository $annonceRepository): Response
    {
        $demandeAdoption = new DemandeAdoption();
        $annonce = $annonceRepository->find($id);

        $form = $this->createForm(DemandeAdoptionType::class, $demandeAdoption, [
            'method' => 'post',
            'id' => $id
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $demandeAdoption
                ->setAcceptee(false)
                ->setAdoptant($this->getUser())
                ->setAnnonce($annonce)
                ->setAnnonceur($annonce->getAnnonceur())
                ->setDateCreation(new DateTime())
            ;
        }

        return $this->render('demande_adoption/form_demande.twig', [
            'form' => $form->createView()
        ]);
    }
 
}
