<?php

namespace App\Repository;

use App\Entity\ExMnotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExMnotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExMnotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExMnotes[]    findAll()
 * @method ExMnotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExMnotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExMnotes::class);
        $this->em = $registry->getManager();
    }

    // /**
    //  * @return ExMnotes[] Returns an array of ExMnotes objects
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

    
    public function getStatutByColumn($inscription, $module, $statut)
    {
        // dd('e.'.$statut);
        if($statut == "statutDef") {
            $request = $this->createQueryBuilder('e')
                ->select("statut.abreviation")
                ->innerJoin("e.statutDef", "statut")
                ->where('e.module = :module')
                ->andWhere('e.inscription = :inscription')
                ->setParameter('module', $module)
                ->setParameter('inscription', $inscription)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        } else {
            $request = $this->createQueryBuilder('e')
                ->select("statut.abreviation")
                ->innerJoin("e.statutAff", "statut")
                ->where('e.module = :module')
                ->andWhere('e.inscription = :inscription')
                ->setParameter('module', $module)
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
    public function getStatutAffDef($inscription, $module)
    {
        $request = $this->createQueryBuilder('e')
            ->select("statutAff.abreviation as abreviationAff,statutDef.abreviation as abreviationDef ")
            ->innerJoin("e.statutAff", "statutAff")
            ->innerJoin("e.statutDef", "statutDef")
            ->where('e.module = :module')
            ->andWhere('e.inscription = :inscription')
            ->setParameter('module', $module)
            ->setParameter('inscription', $inscription)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        
        if(!$request) {
            return [
                'abreviationAff' => "",
                'abreviationDef' => ""
            ];
        } 

        return $request;
    }
    

    public function GetModuleByCodeAnneeCodeSemstre($annee, $semestre, $inscription, $minOrMax, $statut)
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
        return $this->createQueryBuilder('m')
            ->innerJoin("m.inscription", 'inscription')
            ->innerJoin("m.module", 'module')
            ->where("inscription = :inscription")
            ->andWhere('inscription.annee = :annee')
            ->andWhere('module.semestre = :semestre')
            ->andWhere('module.type <> :letter')
            ->setParameter('inscription', $inscription)
            ->setParameter('annee', $annee)
            ->setParameter('semestre', $semestre)
            ->setParameter('letter', 'A')
            ->groupBy("m.id")
            ->orderBy("m.".$statut, $minOrMax)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
    public function GetNbrModuleByInscription($annee, $inscription, $note) {
        return $this->createQueryBuilder('m')
            ->select("count(m) as nbr_modules")
            ->innerJoin("m.inscription", 'inscription')
            ->innerJoin("m.module", 'module')
            ->where("inscription = :inscription")
            ->andWhere('inscription.annee = :annee')
            ->andWhere('module.type != :A')
            ->andWhere('m.note < :note')
            ->setParameter('inscription', $inscription)
            ->setParameter('annee', $annee)
            ->setParameter('note', $note)
            ->setParameter('A', "A")
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getNotesModuleBySemestre($semestre, $inscription) {
        return $this->createQueryBuilder('m')
            ->innerJoin("m.inscription", 'inscription')
            ->innerJoin("m.module", 'module')
            ->where("inscription = :inscription")
            ->andWhere('module.semestre = :semestre')
            ->setParameter('inscription', $inscription)
            ->setParameter('semestre', $semestre)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getNotesModuleSansAssiduiteBySemestre($semestre, $inscription) {
        
        return $this->createQueryBuilder('m')
            ->innerJoin("m.inscription", 'inscription')
            ->innerJoin("m.module", 'module')
            ->where("inscription = :inscription")
            ->andWhere('module.semestre = :semestre')
            ->andWhere('module.type != :lettre')
            ->setParameter('inscription', $inscription)
            ->setParameter('semestre', $semestre)
            ->setParameter('lettre', "A")
            ->getQuery()
            ->getResult()
        ;
    }
    
    
    public function getModuleNonAquis($semestre,$inscription)
    {
        return $this->createQueryBuilder('m')
            ->innerJoin("m.module", 'module')
            ->innerJoin("module.semestre", 'semestre')
            ->innerJoin("m.statutDef", 'def')
            ->where("m.inscription = :inscription")
            ->andWhere('semestre = :semestre')
            ->andWhere('module.type != :type')
            ->andWhere('def.id in (31,30)')
            ->setParameter('inscription', $inscription)
            ->setParameter('semestre', $semestre)
            ->setParameter('type', 'A')
            ->getQuery()
            ->getResult()
        ;
    }
    public function getModuleNonAquisByYear($inscription)
    {
        return $this->createQueryBuilder('m')
            ->innerJoin("m.module", 'module')
            ->innerJoin("module.semestre", 'semestre')
            ->innerJoin("m.statutDef", 'def')
            ->where("m.inscription = :inscription")
            ->andWhere('module.type != :type')
            ->andWhere('def.id in (31,30)')
            ->setParameter('inscription', $inscription)
            ->setParameter('type', 'A')
            ->getQuery()
            ->getResult()
        ;
    }
    public function getNotesModuleAssiduiteBySemestre($semestre, $inscription) {
        
        return $this->createQueryBuilder('m')
            ->innerJoin("m.inscription", 'inscription')
            ->innerJoin("m.module", 'module')
            ->where("inscription = :inscription")
            ->andWhere('module.semestre = :semestre')
            ->andWhere('module.type = :lettre')
            ->setParameter('inscription', $inscription)
            ->setParameter('semestre', $semestre)
            ->setParameter('lettre', "A")
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function getModulesTheoriqueBySemestre($semestre, $inscription) {
        
        return $this->createQueryBuilder('m')
            ->innerJoin("m.inscription", 'inscription')
            ->innerJoin("m.statutDef", 'statdef')
            ->innerJoin("m.module", 'module')
            ->innerJoin("module.elements", 'element')
            ->innerJoin("element.nature", 'nature')
            ->where("inscription = :inscription")
            ->andWhere('statdef.id = 29')
            ->andWhere('module.semestre = :semestre')
            ->andWhere('nature in (1,2)')
            ->setParameter('inscription', $inscription)
            ->setParameter('semestre', $semestre)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getModulesPratiqueBySemestre($semestre, $inscription) {
        
        return $this->createQueryBuilder('m')
            ->innerJoin("m.inscription", 'inscription')
            ->innerJoin("m.statutDef", 'statdef')
            ->innerJoin("m.module", 'module')
            ->innerJoin("module.elements", 'element')
            ->innerJoin("element.nature", 'nature')
            ->where("inscription = :inscription")
            ->andWhere('statdef.id = 29')
            ->andWhere('module.semestre = :semestre')
            ->andWhere('nature in (3,4)')
            ->setParameter('inscription', $inscription)
            ->setParameter('semestre', $semestre)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getModuleByCurrentYear($currentyear)
    {
        $sqls="SELECT ex.id, etab.code as code, etab.designation as etablissement, frm.code, 
        frm.designation as formation, ann.code, ann.designation as annee, ins.code as code_ins, 
        adm.code as code_adm, pre.code as code_preins, ins.code_anonymat as anonymat, 
        st.code as statut, etu.nom, etu.prenom, prm.code, prm.designation as promotion, 
        sem.code 'code_semestre', sem.designation as semestre,
        
        mdl.code 'code_module', mdl.designation as module, 
        em.note 'mnote', em.note_ini 'mnote_ini',
        em.note_rat 'mnote_rat', em.note_rachat 'mnote_rachat', stm2.id 'mstatut_s2',stm2.designation 'ms2_designation',stmdef.id 'mstatut_s2',stmdef.designation 'mdef_designation',
        stmaff.id 'mstatut_aff',stmaff.designation 'maff_designation', em.observation 'module OBS',
        
        ele.code 'code_element', ele.designation as element, ele.coefficient, ele.coefficient_epreuve, 
        ex.mcc , ex.mtp, ex.mef, ex.ccr , ex.tpr , ex.efr, ex.note_ini, ex.note, ex.note_rat, 
        ex.note_rachat ,ex.cc_rachat, ex.tp_rachat, ex.ef_rachat,st1.id 'id_stat_s1',
        st1.designation 'statut S1',st2.id 'id_stat_s2',st2.designation 'statut S2',
        stdetf.id 'id_stat_def',stdetf.designation 'statut Def',staff.id 'id_stat_aff',
        staff.designation 'statut Aff'
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
        
        LEFT JOIN ex_mnotes em on em.module_id = mdl.id and em.inscription_id = ins.id 
        LEFT JOIN pe_statut stm2 on stm2.id = em.statut_s2_id 
        LEFT JOIN pe_statut stmdef on stmdef.id = em.statut_def_id 
        LEFT JOIN pe_statut stmaff on stmaff.id = em.statut_aff_id 
        
        LEFT JOIN ex_snotes es on es.semestre_id = sem.id and es.inscription_id = ins.id 
        LEFT JOIN pe_statut sts2 on sts2.id = es.statut_s2_id 
        LEFT JOIN pe_statut stsdef on stsdef.id = es.statut_def_id 
        LEFT JOIN pe_statut stsaff on stsaff.id = es.statut_aff_id
        
        where ann.designation = '$currentyear' and frm.designation not like '%Résidanat%'";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }
}
