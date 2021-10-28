<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\Annonceur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLast()
    {
        return $this->createQueryBuilder('a')
            ->distinct()
            ->innerJoin("a.chiens", "c")
            ->innerJoin("c.photos", "p")
            ->innerJoin("c.races", "r")
            ->innerJoin("a.annonceur", "an")
            ->andWhere("a.aPourvoir = :aPourvoir")
            ->setParameter('aPourvoir', true)
            ->orderBy("a.dateCreation","DESC")
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    public function findAnnoncesAPourvoir(?Annonceur $annonceur)
    {
       return $this->createQueryBuilder("a")
            ->distinct()
            ->addSelect(['an',
                'c',
                'r',
                'p'])
            ->innerJoin("a.annonceur",'an')
            ->innerJoin("a.chiens", "c")
            ->innerJoin("c.photos", "p")
            ->innerJoin("c.races", "r")
            ->andWhere('a.aPourvoir = :aPourvoir')
            ->setParameter('aPourvoir',true)
            ->andWhere('a.annonceur = :annonceur')
            ->setParameter('annonceur',$annonceur)
            ->getQuery()
            ->getResult();
    }


}
