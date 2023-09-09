<?php

namespace App\Repository;

use App\Entity\POrganisme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method POrganisme|null find($id, $lockMode = null, $lockVersion = null)
 * @method POrganisme|null findOneBy(array $criteria, array $orderBy = null)
 * @method POrganisme[]    findAll()
 * @method POrganisme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class POrganismeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, POrganisme::class);
    }

    // /**
    //  * @return POrganisme[] Returns an array of POrganisme objects
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
    public function findOneBySomeField($value): ?POrganisme
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getorganismepasPayant()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id != 7')
            ->andWhere('p.active = 1')
            ->getQuery()
            ->getResult()
        ;
    }

}
