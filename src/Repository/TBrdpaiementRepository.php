<?php

namespace App\Repository;

use App\Entity\TBrdpaiement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TBrdpaiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TBrdpaiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TBrdpaiement[]    findAll()
 * @method TBrdpaiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TBrdpaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TBrdpaiement::class);
    }
    

    // /**
    //  * @return TBrdpaiement[] Returns an array of TBrdpaiement objects
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
    public function findOneBySomeField($value): ?TBrdpaiement
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function getMontantReglementsParBrd($brd)
    {
        return $this->createQueryBuilder('brd')
            ->select("sum(reg.montant) as montant")
            ->innerJoin("brd.reglements","reg")
            ->Where("reg.annuler = 0")
            ->Where("brd.id = :id")
            ->setParameter('id', $brd)
            ->getQuery()
            ->getResult()
        ;
    }
}
