<?php

namespace App\Repository;

use App\Entity\UsOperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UsOperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsOperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsOperation[]    findAll()
 * @method UsOperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsOperation::class);
    }

    // /**
    //  * @return UsOperation[] Returns an array of UsOperation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsOperation
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getOperationByLinkSousModule($user, $link) {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.sousModule', "sousModule")
            ->innerJoin('u.users', "user")
            ->where('user = :user')
            ->andWhere('sousModule.link = :link')
            ->setParameter('user', $user)
            ->setParameter('link', $link)
            ->orderBy("u.ordre", 'ASC')
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
    }
    public function findAllBySousModule($link) {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.sousModule', "sousModule")
            ->where('sousModule.link = :link')
            ->setParameter('link', $link)
            ->orderBy("u.ordre", 'ASC')
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
    }
    public function findByUser($user) {
        return $this->createQueryBuilder('u')
            ->select("u.id")
            ->innerJoin("u.users", "user")
            ->where('user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
    }
}
