<?php

namespace App\DataFixtures;

use App\Entity\Adoptant;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdoptantFixtures extends Fixture implements DependentFixtureInterface
{

    private UserPasswordHasherInterface $hasher;
    private VilleRepository $villeRepository;

    public function __construct(VilleRepository $villeRepository, UserPasswordHasherInterface $hasher)
    {
        $this->villeRepository = $villeRepository;
        $this->hasher = $hasher;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {

            $villes = $this->villeRepository->findAll();
            $rand = rand(0, count($villes) - 1);

            $adoptant = new Adoptant();
            $adoptant->setNom("Adoptant" . $i);
            $pwd = $this->hasher->hashPassword($adoptant, "pass" . $i);
            $adoptant->setPassword($pwd);
            $adoptant->setEmail("adoptant" . $i . "@mail.fr");
            $adoptant->setAdresse("Adresse" . $i);

            $adoptant->setVille($villes[$rand]);

            $adoptant->setTelephone("000000000" . $i);
            $roles = [];
            $roles[] = 'ROLE_USER';
            $roles[] = 'ROLE_ADOPTANT';
            $adoptant->setRoles($roles);
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