<?php

namespace App\Repository;

use App\Entity\AcAnnee;
use App\Entity\ExGnotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExGnotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExGnotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExGnotes[]    findAll()
 * @method ExGnotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExGnotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExGnotes::class);
    }

    // /**
    //  * @return ExGnotes[] Returns an array of ExGnotes objects
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

    public function ExgnotesOrderByNom($epreuve)
    {
        return $this->createQueryBuilder('e')
                    ->innerJoin('e.epreuve', "epreuve")
                    ->innerJoin('e.inscription', "inscription")
                    ->innerJoin('inscription.admission', "admission")
                    ->innerJoin('admission.preinscription', "preinscription")
                    ->innerJoin('preinscription.etudiant', "etudiant")
                    ->where(' epreuve= :epreuve')
                    ->setParameter('epreuve', $epreuve)
                    ->orderBy('etudiant.nom','ASC')
                    ->getQuery()
                    ->getResult()
        ;
    }
    public function getNombreSaisi($epreuve)
    {
        return $this->createQueryBuilder('e')
                    ->innerJoin('e.epreuve', "epreuve")
                    ->where('epreuve.id = :epreuve')
                    ->andWhere("(e.absence = 0 or e.absence is null) AND (e.note IS NOT NULL OR e.note != '' )")
                    ->setParameter('epreuve', $epreuve)
                    ->getQuery()
                    ->getResult()
        ;
    }
    public function getNombreNonSaisi($epreuve)
    {
        return $this->createQueryBuilder('e')
                    ->innerJoin('e.epreuve', "epreuve")
                    ->where('epreuve.id = :epreuve')
                    ->andWhere("(e.absence = 0 or e.absence is null) AND (e.note IS NULL OR e.note = '' )")
                    ->setParameter('epreuve', $epreuve)
                    ->getQuery()
                    ->getResult()
        ;
    }
    public function checkIfModuleCapitaliser($enote)
    {
        return $this->createQueryBuilder('e')
                    ->innerJoin('e.epreuve', "epreuve")
                    ->innerJoin('epreuve.element', "element")
                    ->innerJoin('e.inscription', "inscription")
                    ->where('element= :element')
                    ->andwhere('inscription= :inscription')
                    ->andWhere("e.observation = 'CAP'")
                    ->setParameter('element', $enote->getElement())
                    ->setParameter('inscription', $enote->getInscription())
                    ->getQuery()
                    ->getResult()
        ;
    }

    
    public function getNoteTpByInscription($enote,$nature,$natureEpreuve)
    {
        return $this->createQueryBuilder('e')
                    ->innerJoin('e.epreuve', "epreuve")
                    ->innerJoin('e.inscription', "inscription")
                    ->innerJoin('epreuve.annee', "annee")
                    ->innerJoin('epreuve.element', "element")
                    ->where('annee = :annee')
                    ->AndWhere('epreuve.nature = :nature')
                    ->AndWhere('epreuve.natureEpreuve = :natureEpreuve')
                    ->AndWhere('element = :element')
                    ->AndWhere('inscription = :inscription')
                    ->setParameter('annee', $enote->getInscription()->getAnnee())
                    ->setParameter('nature', $nature)
                    ->setParameter('natureEpreuve', $natureEpreuve)
                    ->setParameter('element', $enote->getElement())
                    ->setParameter('inscription', $enote->getInscription())
                    ->getQuery()
                    ->getResult()
        ;
    }
    
}
