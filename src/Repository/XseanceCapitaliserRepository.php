<?php

namespace App\Repository;

use App\Entity\XseanceCapitaliser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XseanceCapitaliser>
 *
 * @method XseanceCapitaliser|null find($id, $lockMode = null, $lockVersion = null)
 * @method XseanceCapitaliser|null findOneBy(array $criteria, array $orderBy = null)
 * @method XseanceCapitaliser[]    findAll()
 * @method XseanceCapitaliser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XseanceCapitaliserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XseanceCapitaliser::class);
    }

    public function add(XseanceCapitaliser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(XseanceCapitaliser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return XseanceCapitaliser[] Returns an array of XseanceCapitaliser objects
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

//    public function findOneBySomeField($value): ?XseanceCapitaliser
//    {
//        return $this->createQueryBuilder('x')
//            ->andWhere('x.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
