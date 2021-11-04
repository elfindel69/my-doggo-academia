<?php

namespace App\DataFixtures;

use App\Entity\Chien;
use App\Repository\RaceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChienFixtures extends Fixture implements DependentFixtureInterface
{
    private RaceRepository $raceRepository;

    public function __construct(RaceRepository $raceRepository)
    {
        $this->raceRepository = $raceRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $races = $this->raceRepository->findAll();
        $cpt = 1;

        foreach ($races as $race) {
            $chien = new Chien();
            $chien->addRace($race);
            $chien->setNom("Chien" . $cpt);
            $chien->setAdopte(false);
            $chien->setAge($cpt);
            $chien->setAntecedents("All good");
            $chien->setDescription("A good doggie");
            $chien->setLof(true);
            $chien->setPoids($cpt);
            $chien->setSociable(true);
            $chien->setSociable(false);
            $chien->setTaille($cpt + 20);
            $chien->setSexe('male');
            $manager->persist($chien);
            $cpt++;

            $chien2 = new Chien();
            $chien2->addRace($race);
            $chien2->setNom("Chien" . $cpt);
            $chien2->setAdopte(true);
            $chien2->setAge($cpt);
            $chien2->setAntecedents("Had issues");
            $chien2->setDescription("A good doggie");
            $chien2->setLof(false);
            $chien2->setPoids($cpt);
            $chien2->setSociable(false);
            $chien2->setSociable(true);
            $chien2->setTaille($cpt + 10);
            $chien2->setSexe('femelle');
            $manager->persist($chien2);
            $cpt++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RaceFixtures::class,
        ];
    }
}