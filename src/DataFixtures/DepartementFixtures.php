<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use App\Repository\RegionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DepartementFixtures extends Fixture implements DependentFixtureInterface
{
    private RegionRepository $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $regions = $this->regionRepository->findAll();

        foreach ($regions as $region) {

            for($i = 0; $i < 10; $i++) {

                $departement = new Departement();
                $departement->setNom('Departement '.$i);
                $departement->setRegion($region);

                $manager->persist($departement);
            }

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RegionFixtures::class,
        ];
    }

}