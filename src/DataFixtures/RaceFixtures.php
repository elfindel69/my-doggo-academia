<?php

namespace App\DataFixtures;

use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {

        $racesNames = [
            'Epagneul',
            'Berger Allemand',
            'Caniche',
            'Labrador',
            'Husky',
            'Carlin',
            'Border Collie',
            'Sarabi Dog',
            'Boxer',
            'Bull Terrier'
        ];

        foreach ($racesNames as $racesName) {
            $race = new Race();
            $race->setNom($racesName);
            $manager->persist($race);
        }

        $manager->flush();

    }

}