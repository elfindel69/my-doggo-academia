<?php

namespace App\DataFixtures;

use App\Entity\DemandeAdoption;
use App\Entity\Message;
use App\Repository\AdoptantRepository;
use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DemandeAdoptionFixtures extends Fixture implements DependentFixtureInterface
{

    private AdoptantRepository $adoptantRepository;
    private AnnonceRepository $annonceRepository;

    public function __construct(AdoptantRepository $adoptantRepository, AnnonceRepository $annonceRepository)
    {
        $this->adoptantRepository = $adoptantRepository;
        $this->annonceRepository = $annonceRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $annonces = $this->annonceRepository->findAll();
        $i = 0;
        foreach ($annonces as $annonce) {
            if ($annonce->getChiens()) {
                $demande1 = new DemandeAdoption();
                $demande1->setAnnonceur($annonce->getAnnonceur());
                $demande1->setAnnonce($annonce);

                foreach ($annonce->getChiens() as $chien) {
                    $demande1->addChien($chien);
                }

                $demande1->setAdoptant($this->adoptantRepository->findOneBy(['nom' => "Adoptant" . $i]));
                $message = new Message();
                $message->setDestinataire($annonce->getAnnonceur());
                $message->setExpediteur($this->adoptantRepository->findOneBy(['nom' => "Adoptant" . $i]));
                $message->setContenu('le corps du message');
                $message->setDateEnvoi(new DateTime());
                $message->setDemandeAdoption($demande1);
                $message->setEstLu(false);
                $demande1->addMessage($message);
                $i++;
            }
        }
    }

    public function getDependencies()
    {
        return [
            ChienFixtures::class,
            AnnonceurFixtures::class,
            AdoptantFixtures::class,
            AnnonceFixtures::class,
        ];
    }
}