<?php

namespace App\Repository;

use App\Entity\PEnsgrille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PEnsgrille|null find($id, $lockMode = null, $lockVersion = null)
 * @method PEnsgrille|null findOneBy(array $criteria, array $orderBy = null)
 * @method PEnsgrille[]    findAll()
 * @method PEnsgrille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PEnsgrilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PEnsgrille::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PEnsgrille $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PEnsgrille $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PEnsgrille[] Returns an array of PEnsgrille objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PEnsgrille
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
