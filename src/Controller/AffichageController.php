<?php

namespace App\Controller;

use DateTime;
use Mpdf\Mpdf;
use App\Entity\AcAnnee;
use App\Entity\PSalles;
use App\Entity\Xseance;
use App\Entity\Machines;
use App\Entity\Userinfo;
use App\Entity\PlEmptime;
use App\Entity\Checkinout;
use App\Entity\TAdmission;
use App\Entity\ISeanceSalle;
use App\Entity\TInscription;
use App\Entity\AcEtablissement;
use App\Entity\XseanceAbsences;
use App\Entity\XseanceCapitaliser;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AffichageController extends AbstractController
{
    private $em;
    private $emAssiduite;
    private $emPointage;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
        $this->emAssiduite = $doctrine->getManager('assiduite');
        $this->emPointage = $doctrine->getManager('pointage');
    }
    // #[Route('/affichage', name: 'app_affichage')]
    // public function index(): Response
    // {
    //     return $this->render('affichage/index.html.twig', [
    //         'controller_name' => 'AffichageController',
    //     ]);
    // }
     
    #[Route('/salle/{sall}', name: 'app_affichage')]
    public function salle(Request $request,$sall): Response
    {

        
        $salle= $this->em->getRepository(PSalles::class)->findOneBy(["abreviation" => $sall]);
        $seance = $this->em->getRepository(PlEmptime::class)->getEmptimeByCurrentDayAndSalle($salle->getId());
        // dd($salle, $seance[0]->getId());
        if($seance){
         $salle="SELECT xabs.* FROM xseance_absences xabs
         where xabs.id_séance = '".$seance[0]->getId()."';";
         $stmt = $this->emAssiduite->getConnection()->prepare($salle);
         $stmt = $stmt->executeQuery();    
         $sean = $stmt->fetchAll();
        }else{
            $sean = "";
        }

         
    // $salle= $this->em->getRepository(PSalles::class)->findOneBy(["abreviation" => $sall]);

        
    //     $seance = $this->em->getRepository(PlEmptime::class)->getEmptimeByCurrentDayAndSalle($salle->getId());
    //     // dd($salle, $seance[0]->getId());
    //     if($seance){
    //         if($salle->getEtatPC() == 1){
    //             $abs="SELECT xabs.* FROM xseance_absences xabs
    //             where xabs.id_séance = '".$seance[0]->getId()."';";
    //             $stmt = $this->emAssiduite->getConnection()->prepare($abs);
    //             $stmt = $stmt->executeQuery();    
    //             $sean = $stmt->fetchAll();

    //             if($sean == null){
    //                 $salle->setEtatPC(0);
    //                 $this->em->flush();
    //             }  
    //         }
    //     }else{
    //         $sean = "";
    //     }


    return $this->render('affichage/salle.html.twig', [
        "salle" =>$sean,
     
    ]); 
    }
}
