<?php

namespace App\Repository;

use App\Entity\TAdmissionDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TAdmissionDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method TAdmissionDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method TAdmissionDocument[]    findAll()
 * @method TAdmissionDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TAdmissionDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TAdmissionDocument::class);
    }

    // /**
    //  * @return TAdmissionDocument[] Returns an array of TAdmissionDocument objects
    //  */
    
    
    

    /*
    public function findOneBySomeField($value): ?TAdmissionDocument
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
