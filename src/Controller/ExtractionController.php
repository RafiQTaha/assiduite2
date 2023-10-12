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

class ExtractionController extends AbstractController
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
    #[Route('/extraction', name: 'app_extraction')]
    public function index(): Response
    {
        return $this->render('extraction/index.html.twig', [
            'controller_name' => 'ExtractionController',
        ]);
    }

    #[Route('/extraction/extractionGlobal/{db}/{fin}', name: 'extractionGlobal')]
    public function extractionGlobal($db, $fin): Response
    {
        // dd($db, $fin);

            
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
        where date(pl.start) >= '$db' and date(pl.start) <= '$fin' and frm.designation not like 'Résidanat%' and etab.id != 25 and nat.absence = 1 AND (xseance.Annulée=0 or xseance.Annulée is NULL ) and pl.active = 1  order by seance_id ASC";


// dd($requete);
        $stmt = $this->em->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $seances = $newstmt->fetchAll();

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
