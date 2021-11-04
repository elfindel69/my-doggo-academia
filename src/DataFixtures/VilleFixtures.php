<?php

namespace App\DataFixtures;


use App\Entity\Ville;
use App\Repository\DepartementRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture implements DependentFixtureInterface
{

    private DepartementRepository $departementRepository;

    public function __construct(DepartementRepository $departementRepository)
    {
        $this->departementRepository = $departementRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $departements = $this->departementRepository->findAll();

        foreach ($departements as $departement) {
            for ($i = 0; $i < 10; $i++) {
                $ville = new Ville();
                $ville->setNom("Ville" . $i);
                $ville->setCodePostal($i + 1000);
                $ville->setDepartement($departement);
                $manager->persist($ville);
            }
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            DepartementFixtures::class,
        ];
    }
}