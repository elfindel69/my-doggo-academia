<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{
    protected $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setEmail('admin@admin.fr');
        $pwd = $this->hasher->hashPassword($admin, 'admin');
        $admin->setPassword($pwd);

        $manager->persist($admin);
        $manager->flush();
    }
}