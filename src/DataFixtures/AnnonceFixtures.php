<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Repository\AnnonceurRepository;
use App\Repository\ChienRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    private ChienRepository $chienRepository;
    private AnnonceurRepository $annonceurRepository;

    public function __construct(ChienRepository $chienRepository, AnnonceurRepository $annonceurRepository)
    {
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
        $cpt = 0;
        $cpt2 = 19;

        foreach ($annonceurs as $annonceur) {
            for ($i = 0; $i < 2; $i++) {
                $annonce = new Annonce();
                $annonce->setAnnonceur($annonceur);
                $annonce->setDescription("Doggo ipsum ruff corgo boofers wrinkler blep borkdrive, he made many woofs fat boi maximum borkdrive shoob. Yapper aqua doggo vvv blop length boy you are doing me a frighten, vvv long water shoob tungg woofer borkdrive, pupperino fluffer pupperino blop. ");
                $chien1 = $chiens[$cpt];
                $annonce->addChien($chien1);
                $cpt++;
                $chien2 = $chiens[$cpt2];
                $annonce->addChien($chien2);
                $annonce->setTitre('Titre de l\'annonce');
                $annonce->setAPourvoir(true);
                $annonce->setDateCreation(new DateTime());
                $annonce->setDateMaJ(new DateTime());
                $cpt2--;
                $manager->persist($annonce);
            }

            $cpt--;
            $cpt2++;

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