<?php

namespace App\Repository;

use App\Entity\TOperationcab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TOperationcab|null find($id, $lockMode = null, $lockVersion = null)
 * @method TOperationcab|null findOneBy(array $criteria, array $orderBy = null)
 * @method TOperationcab[]    findAll()
 * @method TOperationcab[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TOperationcabRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TOperationcab::class);
    }

    // /**
    //  * @return TOperationcab[] Returns an array of TOperationcab objects
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
    
    public function findetatbyoperation($value)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin()
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
*/
public function getFacturesByCurrentYear($currentyear)
{
    return $this->createQueryBuilder('cab')
        ->select("DISTINCT cab.id as id,pre.code as code_preins, cab.code as code_facture, ann.designation as annee, etu.nom as nom, etu.prenom as prenom,etu.nationalite as nationalite, etab.designation as etablissement, frm.designation as formation, prm.designation as promotion, cab.categorie as categorie, stat.designation as statut,cab.created as created,adm.code as code_adm,ins.code as code_ins,etu.code as code_etu")
        ->innerJoin("cab.preinscription","pre")
        ->innerJoin("pre.etudiant","etu")
        ->leftJoin("pre.admissions","adm")
        ->leftJoin("adm.inscriptions","ins")
        ->leftJoin("ins.promotion","prm")
        ->leftJoin("ins.statut","stat")
        ->innerJoin("cab.annee","ann")
        ->leftJoin("ins.annee","anne")
        ->leftJoin("ann.formation","frm")
        ->leftJoin("frm.etablissement","etab")
        // ->Where("pre.inscriptionValide = 1")
        ->Where("ann.designation = :annee")
        // ->AndWhere("ins.annee = ann")
        ->AndWhere("anne.designation = ann.designation")
        // ->AndWhere("pre.active = 1")
        ->AndWhere("pre.inscriptionValide = 1")
        // ->AndWhere("stat.id = 13")
        // ->Where("ann.cloture_academique = 'non'")
        // ->Where("cab.active = 1")
        ->setParameter("annee", $currentyear)
        ->orderby('ins.id','DESC')
        // ->groupBy('cab.id')  
        ->getQuery()
        ->getResult()
    ;
}
public function getFacturesByCurrentYearNonInscrits($currentyear)
{
    return $this->createQueryBuilder('cab')
        ->select("DISTINCT cab.id as id,pre.code as code_preins, cab.code as code_facture, ann.designation as annee, etu.nom as nom, etu.prenom as prenom,etu.nationalite as nationalite, etab.designation as etablissement, frm.designation as formation, prm.designation as promotion, cab.categorie as categorie, stat.designation as statut,cab.created as created,adm.code as code_adm,ins.code as code_ins,etu.code as code_etu")
        ->innerJoin("cab.preinscription","pre")
        ->innerJoin("pre.etudiant","etu")
        ->leftJoin("pre.admissions","adm")
        ->leftJoin("adm.inscriptions","ins")
        ->leftJoin("ins.promotion","prm")
        ->leftJoin("ins.statut","stat")
        ->innerJoin("cab.annee","ann")
        ->leftJoin("ins.annee","anne")
        ->leftJoin("ann.formation","frm")
        ->leftJoin("frm.etablissement","etab")
        ->Where("ann.designation = :annee")
        ->AndWhere("pre.active = 1")
        ->AndWhere("pre.inscriptionValide = 1")
        ->AndWhere("ins.id is null")
        ->setParameter("annee", $currentyear)
        ->orderby('pre.id','DESC')
        ->getQuery()
        ->getResult()
    ;
}
public function getFacturesDetByPreinscription($preinscription)
{
    return $this->createQueryBuilder('cab')
        ->innerJoin("cab.preinscription","pre")
        ->innerJoin("pre.etudiant","etu")
        ->innerJoin("cab.annee","ann")
        ->innerJoin("ann.formation","frm")
        ->innerJoin("frm.etablissement","etab")
        ->innerJoin("cab.operationdets","det")
        ->Where("pre.inscriptionValide = 1")
        ->AndWhere("pre.active = 1")
        ->AndWhere("pre.id = :preinscription")
        ->AndWhere("det.active = 1")
        ->setParameter("preinscription", $preinscription)
        ->getQuery()
        ->getResult()
    ;
}


    
}
