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

#[Route('/assiduite/pointage')]
class SituationPointageController extends AbstractController
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
    #[Route('/', name: 'app_situation_pointage')]
    public function index(): Response
    {
        return $this->render('situation_pointage/index.html.twig', [
            'etablissements' => $this->em->getRepository(AcEtablissement::class)->findBy(['active' => 1]),
            'controller_name' => 'SituationPointageController',
        ]);
    }

    #[Route('/search', name: 'search_situation_pointage')]
    public function search(Request $request)
    {
        // dd($request);
        $id_etudiant = $request->request->get('id_etudiant');
        $date_debut = $request->request->get('date_debut');
        $date_fin = $request->request->get('date_fin');

        // dd($id_etudiant);

        $inscription = $this->em->getRepository(TInscription::class)->find($id_etudiant);

        // dd($inscription);
 
        $requete = "SELECT userinfo.street as street, userinfo.name as name, checkinout.checktime as checktime, psalles.designation as salle, machines.ip as ip, machines.sn as sn FROM `checkinout` 
        INNER JOIN userinfo ON userinfo.userid=checkinout.userid
        INNER JOIN machines ON machines.sn=checkinout.sn
        INNER JOIN iseance_salle on iseance_salle.id_pointeuse = machines.sn
        INNER JOIN psalles on psalles.code = iseance_salle.code_salle
        WHERE checkinout.checktime BETWEEN '$date_debut' AND '$date_fin' AND userinfo.street ='".$inscription->getAdmission()->getCode()."'";
        $stmt = $this->emPointage->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $pointages = $newstmt->fetchAll();
        // dd($pointages);
        $html = $this->renderView('situation_pointage/tables/situation_pointage.html.twig', ['pointages' => $pointages]);

        return new JsonResponse(['html' => $html]);
    }
}
