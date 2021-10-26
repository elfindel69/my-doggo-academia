<?php

namespace App\Controller;

use App\Entity\Adoptant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdoptantController extends AbstractController
{
    /**
     * @Route("/form-adoptant", name="formAdoptant")
     */
    public function formAdoptant(Request $request, EntityManagerInterface $em): Response
    {

        $adoptant = new Adoptant();

        $form = $this->createForm(Adoptant::class, $adoptant, [
            'method' => 'post',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($adoptant);
            $em->flush();
            return $this->redirectToRoute('/');
        }

        return $this->render('adoptant/formAdoptant.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
