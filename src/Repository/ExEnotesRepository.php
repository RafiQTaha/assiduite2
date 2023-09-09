<?php

namespace App\Repository;

use App\Entity\ExEnotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExEnotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExEnotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExEnotes[]    findAll()
 * @method ExEnotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExEnotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExEnotes::class);
        $this->em = $registry->getManager();
    }

    // /**
    //  * @return ExEnotes[] Returns an array of ExEnotes objects
    //  */
    
    

    /*
    

    SELECT ex_e.*,ex_m.note as 'note_module' FROM  ex_mnotes ex_m 

inner join ac_element ele on ele.code_module= ex_m.code_module
inner join ex_enotes ex_e on ex_e.code_element = ele.code and ex_m.code_inscription = ex_e.code_inscription
where ex_m.code_module = '$code_module' 
and ex_m.code_annee = '$code_annee'
and ex_e.code_inscription = '$code_inscription' group by ex_e.id order by ex_e.$statut $minOrMax 
    */
    public function GetElementsByCodeAnneeCodeModule($annee, $module, $inscription, $minOrMax, $statut)
    {
        if ($minOrMax == 'min') {
            $minOrMax = 'asc';
            $limit = 1;
        } else if ($minOrMax == 'max') {
            $minOrMax = 'desc';
            $limit = 1;
        } elseif ($minOrMax == 'all') {
            $minOrMax = 'asc ';
            $limit = 100000000000;
        }
        return $this->createQueryBuilder('e')
            ->innerJoin("e.element", 'element')
            ->innerJoin("element.module", 'module')
            ->innerJoin("e.inscription", 'inscription')
            ->where("inscription = :inscription")
            ->andWhere('inscription.annee = :annee')
            ->andWhere('module = :module')
            ->setParameter('inscription', $inscription)
            ->setParameter('annee', $annee)
            ->setParameter('module', $module)
            ->groupBy("e.id")
            ->orderBy("e.".$statut, $minOrMax)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByModule($module, $inscription)
    {
        
        return $this->createQueryBuilder('e')
            ->innerJoin("e.element", 'element')
            ->innerJoin("element.module", 'module')
            ->innerJoin("e.inscription", 'inscription')
            ->where("inscription = :inscription")
            ->andWhere('module = :module')
            ->setParameter('inscription', $inscription)
            ->setParameter('module', $module)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getElementByCurrentYear($currentyear)
    {
        $sqls="SELECT ex.id, etab.code as code, etab.designation as etablissement, frm.code, frm.designation as formation, ann.code, ann.designation as annee, ins.code as code_ins, adm.code as code_adm, pre.code as code_preins, ins.code_anonymat as anonymat, st.code as statut, etu.nom, etu.prenom, prm.code, prm.designation as promotion, sem.code, sem.designation as semestre,mdl.code, mdl.designation as mosule, ele.code, ele.designation as element, ele.coefficient, ele.coefficient_epreuve, ex.mcc , ex.mtp, ex.mef, ex.ccr , ex.tpr , ex.efr, ex.note_ini, ex.note, ex.note_rat, ex.note_rachat ,ex.cc_rachat, ex.tp_rachat, ex.ef_rachat,st1.id 'id_stat_s1',st1.designation 'statut S1',st2.id 'id_stat_s2',st2.designation 'statut S2',stdetf.id 'id_stat_def',stdetf.designation 'statut Def',staff.id 'id_stat_aff',staff.designation 'statut Aff'
        from ex_enotes ex
        inner join ac_element ele on ele.id = ex.element_id
        INNER JOIN ac_module mdl on mdl.id = ele.module_id
        INNER JOIN ac_semestre sem on sem.id = mdl.semestre_id
        INNER JOIN ac_promotion prm on sem.promotion_id = prm.id
        inner join ac_formation frm on frm.id = prm.formation_id
        INNER join ac_etablissement etab on etab.id = frm.etablissement_id
        
        inner join tinscription ins on ins.id = ex.inscription_id
        inner join ac_annee ann on ann.id = ins.annee_id
        INNER JOIN tadmission adm on ins.admission_id = adm.id
        INNER JOIN tpreinscription pre on adm.preinscription_id = pre.id
        INNER JOIN pstatut st on st.id = ins.statut_id
        INNER JOIN tetudiant etu on pre.etudiant_id = etu.id
        LEFT JOIN pe_statut st1 on st1.id = ex.statut_s1_id 
        LEFT JOIN pe_statut st2 on st2.id = ex.statut_s2_id 
        LEFT JOIN pe_statut stdetf on stdetf.id = ex.statut_def_id 
        LEFT JOIN pe_statut staff on staff.id = ex.statut_aff_id 
        where ann.designation = '$currentyear' and frm.designation not like '%Résidanat%'";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }
 
}
