<?php

namespace App\Repository;

use App\Entity\PMatiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PMatiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method PMatiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method PMatiere[]    findAll()
 * @method PMatiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PMatiereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PMatiere::class);
    }

    // /**
    //  * @return PMatiere[] Returns an array of PMatiere objects
    //  */
    
   
    

    /*
    public function findOneBySomeField($value): ?PMatiere
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
