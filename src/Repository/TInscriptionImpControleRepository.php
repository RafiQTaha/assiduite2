<?php

namespace App\Repository;

use App\Entity\TInscriptionImpControle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TInscriptionImpControle>
 *
 * @method TInscriptionImpControle|null find($id, $lockMode = null, $lockVersion = null)
 * @method TInscriptionImpControle|null findOneBy(array $criteria, array $orderBy = null)
 * @method TInscriptionImpControle[]    findAll()
 * @method TInscriptionImpControle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TInscriptionImpControleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TInscriptionImpControle::class);
    }

    public function add(TInscriptionImpControle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TInscriptionImpControle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TInscriptionImpControle[] Returns an array of TInscriptionImpControle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TInscriptionImpControle
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
