<?php

namespace App\Repository;

use App\Entity\PAnonymatActuel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PAnonymatActuel>
 *
 * @method PAnonymatActuel|null find($id, $lockMode = null, $lockVersion = null)
 * @method PAnonymatActuel|null findOneBy(array $criteria, array $orderBy = null)
 * @method PAnonymatActuel[]    findAll()
 * @method PAnonymatActuel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PAnonymatActuelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PAnonymatActuel::class);
    }

    public function add(PAnonymatActuel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PAnonymatActuel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PAnonymatActuel[] Returns an array of PAnonymatActuel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PAnonymatActuel
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
