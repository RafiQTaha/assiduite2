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
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;


class RegularisationController extends AbstractController
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

    #[Route('/regularisation', name: 'app_regularisation')]
    public function index(): Response
    {
        return $this->render('regularisation/index.html.twig', [
            'controller_name' => 'RegularisationController',
        ]);
    }

    #[Route('/canvas', name: 'regul_canvas')]
    public function regulCanvas() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'id_admission');
        $sheet->setCellValue('B1', 'nom');
        $sheet->setCellValue('C1', 'prenom');
        $sheet->setCellValue('D1', 'etablissement');
        $sheet->setCellValue('E1', 'formation');
        $sheet->setCellValue('F1', 'promotion');
        $sheet->setCellValue('G1', 'heur_debut');
        $sheet->setCellValue('H1', 'id_seance');
        $sheet->setCellValue('I1', 'date_seance');
        $sheet->setCellValue('J1', 'heur_pointage');
        $sheet->setCellValue('K1', 'categorie');
        $sheet->setCellValue('L1', 'categorie_enseignant');
        $sheet->setCellValue('M1', 'observation');
        $sheet->setCellValue('N1', 'decision');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'canvas_regularisation.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/canvas_date', name: 'regul_date_canvas')]
    public function regulDateCanvas() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'id_admission');
        $sheet->setCellValue('B1', 'nom');
        $sheet->setCellValue('C1', 'prenom');
        $sheet->setCellValue('D1', 'etablissement');
        $sheet->setCellValue('E1', 'formation');
        $sheet->setCellValue('F1', 'promotion');
        $sheet->setCellValue('G1', 'date_debut');
        $sheet->setCellValue('H1', 'date_fin');
        $sheet->setCellValue('I1', 'categorie');
        $sheet->setCellValue('J1', 'categorie_enseignant');
        $sheet->setCellValue('K1', 'observation');
        $sheet->setCellValue('L1', 'decision');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'canvas_regularisation_date.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/regularisation_seance', name: 'assiduite_assiduites_regularisation_seance', methods: ['POST'])]
    public function regularisation_seance(Request $request, SluggerInterface $slugger): JsonResponse
    {
        // dd("regul seance");
        $file = $request->files->get('file');
        

        if(!$file) {
            return new JsonResponse(['message' => 'No file uploaded.'], JsonResponse::HTTP_BAD_REQUEST);
        }

            $uploadDirectory = $this->getParameter('regularisation'); // Get the configured upload directory

            $now = new DateTime();
            $formattedDate = $now->format('Y-m-d'); // Format date as "YYYY-MM-DD"
            $formattedTime = $now->format('H-i-s'); // Format time as "HH-MM-SS"
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFileName = $safeFilename . '_' . $formattedDate . '_' . $formattedTime . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            $file->move(
                $uploadDirectory,
                $newFileName
            );
    



        $xlsx = new XlsxReader;
        $xlsx->setLoadSheetsOnly(["Feuil1", $file]);
        // $spreadsheet = $xlsx->load($file);
        $reader = new XlsxReader();
        $spreadsheet = $reader->load($this->getParameter('regularisation').'/'.$newFileName);
        $row = $spreadsheet->getActiveSheet()->removeRow(1);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        // dd($sheetData);
        $TodayDate= new \DateTime();
        $date= date_format($TodayDate, 'Y-m-d');
        $dat= date_format($TodayDate, 'Y-m-d H:i');
        // dd($sheetData);
            foreach($sheetData as $sheet) {
         
              
                $insert='UPDATE xseance_absences SET categorie_f="'.$sheet[10].'", categorie_enseig="'.$sheet[11].'",obs="'.$sheet[12].'" 
                WHERE `id_admission`="'.$sheet[0].'" AND `id_séance`="'.$sheet[7].'"';
                
                // dd($insert);
                // $execute =  self::execute($insert,$this->em);
                $stmt = $this->emAssiduite->getConnection()->prepare($insert);
                $newstmt = $stmt->executeQuery();   


            }

            return new JsonResponse(['message' => 'Regularisation est bien fait.'], JsonResponse::HTTP_OK);
      
    }

    #[Route('/regularisation_date', name: 'assiduite_assiduites_regularisation_excel' , methods: ['POST'])]
    public function regularisation_date(Request $request, SluggerInterface $slugger): JsonResponse
    {
        // dd("regul date");
        $file = $request->files->get('file');
        

        if(!$file) {
            return new JsonResponse(['message' => 'No file uploaded.'], JsonResponse::HTTP_BAD_REQUEST);
        }

            $uploadDirectory = $this->getParameter('regularisation'); // Get the configured upload directory

            $now = new DateTime();
            $formattedDate = $now->format('Y-m-d'); // Format date as "YYYY-MM-DD"
            $formattedTime = $now->format('H-i-s'); // Format time as "HH-MM-SS"
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFileName = $safeFilename . '_' . $formattedDate . '_' . $formattedTime . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            $file->move(
                $uploadDirectory,
                $newFileName
            );



        $xlsx = new XlsxReader;
        $xlsx->setLoadSheetsOnly(["Feuil1", $file]);
        // $spreadsheet = $xlsx->load($file);
        $reader = new XlsxReader();
        $spreadsheet = $reader->load($this->getParameter('regularisation').'/'.$newFileName);
        $row = $spreadsheet->getActiveSheet()->removeRow(1);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        // dd($sheetData);
        $TodayDate= new \DateTime();
        $date= date_format($TodayDate, 'Y-m-d');
        $dat= date_format($TodayDate, 'Y-m-d H:i');
            foreach($sheetData as $sheet) {
                $insert='UPDATE `xseance_absences`
                INNER JOIN xseance  ON xseance.ID_Séance=xseance_absences.ID_Séance
                SET `Categorie_f`="'.$sheet[8].'",`Categorie_Enseig`="'.$sheet[9].'",`Obs`="'.$sheet[10].'" 
                
                WHERE xseance_absences.ID_Admission="'.$sheet[0].'" AND  xseance.Date_Séance >= "'.$sheet[6].'" AND xseance.Date_Séance <=  "'.$sheet[7].'"' ;
                // dd($insert);
                // $execute =  self::execute($insert,$this->em);
                $stmt = $this->emAssiduite->getConnection()->prepare($insert);
                $newstmt = $stmt->executeQuery();   


              
          

            }

            return new JsonResponse(['message' => 'Regularisation est bien fait.'], JsonResponse::HTTP_OK);
      
    }
}
