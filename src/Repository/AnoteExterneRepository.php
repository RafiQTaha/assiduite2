<?php

namespace App\Repository;

use App\Entity\AnoteExterne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnoteExterne>
 *
 * @method AnoteExterne|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnoteExterne|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnoteExterne[]    findAll()
 * @method AnoteExterne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnoteExterneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnoteExterne::class);
    }

    public function add(AnoteExterne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AnoteExterne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AnoteExterne[] Returns an array of AnoteExterne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

   public function findNoteByAdmission($admission, $annee): ?AnoteExterne
   {
       return $this->createQueryBuilder('a')
           ->andWhere('a.admission = :admission')
           ->andWhere('a.annee = :annee')
           ->setParameter('admission', $admission)
           ->setParameter('annee', $annee)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
