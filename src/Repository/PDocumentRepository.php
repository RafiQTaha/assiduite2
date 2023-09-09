<?php
namespace App\Repository;

use App\Entity\PDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method PDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method PDocument[]    findAll()
 * @method PDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PDocument::class);
    }

    // /**
    //  * @return PDocument[] Returns an array of PDocument objects
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
    
    
    public function getDocumentDoesNotExistAdmission($admission)
    {
        $subQueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $subQuery = $subQueryBuilder
            ->select(['p.id'])
            ->from('App:PDocument', 'p')
            ->innerJoin('p.admissionDocuments', 'addocument')
            ->innerJoin('addocument.preinscription', 'preinscription')
            ->where('preinscription = :preinscription')
            ->setParameter('preinscription', $admission->getPreinscription())
            ->getQuery()
            ->getArrayResult()
        ;
        // dd($subQuery);
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select(['p'])
            ->from('App:PDocument', 'p')
            ->innerJoin('p.etablissement', 'etab')
            ->Where('p.attribution = :INSCRIPTION')
            ->andWhere($queryBuilder->expr()->notIn('p.id', ':subQuery'))
            ->andWhere('p.active = :active')
            ->andWhere('etab = :etab')
            ->setParameter('subQuery', $subQuery)
            ->setParameter('INSCRIPTION', 'INSCRIPTION')
            ->setParameter('etab', $admission->getPreinscription()->getAnnee()->getFormation()->getEtablissement())
            ->setParameter('active', '1')
            ->getQuery()
        ;

        return $query->getResult();
    }


    public function getDocumentDoesNotExistPreisncriptions($preinscription, $etablissement)
    {   
        $subQueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $subQuery = $subQueryBuilder
            ->select(['d.id'])
            ->from('App:TPreinscription', 'p')
            ->innerJoin('p.documents', 'd')
            ->where('p.id = :preinscription')
            // ->Andwhere('d.natureDemande = :nat')
            ->setParameter('preinscription', $preinscription)
            // ->setParameter('nat', $preinscription->getNature())
            ->getQuery()
            ->getArrayResult()
        ;
        // dd($subQuery);
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select(['p'])
            ->from('App:PDocument', 'p')
            ->innerJoin('p.etablissement', 'etab')
            ->Where('p.attribution = :INSCRIPTION')
            ->andWhere($queryBuilder->expr()->notIn('p.id', ':subQuery'))
            ->andWhere('p.active = :active')
            ->andWhere('etab = :etab')
            ->setParameter('subQuery', $subQuery)
            ->setParameter('INSCRIPTION', 'PREINSCRIPTION')
            ->setParameter('etab', $etablissement)
            ->setParameter('active', '1')
            ->getQuery()
        ;

        return $query->getResult();
    }
    public function findAllBy($etablissmenet, $attribution)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder
            ->select(['p'])
            ->from('App:PDocument', 'p')
            ->innerJoin('p.etablissement', 'etab')
            ->Where('p.attribution = :attribution')
            ->andWhere('p.active = :active')
            ->andWhere('etab = :etab')

            ->Where('p.attribution = :attribution')
            ->andWhere('p.active = :active')
            ->andWhere('etab = :etab')
            ->setParameter('attribution', $attribution)
            ->setParameter('etab', $etablissmenet)
            ->setParameter('active', '1')
            ->getQuery()
        ;

        return $query->getResult();
    }
    
}
