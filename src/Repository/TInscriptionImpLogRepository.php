<?php

namespace App\Repository;

use App\Entity\TInscriptionImpLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TInscriptionImpLog>
 *
 * @method TInscriptionImpLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method TInscriptionImpLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method TInscriptionImpLog[]    findAll()
 * @method TInscriptionImpLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TInscriptionImpLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TInscriptionImpLog::class);
    }

    public function add(TInscriptionImpLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TInscriptionImpLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TInscriptionImpLog[] Returns an array of TInscriptionImpLog objects
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

//    public function findOneBySomeField($value): ?TInscriptionImpLog
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
