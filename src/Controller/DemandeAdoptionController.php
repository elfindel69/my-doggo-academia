<?php

namespace App\Controller;

use App\Entity\DemandeAdoption;
use App\Entity\Message;
use App\Form\DemandeAdoptionType;
use App\Repository\AnnonceRepository;
use App\Repository\DemandeAdoptionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAdoptionController extends AbstractController
{
    /**
     * @Route("/demandeAdoption/{id}/new", name="demande_adoption", requirements={"id"="\d+"})
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

            $message = new Message();
            $message
                ->setDateEnvoi(new DateTime())
                ->setEstLu(false)
                ->setExpediteur($demandeAdoption->getAdoptant())
                ->setDestinataire($demandeAdoption->getAnnonceur())
                ->setDemandeAdoption($demandeAdoption)
                ->setContenu('Bonjour, je souhaite des informations')
            ;

            $demandeAdoption->addMessage($message);

            $em->persist($demandeAdoption);
            $em->flush();

            return $this->redirectToRoute('default_index');
        }

        return $this->render('demande_adoption/form_demande.twig', [
            'form' => $form->createView()
        ]);
    }
 
    /**
     * @Route("/demandeAdoption/{id}", name="single_demande_adoption", requirements={"id"="\d+"})
     */
    public function single_adoption(DemandeAdoption $demandeAdoption)
    {      
        return $this->render('demande_adoption/single_demande.twig', [
            'demande' => $demandeAdoption
        ]);
    }
}