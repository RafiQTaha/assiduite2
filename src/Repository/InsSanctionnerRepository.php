<?php

namespace App\Repository;

use App\Entity\InsSanctionner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InsSanctionner>
 *
 * @method InsSanctionner|null find($id, $lockMode = null, $lockVersion = null)
 * @method InsSanctionner|null findOneBy(array $criteria, array $orderBy = null)
 * @method InsSanctionner[]    findAll()
 * @method InsSanctionner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InsSanctionnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InsSanctionner::class);
    }

    public function add(InsSanctionner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InsSanctionner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
//    /**
//     * @return InsSanctionner[] Returns an array of InsSanctionner objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InsSanctionner
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

   public function getHistoriqueDesActivesConvocations()
   {
       return $this->createQueryBuilder('insSanctionner')
            ->innerJoin("insSanctionner.inscription","inscription")
            ->innerJoin("inscription.admission","admission")
            ->innerJoin("admission.preinscription","preinscription")
            ->innerJoin("preinscription.etudiant","etudiant")
            ->innerJoin("inscription.promotion","promotion")
            ->innerJoin("inscription.annee","annee")
            ->LeftJoin("insSanctionner.agression","agression")
            ->LeftJoin("insSanctionner.sanction","sanction")
            ->andWhere('insSanctionner.active = 1')
            ->getQuery()
            ->getResult()
       ;
   }
}
