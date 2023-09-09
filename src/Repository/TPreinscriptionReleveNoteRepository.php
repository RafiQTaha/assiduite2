<?php

namespace App\Repository;

use App\Entity\TPreinscriptionReleveNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TPreinscriptionReleveNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method TPreinscriptionReleveNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method TPreinscriptionReleveNote[]    findAll()
 * @method TPreinscriptionReleveNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TPreinscriptionReleveNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TPreinscriptionReleveNote::class);
    }

    // /**
    //  * @return TPreinscritionReleveNote[] Returns an array of TPreinscritionReleveNote objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TPreinscritionReleveNote
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
