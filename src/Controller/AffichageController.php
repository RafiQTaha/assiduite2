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
     
    #[Route('/salle/{sall}', name: 'app_affichage')]
    public function salle(Request $request,$sall): Response
    {
        
        $Today= new \DateTime(); 
        // Adjust to Greenwich Mean Time (GMT) or UTC+1
        $Today->modify('+1 hour');
        
        
        $salle= $this->em->getRepository(PSalles::class)->findOneBy(["abreviation" => $sall]);
        
        
        $seance = $this->em->getRepository(PlEmptime::class)->getEmptimeByCurrentDayAndSalle($salle->getId());
        // dd($seance);
        // dd($Today,$Today >= $seance[0]->getStart(),$seance[0]->getStart() , $Today <= $seance[0]->getEnd() ,$seance[0]->getEnd());
        if($Today >= $seance[0]->getStart() && $Today <= $seance[0]->getEnd()){
            $salle->setEtatPC(1);
            $this->em->flush();
        }else{
            $salle->setEtatPC(0);
            $this->em->flush();
        }
        if($seance){
            if($salle->getEtatPC() == 1){
                $abs="SELECT xabs.* FROM xseance_absences xabs
                where xabs.id_séance = '".$seance[0]->getId()."';";
                $stmt = $this->emAssiduite->getConnection()->prepare($abs);
                $stmt = $stmt->executeQuery();    
                $sean = $stmt->fetchAll();

                 
            }else{
                $sean = "";
            }
        }else{
            $sean = "";
        }


    return $this->render('affichage/index.html.twig', [
        "salle" =>$sean,
     
    ]); 
    }

    #[Route('/salleresi', name: 'app_affichage_resi')]
    public function salleresi(Request $request): Response
    {
        $hour = date(' H:i:s');
        $date = date('Y-m-d');
        $dates = date('Y-m-d', strtotime('-1 day', strtotime($date)));
    
        $admission = "'ADM-FMA_ORL00003355',
        'ADM-FMA_OPH00003354',
        'ADM-FMA_CAR00004432',
        'ADM-FMA_DRM00005039',
        'ADM-FMA_CAR00004431',
        'ADM-FMA_MEI00005042',
        'ADM-FMA_DRM00004436',
        'ADM-FMA_ONC00003477',
        'ADM-FMA_RUM00004437',
        'ADM-FMA_TOR00004434',
        'ADM-FMA_NC00004442',
        'ADM-FMA_URL00004435',
        'ADM-FMA_CAR00006114',
        'ADM-FMA_PD00006115',
        'ADM-FMA_NP00006116',
        'ADM-FMA_ONC00006117',
        'ADM-FMA_URL00006119',
        'ADM-FMA_OPH00006120',
        'ADM-FMA_RAD00006122',
        'ADM-FMA_CAR00006124',
        'ADM-FMA_GS00006125',
        'ADM-FMA_BM00006126',
        'ADM-FPA_BC00006128',
        'ADM-FMA_NRO00006129',
        'ADM-FMA_RTH00006130',
        'ADM-FMA_RTH00006134',
        'ADM-FMA_RAD00006131',
        'ADM-FMA_NP00006142',
        'ADM-FMA_RAD00006135',
        'ADM-FMA_ORL00006133',
        'ADM-FMA_PD00006137',
        'ADM-FMA_BM00006139',
        'ADM-FMA_RAD00006138',
        'ADM-FMA_RTH00007269',
        'ADM-FMA_RAD00007193',
        'ADM-FMA_HEC00007263',
        'ADM-FMA_RAD00007220',
        'ADM-FMA_RTH00007270',
        'ADM-FMA_CAR00007214',
        'ADM-FMA_OPH00007189',
        'ADM-FMA_NP00007221',
        'ADM-FMA_DRM00007200',
        'ADM-FMA_BM00007222',
        'ADM-FMA_ONC00007196',
        'ADM-FPA_BC00007210',
        'ADM-FMA_OPH00007272',
        'ADM-FPA_BC00007211',
        'ADM-FMA_REA00007225',
        'ADM-FMA_OPH00007194',
        'ADM-FMA_CCV00007207',
        'ADM-FMA_CAR00007190',
        'ADM-FMA_GS00007226',
        'ADM-FMA_NP00007275',
        'ADM-FMA_RAD00007273',
        'ADM-FMA_ORL00007274',
        'ADM-FMA_REA00007051',
        'ADM-FMA_CAR00007195',
        'ADM-FMA_NRO00007218',
        'ADM-FMA_TOR00007045',
        'ADM-FMA_BM00007233',
        'ADM-FMA_PN00007228',
        'ADM-FMA_RTH00007206',
        'ADM-FMA_BM00007234',
        'ADM-FMA_DRM00007050',
        'ADM-FMA_NC00007105',
        'ADM-FMA_ONC00007264',
        'ADM-FMA_HEC00007049',
        'ADM-FMA_CAR00007202',
        'ADM-FMA_CV00007046',
        'ADM-FMA_ORL00007192',
        'ADM-FMA_PN00007048',
        'ADM-FMA_GO00007208',
        'ADM-FMA_NP00007230',
        'ADM-FMA_BM00007232',
        'ADM-FMA_CCV00007047',
        'ADM-FMA_FMA00002115',
        'ADM-FMA_FMA00001584',
        'ADM-FMA_FMA00001743',
        'ADM-FMA_FMA00001781',
        'ADM-FMA_FMA00001973',
        'ADM-FMA_FMA00001615',
        'ADM-FMA_FMA00001651',
        'ADM-FMA_FMA00002101',
        'ADM-FMA_FMA00001582',
        'ADM-FMA_FMA00001597',
        'ADM-FMA_FMA00001655',
        'ADM-FMA_FMA00001640',
        'ADM-FMA_FMA00002059',
        'ADM-FMA_FMA00001702',
        'ADM-FMA_FMA00001583',
        'ADM-FMA_FMA00001641',
        'ADM-FMA_FMA00001628',
        'ADM-FMA_MG00000096',
        'ADM-FMA_FMA00001670',
        'ADM-FMA_FMA00001998',
        'ADM-FMA_FMA00001818',
        'ADM-FMA_FMA00001842',
        'ADM-FMA_FMA00001999',
        'ADM-FMA_FMA00002131',
        'ADM-FMA_MG00000620',
        'ADM-FMA_FMA00001677',
        'ADM-FMA_FMA00001671',
        'ADM-FMA_FMA00001620',
        'ADM-FMA_MG00002804',
        'ADM-FMA_MG00002829',
        'ADM-FMA_MG00002843',
        'ADM-FMA_MG00002937',
        'ADM-FMA_FMA00001881',
        'ADM-FMA_MG00002827',
        'ADM-FMA_MG00002862',
        'ADM-FMA_MG00002910',
        'ADM-FMA_MG00002939',
        'ADM-FMA_MG00002850',
        'ADM-FMA_MG00002895',
        'ADM-FMA_MG00002918',
        'ADM-FMA_MG00002857',
        'ADM-FMA_MG00002888',
        'ADM-FMA_MG00002858',
        'ADM-FMA_MG00002931',
        'ADM-FMA_MG00002878',
        'ADM-FMA_FMA00001685',
        'ADM-FMA_MG00002841',
        'ADM-FMA_MG00002891',
        'ADM-FMA_FMA00001690',
        'ADM-FMA_FMA00001629',
        'ADM-FMA_MG00002825',
        'ADM-FMA_MG00002807',
        'ADM-FMA_MG00000203',
        'ADM-FMA_MG00003055',
        'ADM-FMA_MG00002926',
        'ADM-FMA_MG00002922',
        'ADM-FMA_MG0002881',
        'ADM-FMA_MG00002853',
        'ADM-FPA_FPA00001614',
        'ADM-FPA_FPA00001684',
        'ADM-FPA_FPA00001776',
        'ADM-FPA_FPA00001770',
        'ADM-FPA_FPA00001697',
        'ADM-FPA_FPA00001800',
        'ADM-FPA_PH00002685',
        'ADM-FPA_PH00002683',
        'ADM-FPA_PH00002689',
        'ADM-FPA_PH00002733',
        'ADM-FPA_PH00002692',
        'ADM-FPA_PH00002716',
        'ADM-FMDA_MD00003148',
        'ADM-FDA_FDA00002795',
        'ADM-FDA_FDA00002771',
        'ADM-FDA_FDA00002781',
        'ADM-FDA_FDA00002777'";
    
        $myArray="'x',";
            
            $requete="SELECT DISTINCT userinfo.name,userinfo.street,
            date_format(checkinout.checktime,'%Y-%m-%d') as Dat,min(date_format(checkinout.checktime,'%H:%i')) as HEUREDEPOINTAGEMINIMAL,max(date_format(checkinout.checktime,'%H:%i')) as HEUREDEPOINTAGEMaximal 
            from userinfo
            left join checkinout on checkinout.userid = userinfo.userid
            WHERE userinfo.street in ($admission)  AND CHECKTIME>='$dates 06:00:00' AND CHECKTIME<='$dates 23:59:00' GROUP BY street order by name";
            // dd($salle);
            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $sean = $newstmt->fetchAll();
            foreach($sean as $l){
                $myArray.="'".$l["street"]."',";
            }
            $salle2="SELECT DISTINCT userinfo.name,userinfo.street,
            date_format(checkinout.checktime,'%Y-%m-%d') as Dat,min(date_format(checkinout.checktime,'%H:%i')) as HEUREDEPOINTAGEMINIMAL,max(date_format(checkinout.checktime,'%H:%i')) as HEUREDEPOINTAGEMaximal 
            from userinfo
            left join checkinout on checkinout.userid = userinfo.userid
            WHERE userinfo.street in ($admission) and userinfo.street not in (".substr($myArray,0,-1).")
            order by name";
            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $sean2 = $newstmt->fetchAll();

            // dd($sean2);

        return $this->render('affichage/indexresi.html.twig', [
        "salle" =>$sean,
     
        ]); 
    }
}
