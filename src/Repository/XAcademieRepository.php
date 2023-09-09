<?php

namespace App\Repository;

use App\Entity\XAcademie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method XAcademie|null find($id, $lockMode = null, $lockVersion = null)
 * @method XAcademie|null findOneBy(array $criteria, array $orderBy = null)
 * @method XAcademie[]    findAll()
 * @method XAcademie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XAcademieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XAcademie::class);
    }

    // /**
    //  * @return XAcademie[] Returns an array of XAcademie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('x.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?XAcademie
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
