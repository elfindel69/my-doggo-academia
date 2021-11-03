<?php

namespace App\Controller;

use App\Entity\DemandeAdoption;
use App\Entity\Message;
use App\Form\DemandeAdoptionType;
use App\Form\EnvoiMessageType;
use App\Repository\AnnonceRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{

    /**
     * @Route("/messages/{id}", name="messages_list")
     */
    public function listMessagesAction(DemandeAdoption $demandeAdoption,EntityManagerInterface $em): Response
    {
        $messages = $demandeAdoption->getMessages();
        foreach ($messages as $message){
            if (!$message->getEstLu()){
                $message->setEstLu(true);
                $em->persist($message);
                $em->flush();
            }
        }


        return $this->render('message/list_messages.html.twig',[
            "messages" => $messages,
            "id"=>$demandeAdoption->getId()
        ]);
    }

    /**
     * @Route("/envoiMessage/{id}", name="envoi_message", requirements={"id"="\d+"})
     */
    public function envoiMessageAction(Request $request, EntityManagerInterface $em,DemandeAdoption $demandeAdoption,
    UtilisateurRepository $utilisateurRepository): Response
    {
        $message = new Message();
        $form = $this->createForm(EnvoiMessageType::class, $message, [
            'method' => 'post'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $expediteur = $utilisateurRepository->find($this->getUser()->getId());
            $destinataire = null;
            if($this->isGranted("ROLE_ANNONCEUR")){
                $destinataire = $demandeAdoption->getAdoptant();
            }
            if($this->isGranted("ROLE_ADOPTANT")){
                $destinataire = $demandeAdoption->getAnnonceur();
            }
            $message
                ->setDateEnvoi(new \DateTime())
                ->setExpediteur( $expediteur)
                ->setDemandeAdoption($demandeAdoption)
                ->setDestinataire($destinataire)
            ;
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('messages_list',['id'=>$demandeAdoption->getId()]);
        }

        return $this->render('message/form_message.twig', [
            'form' => $form->createView()
        ]);
    }
}
