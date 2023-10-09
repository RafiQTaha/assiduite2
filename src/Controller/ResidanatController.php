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

class ResidanatController extends AbstractController
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
    #[Route('/residanat/extraction', name: 'app_residanat')]
    public function index(): Response
    {
        $hour = date(' H:i:s');
        $date = date('Y-m-d');
        $dates = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $badgenumber = "1858,
        1907,
        1838,
        1943,
        8447,
        8448,
        8716,
        8692,
        8907,
        8688,
        5225,
        5220,
        8425,
        8449,
        8675,
        8705,
        8724,
        8685,
        8651,
        8681,
        8648,
        4855,
        4499,
        8645,
        8741,
        1070,
        1100,
        1034,
        1077,
        1053,
        1161,
        1113,
        1124,
        1081,
        1105,
        1059,
        1078,
        1123,
        1154,
        1149,
        1093,
        1122,
        1095,
        1041,
        1045,
        1133,
        1138,
        1047,
        1048,
        1130,
        1433,
        1390,
        1259,
        1449,
        1452,
        8693,
        8796,
        8735,
        8649,
        8763,
        5139,
        514,
        378,
        113,
        1636,
        1607,
        1493,
        1520,
        1570,
        1590,
        1649,
        1530,
        1539,
        1580,
        1492,
        1655,
        1509,
        1638,
        1559,
        1504,
        1538,
        2514,
        1561,
        1503,
        1604,
        1557,
        1629,
        2505,
        5101,
        9284,
        8429,
        8441,
        8748,
        8750,
        8707,
        8432,
        8710,
        2547,
        8438,
        8691,
        8764,
        2541,
        8436,
        8680,
        8728,
        8719,
        2548,
        8423,
        8677,
        8704,
        8440,
        8439,
        8647,
        8686,
        8431,
        8428,
        8430,
        8437,
        8698,
        8696,
        8720,
        9285,
        8738,
        8434,
        8435,
        8739,
        8706,
        8726,
        4854,
        5189,
        8650,
        5221,
        8426,
        2249,
        8422,
        8718,
        8712,
        1293,
        1245,
        1255,
        1243,
        1248,
        1289,
        2195,
        2255,
        2113,
        2254,
        2074,
        2120";
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
            
        // $requete="SELECT DISTINCT userinfo.name,userinfo.street,checkinout.checktime,
        // date_format(checkinout.checktime,'%Y-%m-%d') as Dat,min(date_format(checkinout.checktime,'%H:%i')) as HEUREDEPOINTAGEMINIMAL,max(date_format(checkinout.checktime,'%H:%i')) as HEUREDEPOINTAGEMaximal 
        // from userinfo
        // left join checkinout on checkinout.userid = userinfo.userid
        // WHERE userinfo.street in ($admission)  AND checktime>='$dates 06:00:00' AND checktime<='$dates 23:59:00' GROUP BY street order by name";
        // // dd($salle);
        // $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        // $newstmt = $stmt->executeQuery();   
        // $sean = $newstmt->fetchAll();
        // foreach($sean as $l){
        //     $myArray.="'".$l['street']."',";
        // }
        // $requete="SELECT DISTINCT userinfo.name,userinfo.street,date_format(checkinout.checktime,'%Y-%m-%d') as Dat,min(date_format(checkinout.checktime,'%H:%i')) as HEUREDEPOINTAGEMINIMAL,max(date_format(checkinout.checktime,'%H:%i')) as HEUREDEPOINTAGEMaximal
        // from userinfo
        // left join checkinout on checkinout.userid = userinfo.userid
        // WHERE userinfo.street in ($admission) and checkinout.checktime between '2023-09-25' and '2023-10-02' 
        // order by name";
        $requete="SELECT DISTINCT userinfo.name,userinfo.street,userinfo.badgenumber
        from userinfo
        WHERE userinfo.street in ($admission) order by name";
        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $userinfo = $newstmt->fetchAll();
        // dd($requete);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ADMISSION');
        $sheet->setCellValue('B1', 'NOM');
        $sheet->setCellValue('C1', 'date');
        $sheet->setCellValue('D1', 'HEUREDEPOINTAGEMINIMAL');
        $sheet->setCellValue('E1', 'HEUREDEPOINTAGEMaximal');

        $i=2;
        $count = 1 ;
        foreach ($userinfo as $sn) {

            $requete="SELECT
                c1.Dat,
                c1.checktime AS min_pointage,
                c2.checktime AS max_pointage
            FROM
                (
                    SELECT DATE_FORMAT(checktime, '%Y-%m-%d') AS Dat, MIN(TIME_FORMAT(checktime, '%H:%i:%s')) AS checktime
                    FROM checkinout
                    WHERE userid = ".$sn["badgenumber"]."
                    AND checktime BETWEEN '2023-10-02' AND '2023-10-06'
                    GROUP BY Dat
                ) c1
            LEFT JOIN
                (
                    SELECT DATE_FORMAT(checktime, '%Y-%m-%d') AS Dat, MAX(TIME_FORMAT(checktime, '%H:%i:%s')) AS checktime
                    FROM checkinout
                    WHERE userid = ".$sn["badgenumber"]."
                    AND checktime BETWEEN '2023-10-02' AND '2023-10-06'
                    GROUP BY Dat
                ) c2
            ON c1.Dat = c2.Dat;";
            // dd($requete);
            $stmt = $this->emPointage->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $pointage = $newstmt->fetchAll();

            foreach($pointage as $p){
                
                $sheet->setCellValue('A'.$i, $sn["street"]);
                $sheet->setCellValue('B'.$i, $sn["name"]);
                
                // dd($pointage);
                $sheet->setCellValue('C'.$i, ($p["Dat"]));
                $sheet->setCellValue('D'.$i, $p["min_pointage"]);
                $sheet->setCellValue('E'.$i, $p["max_pointage"]);

                $i++;
            }
            
            
        }

            
        $this->em->flush();
        $fileName = null;
        $writer = new Xlsx($spreadsheet);
        $fileName = 'extraction_residanat.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
        
        // return $this->render('residanat/index.html.twig', [
        //     'etablissements' => $this->em->getRepository(AcEtablissement::class)->findBy(['active' => 1]),
        //     'controller_name' => 'ResidanatController',
        // ]);
    }

    
    #[Route('/assiduite/extractionGlobal', name: 'extractionGlobal')]
    public function extractionGlobal(): Response
    {
        // dd('test');
        // $hour = date(' H:i:s');
        // $date = date('Y-m-d');
        // $dates = date('Y-m-d', strtotime('-1 day', strtotime($date)));
    
        // $admission = "'ADM-FMA_ORL00003355'";
        // $myArray="'x',";
            
        $requete="SELECT pl.id as seance_id,nat.abreviation as type,date(pl.start) as date_seance,date(pl.start) as date_seance, mdl.code as c_module, mdl.designation as module,ele.code as c_element,
        pl.heur_db, pl.heur_fin , semaine.id as semaine_id, semaine.date_debut as sem_debut,etab.designation as etab,frm.designation as formation,prm.designation as promotion
        FROM `pl_emptime` pl
        INNER JOIN pr_programmation prog on prog.id = pl.programmation_id
        INNER JOIN pnature_epreuve nat on nat.id = prog.nature_epreuve_id
        INNER JOIN ac_element ele on ele.id = prog.element_id
        INNER JOIN ac_module mdl on mdl.id = ele.module_id
        INNER JOIN ac_semestre sem on sem.id = mdl.semestre_id
        INNER JOIN ac_promotion prm on prm.id = sem.promotion_id
        INNER JOIN semaine semaine on semaine.id = pl.semaine_id
        inner join ac_annee ann on ann.id = prog.annee_id
        inner join ac_formation frm on frm.id = ann.formation_id
        inner join ac_etablissement etab on etab.id = frm.etablissement_id
        INNER JOIN xseance ON xseance.ID_Séance=pl.id 
        where date(pl.start) >= '2023-09-11' and date(pl.start) <= '2023-10-03' and frm.designation not like 'Résidanat%' and etab.id != 25 and nat.absence = 1 AND (xseance.Annulée=0 or xseance.Annulée is NULL ) and pl.active = 1  order by seance_id ASC";


        $stmt = $this->em->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $seances = $newstmt->fetchAll();

        // dd($seances);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ADMISSION');
        $sheet->setCellValue('B1', 'NOM');
        $sheet->setCellValue('C1', 'Prenom');
        $sheet->setCellValue('D1', 'Id Seance');
        $sheet->setCellValue('E1', 'Type');
        $sheet->setCellValue('F1', 'Date Seance');
        $sheet->setCellValue('G1', 'H-Pointage');
        $sheet->setCellValue('H1', 'Categorie');
        $sheet->setCellValue('I1', 'Categorie Si');
        $sheet->setCellValue('J1', 'HD');
        $sheet->setCellValue('K1', 'HF');
        $sheet->setCellValue('L1', 'Etablissement');
        $sheet->setCellValue('M1', 'Formation');
        $sheet->setCellValue('N1', 'Promotion');
        $sheet->setCellValue('O1', 'Module');
        // $sheet->setCellValue('P1', 'Code Module');
        // $sheet->setCellValue('Q1', 'Code Element');
        
        $i=2;
        $count = 1;
        foreach ($seances as $seance) {
            $requete="SELECT * FROM `xseance_absences` where active = 1 and id_séance =".$seance['seance_id'];
            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $xseances = $newstmt->fetchAll();
            if ($xseances) {
                // dd($xseances);
                foreach ($xseances as $xseance) {
                    $sheet->setCellValue('A'.$i, $xseance["id_admission"]);
                    $sheet->setCellValue('B'.$i, $xseance["nom"]);
                    $sheet->setCellValue('C'.$i, $xseance["prénom"]);
                    $sheet->setCellValue('D'.$i, $xseance["id_séance"]);
                    $sheet->setCellValue('E'.$i, $seance["type"]);
                    $sheet->setCellValue('F'.$i, $seance["date_seance"]);
                    $sheet->setCellValue('G'.$i, $xseance["heure_pointage"]);
                    $sheet->setCellValue('H'.$i, $xseance["categorie"]);
                    $sheet->setCellValue('I'.$i, $xseance["categorie_si"]);
                    $sheet->setCellValue('J'.$i, $seance["heur_db"]);
                    $sheet->setCellValue('K'.$i, $seance["heur_fin"]);
                    $sheet->setCellValue('L'.$i, $seance["etab"]);
                    $sheet->setCellValue('M'.$i, $seance["formation"]);
                    $sheet->setCellValue('N'.$i, $seance["promotion"]);
                    $sheet->setCellValue('O'.$i, $seance["module"]);
                    // $sheet->setCellValue('P'.$i, $seance["c_module"]);
                    // $sheet->setCellValue('Q'.$i, $seance["c_element"]);
                    $i++;
                }
            }
        }
        // dd($xseances);
        $fileName = null;
        $writer = new Xlsx($spreadsheet);
        $fileName = 'extraction_Global.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
        
        // return $this->render('residanat/index.html.twig', [
        //     'etablissements' => $this->em->getRepository(AcEtablissement::class)->findBy(['active' => 1]),
        //     'controller_name' => 'ResidanatController',
        // ]);
    }
}
