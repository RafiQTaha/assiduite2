<?php

namespace App\Repository;

use App\Entity\HHonens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HHonens|null find($id, $lockMode = null, $lockVersion = null)
 * @method HHonens|null findOneBy(array $criteria, array $orderBy = null)
 * @method HHonens[]    findAll()
 * @method HHonens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HHonensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HHonens::class);
        $this->em = $registry->getManager();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(HHonens $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(HHonens $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findHonoraireByCurrentYears($currentyear)
    {
        $sqls="SELECT alb.id 'Id Borderau',alb.code 'Code Bordereau',hon.date_reglement ,ep.id 'seance_id',ep.code,sm.id 'semaine_id',sm.nsemaine,ann.id 'annee_id',ann.designation 'Année',etab.id 'etablissement_id',etab.designation 'Etablissement',
        frm.id 'formation_id',frm.designation 'Formation',prm.id 'promotion_id',prm.designation 'Promotion',sem.id 'semesre_id',sem.designation 'Semestre',mdl.id 'module_id',mdl.designation 'Module',ele.id 'element_id',ele.code 'Code_element',ele.designation 'Element',ne.id 'nat_epreuve_id',ne.designation 'Nature_epreuve',te.id 'Id_Type',te.designation 'Type',date(start) 'DateSeance',ep.start 'Date_début',ep.end 'Date_fin',ep.valider,ep.generer,ep.annuler,ens.id 'Id Enseignant',
        ens.code 'Code Enseignant',ens.nom 'Nom',ens.prenom 'Prenom',gr.id 'Id Grade',gr.designation 'Grade' ,hon.id 'Id Honoraire' , hon.nbr_heur 'Duree',IFNULL(hon.montant, 0)  'Montant', IFNULL(hon.brut, 0) 'Brut',IFNULL(hon.ir, 0) 'IR',ens.cin 'CIN', ens.rib 'RIB'
        FROM hhonens hon
        INNER JOIN penseignant ens ON ens.id = hon.enseignant_id
        INNER JOIN pgrade gr ON gr.id = ens.grade_id
        INNER JOIN pl_emptime ep  ON hon.seance_id = ep.id
        INNER JOIN semaine sm  ON sm.id = ep.semaine_id
        INNER JOIN pr_programmation prog ON prog.id = ep.programmation_id
        INNER join pnature_epreuve ne on ne.id = prog.nature_epreuve_id
        INNER JOIN ac_element ele ON ele.id = prog.element_id
        INNER JOIN type_element te on te.id = ele.nature_id
        INNER JOIN ac_module mdl ON mdl.id =  ele.module_id
        INNER JOIN ac_semestre sem ON sem.id =  mdl.semestre_id
        INNER JOIN ac_promotion prm ON prm.id = sem.promotion_id
        INNER JOIN ac_formation frm ON frm.id = prm.formation_id
        INNER JOIN ac_annee ann ON ann.id = prog.annee_id
        INNER JOIN ac_etablissement etab ON etab.id = frm.etablissement_id
        INNER JOIN halbhon alb on alb.id = hon.bordereau_id
        where ann.designation= '$currentyear' and ep.active = 1";
        // -- where frm.designation not like '%Residanat%' and etab.abreviation != 'CFC'  ";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }
    //  INNER JOIN ac_element ele ON ele.id = prog.element_id
    //    INNER JOIN type_element te on te.id = ele.nature_id
    //   INNER JOIN ac_module mdl ON mdl.id =  ele.module_id
    //   INNER JOIN ac_semestre sem ON sem.id =  mdl.semestre_id
    //  INNER JOIN ac_promotion prm ON prm.id = sem.promotion_id
    //  INNER JOIN ac_formation frm ON frm.id = prm.formation_id
    //  INNER JOIN ac_annee ann ON ann.id = prog.annee_id
    //  INNER JOIN ac_etablissement etab ON etab.id = frm.etablissement_id
    // INNER JOIN halbhon alb on alb.id = hon.bordereau_id
    // where alb.id = 12616
    // GROUP by alb.code ,ens.code  ,  ens.nom , ens.prenom 
    // ORDER by  ens.nom asc;
public function getEnsByBordereau($bordereau)
{
    return $this->createQueryBuilder('hon')
        ->select("bordereau.code , hon.exept , ens.code as code_enseignant ,  ens.nom , ens.prenom , gr.designation as grade,SUM(hon.montant) as montant ,  hon.nbrScRegroupe ")
        ->innerJoin("hon.bordereau","bordereau")
        ->innerJoin("hon.enseignant","ens")
        ->innerJoin("ens.grade","gr")
        ->innerJoin("hon.seance","ep")
        ->innerJoin("ep.semaine","sm")
        ->innerJoin("ep.programmation","prog")
        ->innerJoin("prog.nature_epreuve","ne")
        ->innerJoin("prog.element", "element")
        ->innerJoin("element.module", "module")
        ->innerJoin("module.semestre", "semestre")
        ->innerJoin("semestre.promotion", "promotion")
        ->innerJoin("promotion.formation","formation")
        ->innerJoin("formation.etablissement","etablissement")
        ->Where("bordereau = :bordereau")
        ->andWhere("ep.active = 1")
        ->setParameter("bordereau", $bordereau)
        ->groupBy('bordereau.id,ens.code  ,  ens.nom , ens.prenom')  
        ->orderby('ens.nom','ASC')
        ->getQuery()
        ->getResult()
    ;
}


public function getHonoraireByActiveSeanceAndBordereau($bordereau)
{
    return $this->createQueryBuilder('hon')
        ->innerJoin("hon.bordereau","bordereau")
        ->innerJoin("hon.seance","ep")
        ->Where("bordereau = :bordereau")
        ->andWhere("ep.active = 1")
        ->setParameter("bordereau", $bordereau)
        ->getQuery()
        ->getResult()
    ;
}

    // /**
    //  * @return HHonens[] Returns an array of HHonens objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HHonens
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
