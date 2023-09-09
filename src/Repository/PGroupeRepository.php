<?php

namespace App\Repository;

use App\Entity\PGroupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PGroupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method PGroupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method PGroupe[]    findAll()
 * @method PGroupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PGroupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PGroupe::class);
    }

    // /**
    //  * @return PGroupe[] Returns an array of PGroupe objects
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
    public function findOneBySomeField($value): ?PGroupe
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findGroupesByGroupes($groupes)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.groupe in (:groupes)')
            ->setParameter('groupes', $groupes)
            ->getQuery()
            ->getResult()
        ;
    }

    
    

    public function getInscriptionsByNiveaux3($niv2)
    {
        return $this->createQueryBuilder('groupe')
            ->innerJoin("groupe.inscriptions", "inscription")
            ->innerJoin("inscription.annee", "annee")
            ->AndWhere("annee.validation_academique = 'non'")
            ->AndWhere("annee.cloture_academique = 'non'")
            ->AndWhere("groupe.groupe = :niv2")
            ->setParameter('niv2', $niv2)
            ->orderBy('groupe.niveau', 'ASC')
            ->getQuery()
            ->getResult()
        ;

    }
}
