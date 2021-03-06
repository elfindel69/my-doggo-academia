<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\DemandeAdoption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

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


    /**
     * @param array $idChiens
     * @return array
     */
    public function findDemandesAvecChiens(array $idChiens): array
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.chiens', 'c')
            ->andWhere('c.id IN (:chiens)')
            ->setParameter('chiens', $idChiens)
            ->getQuery()
            ->getResult();
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
    public function checkDemandeAdoption(?Annonce $annonce, ?UserInterface $user)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.annonce','an')
            ->innerJoin('d.adoptant','ad')
            ->andWhere('an.id = :annonce_id')
            ->setParameter('annonce_id', $annonce->getId())
            ->andWhere('ad.id = :adoptant_id')
            ->setParameter('adoptant_id', $user->getId())
            ->getQuery()
            ->getResult();
    }
}
