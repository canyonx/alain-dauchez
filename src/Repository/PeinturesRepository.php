<?php

namespace App\Repository;

use App\Entity\Peintures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Peintures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Peintures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Peintures[]    findAll()
 * @method Peintures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeinturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Peintures::class);
    }

    // /**
    //  * @return Peintures[] Returns an array of Peintures objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Peintures
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
