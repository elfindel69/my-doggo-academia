<?php

namespace App\Controller;

use App\Entity\DemandeAdoption;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
