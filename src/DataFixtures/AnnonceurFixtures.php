<?php

namespace App\DataFixtures;

use App\Entity\Annonceur;
use App\Repository\VilleRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnonceurFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements DependentFixtureInterface
{

    private VilleRepository $villeRepository;

    public function __construct(VilleRepository $villeRepository) {
        $this->villeRepository = $villeRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {

            $villes = $this->villeRepository->findAll();
            $rand = rand(0, count($villes)-1);

            $annonceur = new Annonceur();
            $annonceur ->setNom("Annonceur".$i);
            $annonceur->setPassword("pass".$i);
            $annonceur->setEmail("annonceur".$i."@mail.fr");
            $annonceur->setAdresse("Adresse".$i);

            $annonceur->setVille($villes[$rand]);

            $annonceur->setTelephone("000000000".$i);
            $manager->persist($annonceur);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            VilleFixtures::class,
        ];
    }

}