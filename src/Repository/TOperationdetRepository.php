<?php

namespace App\Repository;

use App\Entity\TOperationdet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TOperationdet|null find($id, $lockMode = null, $lockVersion = null)
 * @method TOperationdet|null findOneBy(array $criteria, array $orderBy = null)
 * @method TOperationdet[]    findAll()
 * @method TOperationdet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TOperationdetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TOperationdet::class);
    }

    // /**
    //  * @return TOperationdet[] Returns an array of TOperationdet objects
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
    */

    /*
    public function findOneBySomeField($value): ?TOperationdet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function getSumMontantCAByPreins($preinscription)
    {
        $request = $this->createQueryBuilder('t')
            ->select("SUM(t.montant) as total")
            ->innerJoin('t.operationcab','operationcab')
            ->innerJoin('operationcab.preinscription','preinscription')
            ->innerJoin('operationcab.annee','annee')
            ->innerJoin('t.organisme','organisme')
            ->andWhere('preinscription = :preinscription')
            ->andWhere('t.active = 1')
            ->andWhere('organisme.id = 7')
            ->setParameter('preinscription', $preinscription)
            // ->groupBy('t.operationcab')
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if(!$request) {
            return ['total' => 0];
        } 
        return $request;
    }
    public function getSumMontantNonOrganismeByCodeFacture($operation)
    {
        $request = $this->createQueryBuilder('t')
            ->select("SUM(t.montant) as total")
            ->Where('t.operationcab = :operation')
            ->andWhere('t.active = 1')
            ->andWhere('t.organisme = 7')
            ->setParameter('operation', $operation)
            ->groupBy('t.operationcab')
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if(!$request) {
            return ['total' => 0];
        } 
        return $request;
    }
    public function getSumMontantByCodeFacture($operation)
    {
        $request = $this->createQueryBuilder('t')
            ->select("SUM(t.montant) as total")
            ->Where('t.operationcab = :operation')
            ->andWhere('t.active = 1')
            ->setParameter('operation', $operation)
            ->groupBy('t.operationcab')
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if(!$request) {
            return ['total' => 0];
        } 
        return $request;
    }
    public function getSumMontantByCodeFactureAndOrganisme($operation,$frais)
    {
        $query =  $this->createQueryBuilder('t')
            ->select("SUM(t.montant) as somme")
            ->Where('t.operationcab = :operation')
            ->andWhere('t.frais = :frais')
            ->andWhere('t.active = 1')
            ->andWhere('t.organisme != 7')
            ->setParameter('operation', $operation)
            ->setParameter('frais', $frais)
            ->groupBy('t.frais')
            ->getQuery()
            ->getOneOrNullResult()
        ;
        return $query ? $query['somme'] : 0;
    }
    // public function getSumMontantByCodeFactureAndOrganismePayant($operation,$frais)
    // {
    //     $query =  $this->createQueryBuilder('t')
    //         ->select("SUM(t.montant) as somme")
    //         ->Where('t.operationcab = :operation')
    //         ->andWhere('t.frais = :frais')
    //         ->andWhere('t.active = 1')
    //         ->andWhere('t.organisme = 103')
    //         ->setParameter('operation', $operation)
    //         ->setParameter('frais', $frais)
    //         ->groupBy('t.frais')
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    //     return $query ? $query['somme'] : 0;
    // }
    public function getSumMontantByCodeFactureAndPayant($operation,$frais)
    {
        $query =  $this->createQueryBuilder('t')
            ->select("SUM(t.montant) as somme")
            ->Where('t.operationcab = :operation')
            ->andWhere('t.frais = :frais')
            ->andWhere('t.active = 1')
            ->andWhere('t.organisme = 7')
            ->setParameter('operation', $operation)
            ->setParameter('frais', $frais)
            ->groupBy('t.frais')
            ->getQuery()
            ->getOneOrNullResult()
        ; 
        return $query ? $query['somme'] : 0;
    }

    public function FindDetGroupByFrais($operation)
    {
        return $this->createQueryBuilder('t')
            ->Where('t.operationcab = :operation')
            ->andWhere('t.active = 1')
            // ->andWhere('t.organisme = 7')
            ->setParameter('operation', $operation)
            ->groupBy('t.frais')
            ->getQuery()
            ->getResult()
        ; 
    }
    
    public function FindDetNotPayant($operation)
    {
        return $this->createQueryBuilder('t')
            ->Where('t.operationcab = :operation')
            ->andWhere('t.active = 1')
            ->andWhere('t.organisme != 7')
            ->setParameter('operation', $operation)
            ->getQuery()
            ->getResult()
        ; 
    }
}
