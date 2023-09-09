<?php

namespace App\Repository;

use App\Entity\TEtudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method TEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method TEtudiant[]    findAll()
 * @method TEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TEtudiant::class);
    }

    // /**
    //  * @return TEtudiant[] Returns an array of TEtudiant objects
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
    public function findOneBySomeField($value): ?TEtudiant
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function getEtudiantByCurrentYear($annee)
    {
        return $this->createQueryBuilder('etu')
            ->where('etu.created LIKE :date')
            ->setParameter('date', $annee.'%')
            ->orderBy('etu.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
