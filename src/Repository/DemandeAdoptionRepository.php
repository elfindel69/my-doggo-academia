<?php

namespace App\Repository;

use App\Entity\DemandeAdoption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeAdoption|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeAdoption|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeAdoption[]    findAll()
 * @method DemandeAdoption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeAdoptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeAdoption::class);
    }

    // /**
    //  * @return DemandeAdoption[] Returns an array of DemandeAdoption objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemandeAdoption
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
