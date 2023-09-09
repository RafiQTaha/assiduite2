<?php

namespace App\Repository;

use App\Entity\ExAnotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExAnotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExAnotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExAnotes[]    findAll()
 * @method ExAnotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExAnotesRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExAnotes::class);
        $this->em = $registry->getManager();
    }

    // /**
    //  * @return ExAnotes[] Returns an array of ExAnotes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExAnotes
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getStatutByColumn($inscription, $statut)
    {
        // dd('e.'.$statut);
        if($statut == "statutDef") {
            $request = $this->createQueryBuilder('e')
                ->select("statut.abreviation")
                ->innerJoin("e.statutDef", "statut")
                ->where('e.inscription = :inscription')
                ->setParameter('inscription', $inscription)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        } else {
            $request = $this->createQueryBuilder('e')
                ->select("statut.abreviation")
                ->innerJoin("e.statutAff", "statut")
                ->where('e.inscription = :inscription')
                ->setParameter('inscription', $inscription)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
        if(!$request) {
            return "";
        } 

        return $request;
    }
    public function getNoteFromExAnotes($codeAdm, $annee)
    {
        $sqls="SELECT ex.*
        FROM `ex_anotes` ex 
        inner join tinscription ins on ins.id = ex.inscription_id
        inner join ac_annee ann on ann.id = ex.annee_id
        inner join tadmission adm on adm.id = ins.admission_id
        where adm.code = '$codeAdm' 
        and ann.code = '$annee'
         limit 1";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }


    public function getNoteFromExAnotesByStatut($admission)
    {
        $sqls="SELECT ex.*
        FROM `ex_anotes` ex 
        inner join tinscription ins on ins.id = ex.inscription_id
        inner join tadmission adm on adm.id = ins.admission_id
        where adm.id = $admission
        and ex.statut_aff_id != 44
        
        ORDER BY
            ins.id ASC";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }

    public function CalculeMoyenneNote($admission)
    {
        $sqls="SELECT ins.id as inscriptoion, adm.id as admission, sum(note) as moyenne, sum(note_sec) as moyenneSec
        FROM `ex_anotes` an
        inner join tinscription ins on ins.id = an.inscription_id
        inner join tadmission adm on adm.id = ins.admission_id
        where adm.id = $admission and statut_aff_id != 44 order by ins.code desc";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetch();
        return $result;
    }

    public function getAnneeByCurrentYear($currentyear, $etab)
    {
        $sqls="SELECT distinct  mn.id, etab.code 'code Etablissement', etab.designation 'Etablissement', frm.code 'code Formation', frm.designation 'Formation', an.code 'code annee', an.designation 'Annee',ins.id 'id_inscription', ins.code 'code Inscription', adm.id 'id_admission', adm.code 'code Admission', pre.id 'id_preinscription', pre.code 'code Preinscription', ins.code_anonymat, ins.code_anonymat_rat, ins.statut_id 'ID Statut', etu.nom, etu.prenom,prm.code 'code Promotion', prm.designation 'Promotion', a.note 'note Annee',a.note_sec 'note_sec Annee', a.statut_s2_id 'statut_s2_id annee', st10.designation 'statut_s2 annee', a.statut_def_id 'statut_def_id annee', st11.designation 'statut_def annee' , a.statut_aff_id 'statut_aff_id annee', st12.designation 'statut_aff annee', a.categorie 'categorie annee' ,sem.code 'code Semestre', sem.designation 'Semestre', s.note 'note semestre', s.note_sec 'note_sec semestre',s.note_rachat 'note_rachat semestre', s.statut_s2_id 'statut_s2_id semestre', st7.designation 'statut_s2semestre', s.statut_def_id 'statut_def_id semestre', st8.designation 'statut_def_ semestre', s.statut_aff_id 'statut_aff_id semestre', st9.designation 'statut_aff semestre', s.categorie 'semestre categorie', mdl.code 'note Module', mdl.designation 'Module', sn.note 'note Module', sn.note_ini 'note_ini Module', sn.note_rat 'note_rat Module', sn.note_rachat 'note_rachat Module',sn.statut_s2_id 'statut_s2_id module', st4.designation 'statut_s2 module', sn.statut_def_id 'statut_def_id module',st5.designation 'statut_def module',sn.statut_aff_id 'statut_aff_id module', st6.designation 'statut_aff module',
        ele.code 'code Element', ele.designation 'Element', ele.coefficient, ele.coefficient_epreuve,mn.mcc, mn.ccr, case when (mn.mcc is null and mn.ccr is null) then '' when (mn.mcc>mn.ccr or mn.ccr is null) then mn.mcc else mn.ccr end 'cc_max',
        
        mn.cc_rachat, mn.mtp, mn.tpr, case when (mn.mtp is null and mn.tpr is null) then '' when (mn.mtp>mn.tpr or mn.tpr is null) then mn.mtp else mn.tpr end 'tp_max', mn.tp_rachat,
        
        mn.pond_mef,mn.mef,mn.pond_efr,mn.efr,case when (mn.mef is null and mn.efr is null) then '' when (mn.mef>mn.efr or mn.efr is null) then mn.mef else mn.efr end 'ef_max',mn.ef_rachat,
        
        mn.note_ini 'note_ini Element', mn.note_rat 'note_rat Element',mn.note 'note Element', mn.note_rachat 'note_rachat Element', mn.statut_s1_id 'statut_s1_id element', st1.designation 'statut_s element',mn.statut_s2_id 'statut_s2_id element', st2.designation 'statut_s2 element',mn.statut_def_id 'statut_def_id element', st.designation 'statut_def element',mn.statut_aff_id 'statut_aff_id element',st3.designation 'statut_aff element', mn.observation 'element observation', s.categorie 'element categorie'
        
        FROM ex_enotes mn
        inner join tinscription ins on mn.inscription_id = ins.id
        inner join tadmission adm on adm.id = ins.admission_id
        inner join tpreinscription pre on pre.id = adm.preinscription_id
        inner join tetudiant etu on etu.id = pre.etudiant_id
        
        inner join ac_element ele on ele.id  = mn.element_id
        
        inner join ac_module mdl on mdl.id = ele.module_id
        
        inner join ac_annee an on an.id = ins.annee_id
        
        left join ac_semestre sem on sem.id = mdl.semestre_id
        
        left join ac_promotion prm on prm.id = sem.promotion_id
        
        left join ac_formation frm on frm.id =prm.formation_id
        
        left join ac_etablissement etab on frm.etablissement_id = etab.id
        
        left join pe_statut st on st.id = mn.statut_def_id
        
        left join pe_statut st1 on st1.id = mn.statut_s1_id
        
        left join pe_statut st2 on st2.id = mn.statut_s2_id
        
        left join pe_statut st3 on st3.id = mn.statut_aff_id
        
        left join  ex_mnotes sn on sn.inscription_id = mn.inscription_id and sn.module_id = mdl.id
        
        left join pe_statut st4 on st4.id = sn.statut_s2_id                                            
        
        left join pe_statut st5 on st5.id = sn.statut_def_id
        
        left join pe_statut st6 on st6.id = sn.statut_aff_id
        
        left join  ex_snotes s on s.inscription_id = mn.inscription_id and s.semestre_id = sem.id
        
        left join pe_statut st7 on st7.id = s.statut_s2_id
        
        left join pe_statut st8 on st8.id = s.statut_def_id
        
        left join pe_statut st9 on st9.id = s.statut_aff_id
        
        left join  ex_anotes a on a.inscription_id = mn.inscription_id and a.annee_id = an.id
        
        left join pe_statut st10 on st10.id = a.statut_s2_id
        
        left join pe_statut st11 on st11.id = a.statut_def_id
        
        left join pe_statut st12 on st12.id = a.statut_aff_id
        where an.designation = '$currentyear' and etab.id = $etab and frm.designation not like '%Résidanat%'";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }
}
