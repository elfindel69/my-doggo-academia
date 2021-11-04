<?php

namespace App\Controller;

use App\Entity\Adoptant;
use App\Form\AdoptantCompleteFormType;
use App\Form\AdoptantFormType;
use App\Repository\DemandeAdoptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdoptantController extends AbstractController
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @Route("/sign-in", name="adoptant_login")
     */
    public function formAdoptant(Request $request, EntityManagerInterface $em): Response
    {

        $adoptant = new Adoptant();

        $form = $this->createForm(AdoptantFormType::class, $adoptant, [
            'method' => 'post',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles = [];
            $roles[] = 'ROLE_USER';
            $roles[] = 'ROLE_ADOPTANT';
            $adoptant->setRoles($roles);
            $adoptant->setPassword($this->hasher->hashPassword($adoptant, $adoptant->getPlainPassword()));
            $em->persist($adoptant);
            $em->flush();
            return $this->redirectToRoute('default_index');
        }

        return $this->render('adoptant/formAdoptant.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit-account", name="adoptant_update")
     */
    public function completeFormAdoptant(Request $request, EntityManagerInterface $em): Response
    {
        $adoptant = $this->getUser();

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

    /**
     * @Route("/moncompte", name="adoptant_account")
     */
    public function adoptant_account(DemandeAdoptionRepository $demandeAdoptionRepository): Response
    {

        $demandesAdoption = $demandeAdoptionRepository->findBy([
            'adoptant' => $this->getUser(),
            'acceptee' => false]);

        $demandesAdoptionArchivees = $demandeAdoptionRepository->findBy([
            'adoptant' => $this->getUser(),
            'acceptee' => true]);
        return $this->render("adoptant/adoptant_account.html.twig", [
            'adoptant' => $this->getUser(),
            'demandesAdoption' => $demandesAdoption,
            'demandesAdoptionArchivees' => $demandesAdoptionArchivees,
        ]);
    }
}
