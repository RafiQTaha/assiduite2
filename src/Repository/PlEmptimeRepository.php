<?php

namespace App\Repository;

use App\Entity\PlEmptime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlEmptime|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlEmptime|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlEmptime[]    findAll()
 * @method PlEmptime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlEmptimeRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlEmptime::class);
        $this->em = $registry->getManager();
    }

    // /**
    //  * @return PlEmptime[] Returns an array of PlEmptime objects
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
    public function findOneBySomeField($value): ?PlEmptime
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
    public function getEmptimeBySemestreAndGroupe($semestre,$groupes)
    {
        return $this->createQueryBuilder('e')
            ->leftJoin("e.groupe", "groupe")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->andWhere('groupe in (:groupes) or e.groupe is null')
            ->setParameter('semestre', $semestre)
            ->setParameter('groupes', $groupes)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEmptimeBySemestreAndGroupeAndProfesseur($semestre,$groupes,$professeur)
    {
        return $this->createQueryBuilder('e')
            ->leftJoin("e.groupe", "groupe")
            ->innerJoin("e.emptimens", "emptimens")
            ->InnerJoin("emptimens.enseignant", "enseignant")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere('groupe in (:groupes) or e.groupe is null')
            ->andwhere('enseignant.id = :enseignant')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->setParameter('semestre', $semestre)
            ->setParameter('groupes', $groupes)
            ->setParameter('enseignant', $professeur)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getEmptimeBySemestreAndProfesseur($semestre,$professeur)
    {
        // dd($semestre,$professeur);
        return $this->createQueryBuilder('e')
            ->innerJoin("e.emptimens", "emptimens")
            ->InnerJoin("emptimens.enseignant", "enseignant")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere('enseignant.id = :enseignant')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->setParameter('semestre', $semestre)
            ->setParameter('enseignant', $professeur)
            ->getQuery()
            ->getResult()
        ;
    }
    ////////////////////////////////////////////////////Professur

    public function getEmptimeBySemestreAndGroupeAndSemaineAndProfesseur($semestre,$groupe,$semaine,$professeur)
    {
        // dd($semaine);
        // $return = $this->createQueryBuilder('e')
        return $this->createQueryBuilder('e')
            ->innerJoin("e.groupe", "groupe")
            ->innerJoin("e.emptimens", "emptimens")
            ->InnerJoin("emptimens.enseignant", "enseignant")
            ->innerJoin("e.semaine", "semaine")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere("groupe = :groupe")
            ->andWhere("semaine = :semaine")
            ->andwhere('enseignant.id = :enseignant')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->setParameter('semestre', $semestre)
            ->setParameter('groupe', $groupe)
            ->setParameter('semaine', $semaine)
            ->setParameter('enseignant', $professeur)
            ->getQuery()
            ->getResult()
        ;
        // dd('test');
        // dd($return);
    }
    public function getEmptimeBySemestreAndSemaineAndProfesseur($semestre,$semaine,$professeur)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin("e.semaine", "semaine")
            ->innerJoin("e.emptimens", "emptimens")
            ->InnerJoin("emptimens.enseignant", "enseignant")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere("semaine = :semaine")
            ->andwhere('enseignant.id = :enseignant')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->setParameter('semestre', $semestre)
            ->setParameter('semaine', $semaine)
            ->setParameter('enseignant', $professeur)
            ->getQuery()
            ->getResult()
        ;
    }
    //////////////////////////////////////////////////////////////
    // public function getEmptimeBySemestreAndGroupe($semestre,$groupe)
    // {
    //     return $this->createQueryBuilder('e')
    //         ->innerJoin("e.groupe", "groupe")
    //         ->innerJoin("e.programmation", "programmation")
    //         ->innerJoin("programmation.element", "element")
    //         ->innerJoin("element.module", "module")
    //         ->innerJoin("module.semestre", "semestre")
    //         ->where('semestre.id = :semestre')
    //         ->andWhere("groupe = :groupe")
    //         ->andWhere("e.active = 1")
    //         ->setParameter('semestre', $semestre)
    //         ->setParameter('groupe', $groupe)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    public function getEmptimeBySemestre($semestre)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->setParameter('semestre', $semestre)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEmptimeByHdHf($hd, $hf, $todayDate)
    {
        return $this->createQueryBuilder('e')
            ->where('e.heur_db = :hd')
            ->andWhere('e.heur_fin = :hf')
            ->andWhere('e.heur_fin <= :hf')
            ->andWhere('e.start LIKE :date')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->setParameter('hd', $hd)
            ->setParameter('hf', $hf)
            ->setParameter('date', $todayDate)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEmptimeByDay($todayDate)
    {
        return $this->createQueryBuilder('e')
            ->where('e.start LIKE :date')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->setParameter('date', $todayDate)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEmptimeByCurrentDay()
    {
        $date =date('Y-m-d')."%";
        return $this->createQueryBuilder('e')
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->innerJoin("semestre.promotion", "promotion")
            ->innerJoin("promotion.formation", "formation")
            ->innerJoin("formation.etablissement", "etablissement")
            ->where('e.start like :date')
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 0")
            ->andWhere("e.xsalle is not NULL")
            ->andWhere("formation.designation not like 'Résidanat%' ")
            ->andWhere("etablissement.id != 25 ")
            // ->andWhere("e.annuler = 0")
            // ->setParameter('date', $todayDate)
            ->groupBy('e.xsalle')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }



    public function getEmptimeBySemestreAndGroupeAndSemaine($semestre,$groupe,$semaine)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin("e.groupe", "groupe")
            ->innerJoin("e.semaine", "semaine")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere("groupe = :groupe")
            ->andWhere("semaine = :semaine")
            ->andWhere("e.active = 1")
            // ->andWhere("e.annuler = 0")
            ->setParameter('semestre', $semestre)
            ->setParameter('groupe', $groupe)
            ->setParameter('semaine', $semaine)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getEmptimeBySemestreAndSemaine($semestre,$semaine)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin("e.semaine", "semaine")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere("semaine = :semaine")
            ->andWhere("e.active = 1")
            ->setParameter('semestre', $semestre)
            ->setParameter('semaine', $semaine)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getEmptimeBySemestreAndGroupeAndSemaineToGenerer($semestre,$groupe,$semaine)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin("e.groupe", "groupe")
            ->innerJoin("e.semaine", "semaine")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere("groupe = :groupe")
            ->andWhere("semaine = :semaine")
            ->andWhere("e.active = 1")
            ->andWhere("e.valider = 1")
            ->setParameter('semestre', $semestre)
            ->setParameter('groupe', $groupe)
            ->setParameter('semaine', $semaine)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getEmptimeAnnulerBySemestreAndGroupeAndSemaineToGenerer($semestre,$groupe,$semaine)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin("e.groupe", "groupe")
            ->innerJoin("e.semaine", "semaine")
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.id = :semestre')
            ->andWhere("groupe = :groupe")
            ->andWhere("semaine = :semaine")
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 1")
            ->setParameter('semestre', $semestre)
            ->setParameter('groupe', $groupe)
            ->setParameter('semaine', $semaine)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getEmptimeBySemestreAndSemaineToGenerer($semestre,$semaine)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->innerJoin("e.semaine", "semaine")
            ->where('semestre.id = :semestre')
            ->andWhere("semaine.id = :semaine")
            ->andWhere("e.active = 1")
            ->andWhere("e.valider = 1")
            ->setParameter('semestre', $semestre)
            ->setParameter('semaine', $semaine)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getEmptimeAnnulerBySemestreAndSemaineToGenerer($semestre,$semaine)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin("e.programmation", "programmation")
            ->innerJoin("programmation.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->innerJoin("e.semaine", "semaine")
            ->where('semestre.id = :semestre')
            ->andWhere("semaine.id = :semaine")
            ->andWhere("e.active = 1")
            ->andWhere("e.annuler = 1")
            ->setParameter('semestre', $semestre)
            ->setParameter('semaine', $semaine)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getNbr_sc_regroupe($seance)
    {
        $sqls="select count(*) as nbr_sc_regroupe 
        from pr_programmation prog 
        where prog.regroupe = (select prog.regroupe from pl_emptime emp inner join pr_programmation prog on emp.programmation_id = prog.id where emp.id = '$seance' group by prog.id)";
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $nbr_sc_regroupe = $resultSets->fetch();
        return $nbr_sc_regroupe['nbr_sc_regroupe'];
    }

    public function GetEnsMontByIdSceance($seance)
    {
        $sqls="SELECT pl.id as seance ,frm.id AS formation,ens.id AS enseignant,prog.nature_epreuve_id , TIMESTAMPDIFF(MINUTE, pl.heur_db , pl.heur_fin)/60 AS nbr_heure,gr.montant, (TIMESTAMPDIFF(MINUTE, pl.heur_db , pl.heur_fin)/60) * gr.montant AS Mt_tot2 , 
        (select count(*) from pr_programmation prog 
        where prog.regroupe = (select prog.regroupe from pl_emptime emp 
        inner join pr_programmation prog on emp.programmation_id = prog.id 
        where emp.id = $seance group by prog.id)) 
        as nbr_sc_regroupe , CASE WHEN prog.regroupe IS NOT NULL AND prog.categorie = 'S' THEN 0
        ELSE (TIMESTAMPDIFF(MINUTE, pl.heur_db , pl.heur_fin)/60) * gr.montant END AS Mt_tot
        FROM pl_emptime pl
        INNER JOIN pr_programmation prog on prog.id = pl.programmation_id 
        INNER JOIN ac_element ele on ele.id = prog.element_id
        INNER JOIN ac_module mdl on mdl.id = ele.module_id
        INNER JOIN ac_semestre sem on sem.id = mdl.semestre_id
        INNER JOIN ac_promotion prom on prom.id = sem.promotion_id
        INNER JOIN ac_formation frm on frm.id = prom.formation_id
        INNER JOIN ac_etablissement etab on etab.id = frm.etablissement_id
        INNER join pl_emptimens pl_ens on pl.id = pl_ens.seance_id  and pl_ens.active = 1
        INNER JOIN penseignant ens ON ens.id = pl_ens.enseignant_id
        INNER JOIN type_element tele ON tele.id = ele.nature_id
        left join pensgrille gr on gr.grade_id = ens.grade_id AND gr.formation_id = frm.id aND prog.nature_epreuve_id  = gr.type_epreuve_id 
        AND gr.nature = tele.code 
        -- AND ele.nature = gr.nature
        WHERE pl.id = $seance";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }

    public function findSeanceByCurrentYears($currentyear)
    {
        $sqls="SELECT DISTINCT ep.id 'seance_id',ep.code,sm.id 'semaine_id',sm.nsemaine,ann.id 'annee_id',ann.designation 'Année',etab.id 'etablissement_id',etab.designation 'Etablissement',
        frm.id 'formation_id',frm.designation 'Formation',prm.id 'promotion_id',prm.designation 'Promotion',sem.id 'semesre_id',sem.designation 'Semestre',mdl.id 'module_id',mdl.designation 'Module',ele.id 'element_id',ele.code 'Code_element',ele.designation 'Element',ne.id 'nat_epreuve_id',ne.designation 'Nature_epreuve',te.id 'Id_Type',te.designation 'Type',date(start) 'DateSeance',ep.start 'Date_début',ep.end 'Date_fin',ep.valider,ep.generer,ep.annuler,ep.motif_annuler,s.id 'salle_id',s.code as code_salle,s.designation 'Salle',grp.id 'groupe_id',grp.niveau,epe.id 'enseignant_id',epe.code as code_enseignant,epe.nom,epe.prenom,gr.id 'grade_id',gr.code as code_grade,gr.abreviation 'Grade'
        FROM pl_emptime ep
        INNER join pr_programmation pr on pr.id = ep.programmation_id
        INNER join pnature_epreuve ne on ne.id = pr.nature_epreuve_id
        INNER join ac_element ele on ele.id = pr.element_id
        INNER JOIN type_element te on te.id = ele.nature_id
        INNER join ac_module mdl on mdl.id = ele.module_id
        INNER join ac_semestre sem on sem.id = mdl.semestre_id
        INNER join ac_promotion prm on prm.id = sem.promotion_id
        inner join ac_formation frm on frm.id = prm.formation_id
        INNER JOIN ac_annee ann ON ann.id = pr.annee_id
        INNER join ac_etablissement etab on etab.id = frm.etablissement_id
        INNER join semaine sm on sm.id = ep.semaine_id
        left join pl_emptimens emen on emen.seance_id = ep.id
        left join penseignant epe on epe.id = emen.enseignant_id
        left join pgrade gr on gr.id = epe.grade_id
        LEFT JOIN psalles s ON s.id = ep.salle_id
        LEFT JOIN pgroupe grp ON grp.id = ep.groupe_id
        WHERE ann.designation= '$currentyear' and ep.active = 1";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }

    public function findSeanceByCurrentYearsAndWeek($currentyear,$semaine_id)
    {
        $sqls="SELECT DISTINCT ep.id 'seance_id',ep.code,sm.id 'semaine_id',sm.nsemaine,ann.id 'annee_id',ann.designation 'Année',etab.id 'etablissement_id',etab.designation 'Etablissement',
        frm.id 'formation_id',frm.designation 'Formation',prm.id 'promotion_id',prm.designation 'Promotion',sem.id 'semesre_id',sem.designation 'Semestre',mdl.id 'module_id',mdl.designation 'Module',ele.id 'element_id',ele.code 'Code_element',ele.designation 'Element',ne.id 'nat_epreuve_id',ne.designation 'Nature_epreuve',te.id 'Id_Type',te.designation 'Type',date(start) 'DateSeance',ep.start 'Date_début',ep.end 'Date_fin',ep.valider,ep.generer,ep.annuler,ep.motif_annuler,s.id 'salle_id',s.code as code_salle,s.designation 'Salle',grp.id 'groupe_id',grp.niveau,epe.id 'enseignant_id',epe.code as code_enseignant,epe.nom,epe.prenom,gr.id 'grade_id',gr.code as code_grade,gr.abreviation 'Grade'
        FROM pl_emptime ep
        INNER join pr_programmation pr on pr.id = ep.programmation_id
        INNER join pnature_epreuve ne on ne.id = pr.nature_epreuve_id
        INNER join ac_element ele on ele.id = pr.element_id
        INNER JOIN type_element te on te.id = ele.nature_id
        INNER join ac_module mdl on mdl.id = ele.module_id
        INNER join ac_semestre sem on sem.id = mdl.semestre_id
        INNER join ac_promotion prm on prm.id = sem.promotion_id
        inner join ac_formation frm on frm.id = prm.formation_id
        INNER JOIN ac_annee ann ON ann.id = pr.annee_id
        INNER join ac_etablissement etab on etab.id = frm.etablissement_id
        INNER join semaine sm on sm.id = ep.semaine_id
        left join pl_emptimens emen on emen.seance_id = ep.id
        left join penseignant epe on epe.id = emen.enseignant_id
        left join pgrade gr on gr.id = epe.grade_id
        LEFT JOIN psalles s ON s.id = ep.salle_id
        LEFT JOIN pgroupe grp ON grp.id = ep.groupe_id
        WHERE ann.designation= '$currentyear' and ep.active = 1 and sm.id = $semaine_id ";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }
    
    
    
    
}
