<?php

namespace App\Repository;

use App\Entity\AcAnnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcAnnee|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcAnnee|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcAnnee[]    findAll()
 * @method AcAnnee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcAnneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcAnnee::class);
        $this->em = $registry->getManager();
    }

    // /**
    //  * @return AcAnnee[] Returns an array of AcAnnee objects
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
    
    public function getAnneeByFormation($formation)
    {
        //a.designation = '2021/2022' pour les derogation ca compte apartir de l'annee 2021/2022
        return $this->createQueryBuilder('a')
        ->innerJoin("a.formation", 'formation')
        ->where("formation = :formation")
        ->andWhere("a.designation = '2021/2022'")
        // ->andWhere('a.validation_academique = :non')
        // ->andWhere('a.cloture_academique = :non')
        ->setParameter('formation', $formation)
        // ->setParameter('non', "non")
        ->getQuery()
        ->getOneOrNullResult();
    }

    
    public function getActiveAnneeByFormation($formation): ?AcAnnee
    {
        return $this->createQueryBuilder('a')
            ->where('a.validation_academique = :non')
            ->andWhere('a.cloture_academique = :non')
            ->andWhere('a.formation = :formation')
            ->setParameter('formation', $formation)
            ->setParameter('non', "non")
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function getInfosGenerales($annee)
    {
        $id_annee = $annee->getId();
        $sqls="SELECT
            etab.designation AS designation_etablissement,
            etab.abreviation AS abreviation_etablissement,
            etab.doyen,
            etab.statut as doyen_or_directeur ,
            etab.nature as nature_etablissement,
            frm.designation AS designation_formation,
            frm.abreviation AS abreviation_formation,
            frm.nbr_annee,
            ann.designation AS designation_annee
        FROM
            ac_etablissement etab
        INNER JOIN ac_formation frm ON frm.etablissement_id = etab.id
        INNER JOIN ac_annee ann ON ann.formation_id = frm.id
        where ann.id=$id_annee limit 1";
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetch();
        return $result;
    }
    
    public function getAnnee($annee, $nbr_annee)
    {
        $id_annee = $annee->getId();
        $id_formation = $annee->getFormation()->getId();
        $sqls="SELECT ann.id, ann.code, ann.designation,ann.formation_id
        FROM `ac_annee` ann
        -- INNER JOIN ex_anotes ex ON ex.annee_id = ann.id
        WHERE ann.formation_id = $id_formation 
            AND RIGHT(ann.designation, 4) <= (SELECT RIGHT(designation, 4) AS des
                                                FROM ac_annee
                                                WHERE id = $id_annee)
        GROUP BY
            ann.code,
            ann.designation
        ORDER BY
            RIGHT(ann.designation, 4) DESC
            LIMIT $nbr_annee";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }

    

    
    
}
