<?php

namespace App\Repository;

use App\Entity\PEnseignant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PEnseignant|null find($id, $lockMode = null, $lockVersion = null)
 * @method PEnseignant|null findOneBy(array $criteria, array $orderBy = null)
 * @method PEnseignant[]    findAll()
 * @method PEnseignant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PEnseignantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PEnseignant::class);
    }

    // /**
    //  * @return PEnseignant[] Returns an array of PEnseignant objects
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
    public function findOneBySomeField($value): ?PEnseignant
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
