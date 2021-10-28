<?php

namespace App\Controller;

use App\Entity\Adoptant;
use App\Form\AdoptantCompleteFormType;
use App\Form\AdoptantFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdoptantController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/form-adoptant", name="formAdoptant")
     */
    public function formAdoptant(Request $request, EntityManagerInterface $em): Response
    {

        $adoptant = new Adoptant();

        $form = $this->createForm(AdoptantFormType::class, $adoptant, [
            'method' => 'post',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($adoptant);
            $em->flush();
            return $this->redirectToRoute('default_index');
        }

        return $this->render('adoptant/formAdoptant.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/form-adoptant-update", name="updateAdoptant")
     */
    public function completeFormAdoptant(Request $request, EntityManagerInterface $em): Response 
    {
        $adoptant = $this->security->getUser();

        $form = $this->createForm(AdoptantCompleteFormType::class, $adoptant, [
            'method' => 'post'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($adoptant);
            $em->flush();

            $this->addFlash('success', 'Compte mis à jour ! 👍');

            return $this->redirectToRoute('default_index');
        }

        return $this->render('adoptant/updateAdoptant.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
