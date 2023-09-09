<?php

namespace App\Repository;

use App\Entity\XseanceAbsences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XseanceAbsences>
 *
 * @method XseanceAbsences|null find($id, $lockMode = null, $lockVersion = null)
 * @method XseanceAbsences|null findOneBy(array $criteria, array $orderBy = null)
 * @method XseanceAbsences[]    findAll()
 * @method XseanceAbsences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XseanceAbsencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XseanceAbsences::class);
    }

    public function add(XseanceAbsences $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(XseanceAbsences $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return XseanceAbsences[] Returns an array of XseanceAbsences objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('x')
//            ->andWhere('x.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('x.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?XseanceAbsences
//    {
//        return $this->createQueryBuilder('x')
//            ->andWhere('x.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
