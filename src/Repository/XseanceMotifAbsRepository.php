<?php

namespace App\Repository;

use App\Entity\XseanceMotifAbs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XseanceMotifAbs>
 *
 * @method XseanceMotifAbs|null find($id, $lockMode = null, $lockVersion = null)
 * @method XseanceMotifAbs|null findOneBy(array $criteria, array $orderBy = null)
 * @method XseanceMotifAbs[]    findAll()
 * @method XseanceMotifAbs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XseanceMotifAbsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XseanceMotifAbs::class);
    }

    public function add(XseanceMotifAbs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(XseanceMotifAbs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return XseanceMotifAbs[] Returns an array of XseanceMotifAbs objects
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

//    public function findOneBySomeField($value): ?XseanceMotifAbs
//    {
//        return $this->createQueryBuilder('x')
//            ->andWhere('x.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
