<?php

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {

        $regionNames = [
            "Auvergne-Rhône-Alpes",
            "Bourgogne-Franche-Comté",
            "Bretagne",
            "Centre-Val de Loire",
            "Corse",
            "Grand Est",
            "Hauts-de-France",
            "Île-de-France",
            "Normandie",
            "Nouvelle-Aquitaine",
            "Occitanie",
            "Pays de la Loire",
            "Provence-Alpes-Côte d'Azur",
            "Guadeloupe",
            "Martinique",
            "Guyane",
            "La Réunion",
            "Mayotte"
        ];

        foreach ($regionNames as $regionName) {
            $region = new Region();
            $region->setNom($regionName);
            $manager->persist($region);
        }

        $manager->flush();

    }
}