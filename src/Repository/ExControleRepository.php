<?php

namespace App\Repository;

use App\Entity\AcElement;
use App\Entity\ExControle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExControle|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExControle|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExControle[]    findAll()
 * @method ExControle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExControleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExControle::class);
    }

    // /**
    //  * @return ExControle[] Returns an array of ExControle objects
    //  */
    
    public function checkIfyoucanCalcul($annee, $element, $column)
    {
        return $this->createQueryBuilder('e')
            ->where('e.element = :element')
            ->andWhere('e.'.$column.' = 1')
            ->andWhere('e.annee = :annee')
            ->setParameter('annee', $annee)
            ->setParameter('element', $element)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function checkIfyoucanElement($annee, $element)
    {
        return $this->createQueryBuilder('e')
            ->where('e.element = :element')
            ->andWhere('e.melement = 0')
            ->andWhere('e.annee = :annee')
            ->setParameter('annee', $annee)
            ->setParameter('element', $element)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function checkIfyoucanCalculModule($annee, $module)
    {
        $request = $this->createQueryBuilder('e')
            ->where('e.element in (:element)')
            ->andWhere('e.mmodule = 0')
            ->andWhere('e.annee = :annee')
            ->setParameter('element', $module->getElements())
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        if(count($request) > 0){
            return $request;
        }
        else {
            return null;
        }
    }
    public function checkIfyoucanCalculSemestre($annee, $semestre)
    {
        $request = $this->createQueryBuilder('e')
            ->innerJoin("e.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre = :semestre')
            ->andWhere('e.msemestre = 0')
            ->andWhere('e.annee = :annee')
            ->andWhere('module.active =  1')
            ->setParameter('semestre', $semestre)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        if(count($request) > 0){
            return $request;
        }
        else {
            return null;
        }
    }
    public function checkIfyoucanDelibreSemestre($annee, $semestre)
    {
        $request = $this->createQueryBuilder('e')
            ->innerJoin("e.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre = :semestre')
            ->andWhere('e.simulation = 0')
            ->andWhere('e.annee = :annee')
            ->setParameter('semestre', $semestre)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        if(count($request) > 0){
            return $request;
        }
        else {
            return null;
        }
    }
    public function checkIfyoucanCalculAnnee($annee, $promotion)
    {
        $request = $this->createQueryBuilder('e')
            ->innerJoin("e.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.promotion = :promotion')
            ->andWhere('e.mannee = 0')
            ->andWhere('e.annee = :annee')
            ->setParameter('promotion', $promotion)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        if(count($request) > 0){
            return $request;
        }
        else {
            return null;
        }
    }
    public function checkIfAllElementValide($annee, $module)
    {
        $request = $this->createQueryBuilder('e')
            ->where('e.element in (:element)')
            ->andWhere('e.annee = :annee')
            ->andWhere('e.melement = 0')
            ->setParameter('element', $module->getElements())
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        if(count($request) > 0){
            return $request;
        }
        else {
            return null;
        }
    }
    public function canValidateElement($element, $annee)
    {
        return $this->createQueryBuilder('e')
            ->where('e.element = :element')
            ->andWhere('e.annee = :annee')
            ->andWhere('e.mcc = 1 and e.mtp = 1 and e.mef = 1')
            ->setParameter('element', $element)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function canValidateModule($module, $annee)
    {
        $request =  $this->createQueryBuilder('e')
            ->where('e.element in (:element)')
            ->andWhere('e.annee = :annee')
            ->andWhere('e.melement =  0')
            ->setParameter('element', $module->getElements())
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
        if(count($request) > 0) {
            return $request;
        }
        return null;
    }
    public function canValidateSemestre($semestre, $annee)
    {
        $request =  $this->createQueryBuilder('e')
            ->innerJoin("e.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre = :semestre')
            ->andWhere('e.annee = :annee')
            ->andWhere('e.mmodule =  0')
            ->andWhere('module.active =  1')
            ->setParameter('semestre', $semestre)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
        if(count($request) > 0) {
            return $request;
        }
        return null;
    }
    public function canValidateAnnee($promotion, $annee)
    {
        $request =  $this->createQueryBuilder('e')
            ->innerJoin("e.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->innerJoin("semestre.promotion", "promotion")
            ->where('promotion = :promotion')
            ->andWhere('e.annee = :annee')
            ->andWhere('e.msemestre =  0')
            ->andWhere('module.active =  1')
            ->setParameter('promotion', $promotion)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
        if(count($request) > 0) {
            return $request;
        }
        return null;
    }
    public function updateModuleByElement($module, $annee, $val)
    {
        $this->createQueryBuilder('e')
            ->update()
            ->set("e.mmodule", ":val")
            ->where('e.element in (:element)')
            ->andWhere('e.annee = :annee')
            ->setParameter('element', $module->getElements())
            ->setParameter('annee', $annee)
            ->setParameter('val', $val)
            ->getQuery()
            ->execute()
        ;
    }
    public function updateSemestreByElement($semestre, $annee, $val)
    {
        $elements = $this->getEntityManager()
            ->getRepository(AcElement::class)
            ->getElementsBySemestre($semestre);
            
        $this->createQueryBuilder('e')
            ->update()
            ->set("e.msemestre", ":val")
            ->where('e.element in (:elements)')
            ->andWhere('e.annee = :annee')
            ->setParameter('elements', $elements)
            ->setParameter('annee', $annee)
            ->setParameter('val', $val)
            ->getQuery()
            ->execute()
        ;
    }
    public function updateSemestreBySimulation($semestre, $annee, $val)
    {
        $elements = $this->getEntityManager()
            ->getRepository(AcElement::class)
            ->getElementsBySemestre($semestre);
            
        $this->createQueryBuilder('e')
            ->update()
            ->set("e.simulation", ":val")
            ->where('e.element in (:elements)')
            ->andWhere('e.annee = :annee')
            ->setParameter('elements', $elements)
            ->setParameter('annee', $annee)
            ->setParameter('val', $val)
            ->getQuery()
            ->execute()
        ;
    }
    public function updateAnneeByElement($promotion, $annee, $val)
    {
        $elements = $this->getEntityManager()
            ->getRepository(AcElement::class)
            ->getElementsByPromotion($promotion);
            
        $this->createQueryBuilder('e')
            ->update()
            ->set("e.mannee", ":val")
            ->where('e.element in (:elements)')
            ->andWhere('e.annee = :annee')
            ->setParameter('elements', $elements)
            ->setParameter('annee', $annee)
            ->setParameter('val', $val)
            ->getQuery()
            ->execute()
        ;
    }
   
    public function alreadyValidateModule($module, $annee)
    {
        $request =  $this->createQueryBuilder('e')
            ->where('e.element in (:element)')
            ->andWhere('e.annee = :annee')
            ->andWhere('e.mmodule =  0')
            ->setParameter('element', $module->getElements())
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
        if(count($request) > 0) {
            return $request;
        }
        return null;
    }
    public function alreadyValidateSemestre($semestre, $annee)
    {
        $request =  $this->createQueryBuilder('e')
            ->innerJoin("e.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre = :semestre')
            ->andWhere('e.msemestre = 0')
            ->andWhere('e.annee = :annee')
            ->setParameter('semestre', $semestre)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
        if(count($request) > 0) {
            return $request;
        }
        return null;
    }
    public function alreadyValidateAnnee($promotion, $annee)
    {
        $request =  $this->createQueryBuilder('e')
            ->innerJoin("e.element", "element")
            ->innerJoin("element.module", "module")
            ->innerJoin("module.semestre", "semestre")
            ->where('semestre.promotion = :promotion')
            ->andWhere('e.mannee = 0')
            ->andWhere('e.annee = :annee')
            ->andWhere('module.active =  1')
            ->setParameter('promotion', $promotion)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
        // dd($request);
        if(count($request) > 0) {
            return $request;
        }
        return null;
    }
    /*
    public function findOneBySomeField($value): ?ExControle
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
