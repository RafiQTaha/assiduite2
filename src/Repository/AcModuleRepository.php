<?php

namespace App\Repository;

use App\Entity\AcModule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcModule|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcModule|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcModule[]    findAll()
 * @method AcModule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcModule::class);
    }

    // /**
    //  * @return AcModule[] Returns an array of AcModule objects
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

    
    public function findByPromotion($promotion, $annee)
    {
        return $this->createQueryBuilder('a')
            ->innerJoin("a.semestre", "semestre")
            ->innerJoin("a.elements", "elements")
            ->innerJoin("elements.controles", "controles")
            ->where("semestre.promotion = :promotion")
            ->andWhere('a.active = 1')
            ->andWhere('semestre.active = 1')
            ->andWhere("controles.annee = :annee")
            ->setParameter('promotion', $promotion)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getMdouleBySemestreAndExControle($semestre, $annee)
    {
        return $this->createQueryBuilder('a')
            ->innerJoin("a.semestre", "semestre")
            ->innerJoin("a.elements", "elements")
            ->innerJoin("elements.controles", "controles")
            ->where('a.active = 1')
            ->andWhere("semestre = :semestre")
            ->andWhere("controles.annee = :annee")
            ->setParameter('semestre', $semestre)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
