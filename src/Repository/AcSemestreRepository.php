<?php

namespace App\Repository;

use App\Entity\AcSemestre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcSemestre|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcSemestre|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcSemestre[]    findAll()
 * @method AcSemestre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcSemestreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcSemestre::class);
    }

    // /**
    //  * @return AcSemestre[] Returns an array of AcSemestre objects
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
    public function findOneBySomeField($value): ?AcSemestre
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
