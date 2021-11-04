<?php

namespace App\DataFixtures;

use App\Entity\Annonceur;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AnnonceurFixtures extends Fixture implements DependentFixtureInterface
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

        for ($i = 0; $i < 12; $i++) {

            $villes = $this->villeRepository->findAll();
            $rand = rand(0, count($villes) - 1);

            $annonceur = new Annonceur();
            $annonceur->setNom("Annonceur" . $i);
            $pwd = $this->hasher->hashPassword($annonceur, "pass" . $i);
            $annonceur->setPassword($pwd);
            $annonceur->setEmail("annonceur" . $i . "@mail.fr");
            $annonceur->setAdresse("Adresse" . $i);

            $annonceur->setVille($villes[$rand]);

            $annonceur->setTelephone("000000000" . $i);
            $roles = [];
            $roles[] = 'ROLE_USER';
            $roles[] = 'ROLE_ANNONCEUR';
            $annonceur->setRoles($roles);
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