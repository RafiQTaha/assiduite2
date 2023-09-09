<?php

namespace App\Repository;

use App\Entity\AcEpreuve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcEpreuve|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcEpreuve|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcEpreuve[]    findAll()
 * @method AcEpreuve[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcEpreuveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcEpreuve::class);
        $this->em = $registry->getManager();
    }

    // /**
    //  * @return AcEpreuve[] Returns an array of AcEpreuve objects
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

    /*
    public function findOneBySomeField($value): ?AcEpreuve
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findEpreuveValideByCurrentYear($currentyear, $etab)
    {
        $sqls="SELECT ins.id 'Id Inscription',ins.code 'code inscriptiont', adm.code 'code admission', pre.code 'code preinscription', ins.code_anonymat, ins.code_anonymat_rat, stat.code 'code statut', etu.nom, etu.prenom,ann.code 'code annee', ann.designation 'Annee',etab.code 'code etablissement', etab.designation 'Etablissement', frm.code 'code formation', frm.designation 'Formation',prm.code  'code promotion', prm.designation 'Promotion', sem.code 'code semestre',sem.designation 'Semestre', mdl.code 'code module', mdl.designation 'Module',elm.code 'code element', elm.designation  'Element', epv.id 'id epreuve',epv.code 'code epreuve',epv.nature 'nature', pr.code 'code Nature Epreuve',pr.designation 'Nature Epreuve',epv.date_epreuve 'date epreuve',gn.note 'note'
        FROM `ac_epreuve` epv
        inner join ac_element elm on elm.id = epv.element_id
        inner join ac_annee ann on ann.id = epv.annee_id
        inner join ex_gnotes gn on gn.epreuve_id = epv.id
        inner join tinscription ins on ins.id = gn.inscription_id
        inner join ac_module mdl on mdl.id = elm.module_id
        inner join ac_semestre sem on sem.id = mdl.semestre_id
        inner join ac_promotion prm on prm.id = sem.promotion_id
        inner join ac_formation frm on frm.id = prm.formation_id
        inner join ac_etablissement etab on etab.id = frm.etablissement_id
        inner join tadmission adm on adm.id = ins.admission_id
        inner join tpreinscription pre on pre.id = adm.preinscription_id
        inner join tetudiant etu on etu.id = pre.etudiant_id
        inner join pnature_epreuve pr on pr.id = epv.nature_epreuve_id
        inner join pstatut stat on stat.id = ins.statut_id
        where ann.designation = '$currentyear' and epv.statut_id = 30 and etab.id = $etab  and (sem.designation like '%1' or sem.designation like '%3' or sem.designation like '%5' or sem.designation like '%7' or sem.designation like '%9' or sem.designation like '%11' or sem.designation like '%13')";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }
    public function findEpreuveValideS2ByCurrentYear($currentyear, $etab)
    {
        $sqls="SELECT ins.id 'Id Inscription',ins.code 'code inscriptiont', adm.code 'code admission', pre.code 'code preinscription', ins.code_anonymat, ins.code_anonymat_rat, stat.code 'code statut', etu.nom, etu.prenom,ann.code 'code annee', ann.designation 'Annee',etab.code 'code etablissement', etab.designation 'Etablissement', frm.code 'code formation', frm.designation 'Formation',prm.code  'code promotion', prm.designation 'Promotion', sem.code 'code semestre',sem.designation 'Semestre', mdl.code 'code module', mdl.designation 'Module',elm.code 'code element', elm.designation  'Element', epv.id 'id epreuve',epv.code 'code epreuve',epv.nature 'nature', pr.code 'code Nature Epreuve',pr.designation 'Nature Epreuve',epv.date_epreuve 'date epreuve',gn.note 'note',epv.validated 'Date Validation'
        FROM `ac_epreuve` epv
        inner join ac_element elm on elm.id = epv.element_id
        inner join ac_annee ann on ann.id = epv.annee_id
        inner join ex_gnotes gn on gn.epreuve_id = epv.id
        inner join tinscription ins on ins.id = gn.inscription_id
        inner join ac_module mdl on mdl.id = elm.module_id
        inner join ac_semestre sem on sem.id = mdl.semestre_id
        inner join ac_promotion prm on prm.id = sem.promotion_id
        inner join ac_formation frm on frm.id = prm.formation_id
        inner join ac_etablissement etab on etab.id = frm.etablissement_id
        inner join tadmission adm on adm.id = ins.admission_id
        inner join tpreinscription pre on pre.id = adm.preinscription_id
        inner join tetudiant etu on etu.id = pre.etudiant_id
        inner join pnature_epreuve pr on pr.id = epv.nature_epreuve_id
        inner join pstatut stat on stat.id = ins.statut_id
        where ann.designation = '$currentyear' and epv.statut_id = 30 and etab.id = $etab and (sem.designation like '%2' or sem.designation like '%4' or sem.designation like '%6' or sem.designation like '%8' or sem.designation like '%10' or sem.designation like '%12' or sem.designation like '%14')";
        // dd($sqls);
        $stmts = $this->em->getConnection()->prepare($sqls);
        $resultSets = $stmts->executeQuery();
        $result = $resultSets->fetchAll();
        return $result;
    }
}
