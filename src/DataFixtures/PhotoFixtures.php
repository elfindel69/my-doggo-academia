<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Repository\ChienRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    private ChienRepository $chienRepository;

    public function __construct(ChienRepository $chienRepository)
    {
        $this->chienRepository = $chienRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $chiens = $this->chienRepository->findAll();
        $cpt = 1;

        foreach ($chiens as $chien) {
            $photo = new Photo();
            $photo->setNom($cpt);
            $photo->setUrl('https://cdn.futura-sciences.com/buildsv6/images/largeoriginal/8/5/8/858743bb35_50169458_chien-min.jpg');
            $photo->setChien($chien);
            $cpt++;
            $manager->persist($photo);

            $photo2 = new Photo();
            $photo2->setNom($cpt);
            $photo2->setUrl('https://cdn.futura-sciences.com/buildsv6/images/largeoriginal/8/5/8/858743bb35_50169458_chien-min.jpg');
            $photo2->setChien($chien);
            $manager->persist($photo2);
            $cpt++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ChienFixtures::class,
        ];
    }
}