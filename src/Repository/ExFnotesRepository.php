<?php

namespace App\Repository;

use App\Entity\ExFnotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExFnotes>
 *
 * @method ExFnotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExFnotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExFnotes[]    findAll()
 * @method ExFnotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExFnotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExFnotes::class);
    }

    public function add(ExFnotes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExFnotes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function getFnotesByAdmissions($admissions)
    {
        return $this->createQueryBuilder('f')
            ->innerJoin("f.admission", 'admission')
            ->where("admission in (:admissions)")
            ->setParameter('admissions', $admissions)
            ->groupBy("admission")
            ->getQuery()
            ->getResult()
        ;
    }
    // andWhere('r.winner IN (:ids)')
    //          ->setParameter('ids', $ids);

//    /**
//     * @return ExFnotes[] Returns an array of ExFnotes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExFnotes
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
