<?php

namespace App\DataFixtures;

use App\Entity\Adoptant;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdoptantFixtures extends Fixture implements DependentFixtureInterface
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

            $adoptant = new Adoptant();
            $adoptant->setNom("Adoptant".$i);
            $adoptant->setPassword("pass".$i);
            $adoptant->setEmail("adoptant".$i."@mail.fr");
            $adoptant->setAdresse("Adresse".$i);

            $adoptant->setVille($villes[$rand]);

            $adoptant->setTelephone("000000000".$i);
            $manager->persist($adoptant);
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