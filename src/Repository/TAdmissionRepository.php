<?php

namespace App\Repository;

use App\Entity\TAdmission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TAdmission|null find($id, $lockMode = null, $lockVersion = null)
 * @method TAdmission|null findOneBy(array $criteria, array $orderBy = null)
 * @method TAdmission[]    findAll()
 * @method TAdmission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TAdmissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TAdmission::class);
    }

    // /**
    //  * @return TAdmission[] Returns an array of TAdmission objects
    //  */
    
    public function getAdmissionByAnnee($annee)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin("t.preinscription", "preinscription")
            ->where("preinscription.annee = :annee")
            ->setParameter('annee', $annee)
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    public function findAdmssions($value)
    {
        return $this->createQueryBuilder('t')
            ->select('t.id, t.code, etudiant.nom, etudiant.prenom')
            ->innerJoin("t.preinscription","preinscription")
            ->innerJoin("preinscription.etudiant","etudiant")
            ->where('t.code like :val')
            ->orWhere("etudiant.nom like :val")
            ->orWhere("etudiant.prenom like :val")
            ->setParameter('val', "%".$value."%")
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        // dd($admissions);
        // $html = "";
        // foreach ($admissions as $admission) {
        //     dd($admission->getPreinscription()->getEtudiant()->getStatutDeliberation());
        // }
        // return $html;
    }
    
    
}
