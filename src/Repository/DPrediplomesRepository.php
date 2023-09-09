<?php

namespace App\Repository;

use App\Entity\DPrediplomes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DPrediplomes>
 *
 * @method DPrediplomes|null find($id, $lockMode = null, $lockVersion = null)
 * @method DPrediplomes|null findOneBy(array $criteria, array $orderBy = null)
 * @method DPrediplomes[]    findAll()
 * @method DPrediplomes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DPrediplomesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DPrediplomes::class);
    }

    public function add(DPrediplomes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DPrediplomes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DPrediplomes[] Returns an array of DPrediplomes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DPrediplomes
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
