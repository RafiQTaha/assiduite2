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

#[Route('/situation_presentiel')]
class SituationPresentielController extends AbstractController
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
    #[Route('/', name: 'app_situation_presentiel')]
    public function index(): Response
    {
        $annee = "2023/2024";
        $inscriptions = $this->em->getRepository(TInscription::class)->getActiveInscriptionByCurrentAnnee($annee);
        // dd($inscriptions);
        return $this->render('situation_presentiel/index.html.twig', [
            'etablissements' => $this->em->getRepository(AcEtablissement::class)->findBy(['active' => 1]),
            'inscriptions' => $inscriptions,
            'controller_name' => 'SituationPresentielController',
        ]);
    }

    #[Route('/imprimer/{ins}/{sem}', name: 'print_situation_pointage')]
    public function imprimer(Request $request, $ins, $sem)
    {

        // dd($ins,$sem);

        $inscription = $this->em->getRepository(TInscription::class)->find($ins);

        if($sem == "global"){
            $filter = " and 1=1";
        }else{
            $filter = " and sem.id = $sem";
        }

        // dd($inscription);
 
        $requete = "SELECT pl.id as seance_id, nat.abreviation as type, mdl.designation as module, ele.designation as element, pl.start as date_seance, pl.heur_db, pl.heur_fin , semaine.id as semaine_id, semaine.date_debut as sem_debut, semaine.date_fin as sem_fin, time_to_sec(timediff(pl.heur_fin,  
        pl.heur_db )) / 3600 as volume FROM `pl_emptime` pl
        INNER JOIN pr_programmation prog on prog.id = pl.programmation_id
        INNER JOIN pnature_epreuve nat on nat.id = prog.nature_epreuve_id
        INNER JOIN ac_element ele on ele.id = prog.element_id
        INNER JOIN ac_module mdl on mdl.id = ele.module_id
        INNER JOIN ac_semestre sem on sem.id = mdl.semestre_id
        INNER JOIN ac_promotion prm on prm.id = sem.promotion_id
        INNER JOIN semaine semaine on semaine.id = pl.semaine_id
        
        where prm.id = ".$inscription->getPromotion()->getId()." $filter;";

        // dd($requete);
        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $seances = $newstmt->fetchAll();
        // dd($seances);
        $html = $this->renderView('situation_presentiel/pdfs/feuil.html.twig', ['seances' => $seances, 'inscription' => $inscription]);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_right' => 1,
            'margin_left' => 1,
            'margin_top' => 1,
            'margin_bottom' => 1,
        ]);            
        // $mpdf->showImageErrors = true;
        $mpdf->SetTitle('Feuil');
        $mpdf->showImageErrors = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output('fueil' , 'I');
        // return new JsonResponse(['html' => $html]);
    }
    public function getCategorie($adm, $seance)
    {
        $requete="SELECT xabs.categorie_f
        FROM xseance_absences xabs
        WHERE xabs.id_admission='$adm' AND xabs.id_séance='$seance'";
        // dd($requete);
        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $cats = $newstmt->fetchAll();
        // dd($cats);
        if($cats){
            return new Response($cats[0], 200, ['Content-Type' => 'text/html']);
        }else{
            return new Response("-", 200, ['Content-Type' => 'text/html']);
        }
    }
}