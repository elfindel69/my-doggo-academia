<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Entity\DemandeAdoption;
use App\Entity\Message;
use App\Form\DemandeAdoptionType;
use App\Repository\AnnonceRepository;
use App\Repository\DemandeAdoptionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAdoptionController extends AbstractController
{
    /**
     * @Route("/demandeAdoption/{id}/new", name="demande_adoption", requirements={"id"="\d+"})
     */
    public function adoption_request(Request $request, EntityManagerInterface $em, int $id, AnnonceRepository $annonceRepository,
                                     DemandeAdoptionRepository $demandeAdoptionRepository): Response
    {
        $annonce = $annonceRepository->find($id);
        $demandeAdoption = $demandeAdoptionRepository->checkDemandeAdoption($annonce,$this->getUser());

        if(empty($demandeAdoption)){
            $demandeAdoption = new DemandeAdoption();
            $message = new Message();
            $demandeAdoption->addMessage($message);

            $form = $this->createForm(DemandeAdoptionType::class, $demandeAdoption, [
                'method' => 'post',
                'id' => $id
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $demandeAdoption
                    ->setAcceptee(false)
                    ->setAdoptant($this->getUser())
                    ->setAnnonce($annonce)
                    ->setAnnonceur($annonce->getAnnonceur())
                    ->setDateCreation(new DateTime());


                $message
                    ->setDateEnvoi(new DateTime())
                    ->setEstLu(false)
                    ->setExpediteur($demandeAdoption->getAdoptant())
                    ->setDestinataire($demandeAdoption->getAnnonceur());

                $demandeAdoption->addMessage($message);

                $em->persist($demandeAdoption);
                $em->flush();

                return $this->redirectToRoute('single_demande_adoption', ['id' => $demandeAdoption->getId()]);
            }
            return $this->render('demande_adoption/form_demande.twig', [
                'form' => $form->createView()
            ]);
        }else{
            return $this->redirectToRoute('annonces_annonces');
        }
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

    /**
     * @Route("/delete_demande/{id}", name="delete_demande", requirements={"id"="\d+"})
     * @IsGranted("ROLE_ANNONCEUR")
     */
    public function delete_demande(EntityManagerInterface $em, DemandeAdoption $demandeAdoption): Response
    {
        $annonceur = $this->getUser();

        if ($demandeAdoption->getAnnonceur()->getId() == $annonceur->getId()) {
            $em->remove($demandeAdoption);
            $em->flush();
        }

        return $this->redirectToRoute('annonceur_account');
    }

    /**
     * @Route("/validation_demande/{id}", name="validation_demande", requirements={"id"="\d+"})
     * @IsGranted("ROLE_ANNONCEUR")
     */
    public function validation_demande(EntityManagerInterface $em, DemandeAdoption $demandeAdoption, DemandeAdoptionRepository $demandeAdoptionRepository): Response
    {

        if ($demandeAdoption->getAnnonceur()->getId() == $this->getUser()->getId()) {
            $demandeAdoption->setAcceptee(true);

            $chiens = $demandeAdoption->getChiens();
            $idChiens = $chiens->map(function (Chien $chien) {
                return $chien->getId();
            });
            $demandesAvecChiensCourant = $demandeAdoptionRepository->findDemandesAvecChiens($idChiens->toArray());

            foreach ($chiens as $chien) {
                $chien->setAdopte(true);
                foreach ($demandesAvecChiensCourant as $demande) {
                    if ($demande->getId() != $demandeAdoption->getId()) {
                        $demande->removeChien($chien);
                        if (count($demande->getChiens()) === 0) {
                            $em->remove($demande);
                        }
                    }
                }
            }

            $em->persist($demandeAdoption);
            $pourvue = true;

            foreach ($demandeAdoption->getAnnonce()->getChiens() as $chien) {
                if ($chien->getAdopte() == false) {
                    $pourvue = false;
                }
            }

            if ($pourvue) {
                $demandeAdoption->getAnnonce()->setAPourvoir(false);
                $em->persist($demandeAdoption->getAnnonce());
            }

            $em->flush();
        }

        return $this->redirectToRoute('annonceur_account');
    }

}
