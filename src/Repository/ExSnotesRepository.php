<?php

namespace App\Repository;

use App\Entity\ExSnotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\TInscription;
use App\Entity\AcAnnee;

/**
 * @method ExSnotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExSnotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExSnotes[]    findAll()
 * @method ExSnotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExSnotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExSnotes::class);
        $this->em = $registry->getManager();
    }

    // /**
    //  * @return ExSnotes[] Returns an array of ExSnotes objects
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
    public function findOneBySomeField($value): ?ExSnotes
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findByAdmission($admission)
    {
        $inscriptions = $this->em->getRepository(TInscription::class)->findby(['admission'=>$admission]);
        $inscription = end($inscriptions);
        $formation = $inscription->getPromotion()->getFormation();
        $annee = $this->em->getRepository(AcAnnee::class)->getAnneeByFormation($formation);
        

        return  $this->createQueryBuilder('e')
            ->innerJoin("e.inscription", 'inscription')
            ->innerJoin("inscription.admission", 'admission')
            ->innerJoin("e.statutDef", 'statutDef')
            ->innerJoin("inscription.annee", 'annee')
            ->where("admission = :admission")
            ->andWhere("statutDef = 72")
            ->andWhere("annee.id >= :annee_id")
            ->setParameter('admission', $admission)
            ->setParameter('annee_id', $annee->getId())
            ->getQuery()
            ->getResult()
        ;

        // dd($return);
    }

    public function getStatutByColumn($inscription, $semestre, $statut)
    {
        // dd('e.'.$statut);
        if($statut == "statutDef") {
            $request = $this->createQueryBuilder('e')
                ->select("statut.abreviation")
                ->innerJoin("e.statutDef", "statut")
                ->where('e.semestre = :semestre')
                ->andWhere('e.inscription = :inscription')
                ->setParameter('semestre', $semestre)
                ->setParameter('inscription', $inscription)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        } else {
            $request = $this->createQueryBuilder('e')
                ->select("statut.abreviation")
                ->innerJoin("e.statutAff", "statut")
                ->where('e.semestre = :semestre')
                ->andWhere('e.inscription = :inscription')
                ->setParameter('semestre', $semestre)
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
    public function getStatutAffDef($inscription, $semestre, $statut)
    {
        $request = $this->createQueryBuilder('e')
            ->select("e.note, statut.abreviation")
            ->leftJoin("e.".$statut, "statut")
            ->where('e.semestre = :semestre')
            ->andWhere('e.inscription = :inscription')
            ->setParameter('semestre', $semestre)
            ->setParameter('inscription', $inscription)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        // dd($request);
        return $request['note'] . "/" . $request['abreviation'];
        // return $request;
    }
    public function GetSemestreByCodeAnneeCodePromotion($annee, $promotion, $inscription, $minOrMax, $statut)
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
        return $this->createQueryBuilder('s')
            ->innerJoin("s.inscription", 'inscription')
            ->innerJoin("s.semestre", 'semestre')
            ->innerJoin("semestre.modules", 'modules')
            ->where("inscription = :inscription")
            ->andWhere('inscription.annee = :annee')
            ->andWhere('semestre.promotion = :promotion')
            ->andWhere('modules.type != :A')
            ->setParameter('inscription', $inscription)
            ->setParameter('annee', $annee)
            ->setParameter('promotion', $promotion)
            ->setParameter('A', "A")
            ->groupBy("s.id")
            ->orderBy("s.".$statut, $minOrMax)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
    public function GetCategorieSemestreByCodeAnnee($annee, $inscription)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin("s.inscription", 'inscription')
            ->innerJoin("s.semestre", 'semestre')
            ->where("inscription = :inscription")
            ->andWhere('inscription.annee = :annee')            
            ->setParameter('inscription', $inscription)
            ->setParameter('annee', $annee)
            ->orderBy("s.semestre", "asc")
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getSemestreByCurrentYear($currentyear, $etab)
    {
        $sqls="SELECT ex.id, etab.code as code, etab.designation as etablissement, frm.code,
        frm.designation as formation, ann.code, ann.designation as annee, ins.code as code_ins,
        adm.code as code_adm, pre.code as code_preins, ins.code_anonymat as anonymat,
        st.code as statut, etu.nom, etu.prenom, prm.code, prm.designation as promotion,
        sem.code 'code_semestre', sem.designation as semestre,
        es.note 'snote',es.note_sec 'snote_sec',es.note_rachat 'snote_rachat',stm2.id 'sstatut_s2',
        stm2.designation 'ss2_designation',stmdef.id 'sstatut_def',stsdef.designation 'sdef_designation',
        stsaff.id 'sstatut_aff',stsaff.designation 'saff_designation', es.categorie,
        mdl.code 'code_module', mdl.designation as module,
        em.note 'mnote', em.note_ini 'mnote_ini',
        em.note_rat 'mnote_rat', em.note_rachat 'mnote_rachat', stm2.id 'mstatut_s2',stm2.designation 'ms2_designation',stmdef.id 'mstatut_s2',stmdef.designation 'mdef_designation',
        stmaff.id 'mstatut_aff',stmaff.designation 'maff_designation',
        
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
        
        where ann.designation = '$currentyear' and etab.id = $etab and frm.designation not like '%Résidanat%'";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }

    //GETING INSCRIPTIONS SNOTES BY ANNEE AND SEMESTRE
    public function GetSnotesByAnneeAndSemestre($annee, $semestre)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin("s.inscription", 'inscription')
            ->innerJoin("s.semestre", 'semestre')
            ->where("semestre = :semestre")
            ->andWhere('inscription.annee = :annee')            
            ->setParameter('semestre', $semestre)
            ->setParameter('annee', $annee)
            // ->groupBy('s.statutDef')
            ->orderBy("s.semestre", "asc")
            ->getQuery()
            ->getResult()
        ;
    }

    //GETING INSCRIPTIONS SNOTES BY ANNEE AND SEMESTRE AND STATUT
    public function GetSnotesByAnneeAndSemestreAndStatut($annee, $semestre,$statut)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin("s.inscription", 'inscription')
            ->innerJoin("s.semestre", 'semestre')
            ->innerJoin("s.statutDef", 'def')
            ->where("semestre = :semestre")
            ->andWhere('inscription.annee = :annee')            
            ->andWhere('def.id in (:statut)')            
            ->setParameter('semestre', $semestre)
            ->setParameter('annee', $annee)
            ->setParameter('statut', $statut)
            ->orderBy("s.semestre", "asc")
            ->getQuery()
            ->getResult()
        ;
    }
}
