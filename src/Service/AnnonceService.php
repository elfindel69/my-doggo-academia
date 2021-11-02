<?php

namespace App\Service;

use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;

class AnnonceService
{
    private AnnonceRepository $annonceRepository;
    private EntityManagerInterface $em;

    /**
     * @param AnnonceRepository $annonceRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(AnnonceRepository $annonceRepository, EntityManagerInterface $em)
    {
        $this->annonceRepository = $annonceRepository;
        $this->em = $em;
    }

    public function checkAnnonceAPourvoir(int $id){
        $annonce = $this->annonceRepository->find($id);
        $nbAdopte = 0;
        foreach ($annonce->getChiens() as $chien_annonce){
            if ($chien_annonce->getAdopte()){
                $nbAdopte++;
            }
        }
        if ($nbAdopte === $annonce->getChiens()->count()){
            $annonce->setAPourvoir(false);
            $this->em->persist($annonce);
            $this->em->flush();
        }

    }

}