<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setEmail('admin@admin.fr');
        $admin->setPassword('admin');

        $manager->persist($admin);
        $manager->flush();
    }
}