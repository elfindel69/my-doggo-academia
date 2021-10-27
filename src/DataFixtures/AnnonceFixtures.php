<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Repository\AnnonceurRepository;
use App\Repository\ChienRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    private ChienRepository $chienRepository;
    private AnnonceurRepository $annonceurRepository;

    public function __construct(ChienRepository $chienRepository, AnnonceurRepository $annonceurRepository) {
        $this->chienRepository = $chienRepository;
        $this->annonceurRepository = $annonceurRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {

        $annonceurs = $this->annonceurRepository->findAll();
        $chiens = $this->chienRepository->findAll();

        foreach ($annonceurs as $annonceur) {
            $rand = rand(0, count($chiens)-1);
            $annonce = new Annonce();
            $annonce->setAnnonceur($annonceur);
            $annonce->setDescription("Doggo ipsum ruff corgo boofers wrinkler blep borkdrive, he made many woofs fat boi maximum borkdrive shoob. Yapper aqua doggo vvv blop length boy you are doing me a frighten, vvv long water shoob tungg woofer borkdrive, pupperino fluffer pupperino blop. ");
            $chien1 = $chiens[$rand];
            $annonce->addChien($chien1);
            $rand2 = rand(0, count($chiens)-1);
            $chien2 = $chiens[$rand2];
            $annonce->addChien($chien2);
            $annonce->setTitre('Titre de l\'annonce');
            $annonce->setAPourvoir(true);
            $annonce->setDateCreation(new \DateTime());
            $annonce->setDateMaJ(new \DateTime());
            $manager->persist($annonce);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            ChienFixtures::class,
            AnnonceurFixtures::class
        ];
    }
}