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

// use ZKLibrary;


// require '../zklibrary.php';

// require '../ZKLib.php';

// require '../ZK/Nouveau dossier/zklibrary.php';


// require __DIR__ . '../../../vendor/autoload.php';

#[Route('/assiduite/traitement')]
class TraitementController extends AbstractController
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
    #[Route('/', name: 'traitement')]
    public function index(Request $request)
    {
        // $operations = ApiController::check($this->getUser(), 'traitement', $this->em, $request);
        // if(!$operations) {
        //     return $this->render("errors/403.html.twig");
        // }
        // return $this->render('parametre/element/index.html.twig', [
        return $this->render('traitement/index.html.twig', [
            'etablissements' => $this->em->getRepository(AcEtablissement::class)->findBy(['active' => 1]),
            'salles' => $this->em->getRepository(PSalles::class)->findAll(),
            // 'natures' => $this->em->getRepository(TypeElement::class)->findAll(),
            // 'operations' => $operations
        ]);
    }
    #[Route('/list', name: 'assiduite_list')]
    public function list(Request $request)
    {
        $params = $request->query;
        // dd($params);
        $where = $totalRows = $sqlRequest = "";
        // $filtre = "where 1 = 1 and elm.active = 1";   
        $filtre = " where 1 = 1 ";   
        // $filtre = "where 1 = 1 ";   
        // dd($params->all('columns')[0]['search']['value']);
        if (!empty($params->all('columns')[0]['search']['value'])) {
            $filtre .= " and date(emp.start) = '" . $params->all('columns')[0]['search']['value'] . "' ";
        }else {
            $filtre .= " and date(emp.start) = '" . date('Y-m-j') . "' ";
        }
        if (!empty($params->all('columns')[1]['search']['value'])) {
            $filtre .= " and etab.id = '" . $params->all('columns')[1]['search']['value'] . "' ";
        }
        if (!empty($params->all('columns')[2]['search']['value'])) {
            $filtre .= " and form.id = '" . $params->all('columns')[2]['search']['value'] . "' ";
        }
        if (!empty($params->all('columns')[3]['search']['value'])) {
            $filtre .= " and prm.id = '" . $params->all('columns')[3]['search']['value'] . "' ";
        }
        

        // dd($filtre);
        $columns = array(
            array( 'db' => 'emp.id','dt' => 0),
            array( 'db' => 'nat.abreviation','dt' => 1),
            array( 'db' => 'UPPER(sall.designation)','dt' => 2),
            array( 'db' => 'elm.designation','dt' => 3),
            array( 'db' => 'CONCAT(ens.nom," ", ens.prenom)','dt' => 4),
            array( 'db' => 'emp.heur_db','dt' => 5),
            array( 'db' => 'emp.heur_fin','dt' => 6),
            array( 'db' => 'grp.niveau','dt' => 7),
            array( 'db' => 'xs.signé','dt' => 8),
            array( 'db' => 'xs.annulée','dt' => 9),
            array( 'db' => 'xs.existe','dt' => 10),
            array( 'db' => 'xs.statut','dt' => 11),
        );
        $sql = "SELECT " . implode(", ", DatatablesController::Pluck($columns, 'db')) . "
        from pl_emptime emp
        left join psalles sall on sall.id = emp.xsalle_id
        left join pgroupe grp on grp.id = emp.groupe_id
        inner join pl_emptimens empens on empens.seance_id = emp.id
        inner join penseignant ens on ens.id = empens.enseignant_id
        inner join pr_programmation prg on prg.id = emp.programmation_id
        inner join pnature_epreuve nat on nat.id = prg.nature_epreuve_id
        inner join ac_element elm on elm.id = prg.element_id
        inner join ac_module mdl on mdl.id = elm.module_id
        inner join ac_semestre sem on sem.id = mdl.semestre_id
        inner join ac_promotion prm on prm.id = sem.promotion_id
        inner join ac_formation form on form.id = prm.formation_id
        inner join ac_etablissement etab on etab.id = form.etablissement_id

        left join xseance xs on xs.id_séance = emp.id 

        $filtre group by emp.id ";
        // dd($sql);
        $totalRows .= $sql;
        $sqlRequest .= $sql;
        $stmt = $this->em->getConnection()->prepare($sql);
        $newstmt = $stmt->executeQuery();
        $totalRecords = count($newstmt->fetchAll());
        // dd($sql);
            
        // search 
        $where = DatatablesController::Search($request, $columns);
        if (isset($where) && $where != '') {
            $sqlRequest .= $where;
        }
        $sqlRequest .= DatatablesController::Order($request, $columns);
        // dd($sqlRequest);
        $stmt = $this->em->getConnection()->prepare($sqlRequest);
        $resultSet = $stmt->executeQuery();
        $result = $resultSet->fetchAll();
        
        
        $data = array();
        // dd($result);
        $i = 1;
        foreach ($result as $key => $row) {
            $nestedData = array();
            $cd = $row['id'];
            foreach (array_values($row) as $key => $value) {
                if ($key == 8) {
                    if ($value == "1") {
                        $value = "<i class='fas fa-check-circle'></i>";
                    }
                }
                if ($key == 9 ) {
                    if ($value == "1") {
                        $value = "<i class='fas fa-check-circle'></i>";
                    }
                }
                if ($key == 10 ) {
                    if ($value == "1") {
                        $value = "<i class='fas fa-check-circle'></i>";
                    }
                }
                $nestedData[] = $value;
            }
            $nestedData["DT_RowId"] = $cd;
            if($row["statut"] == 1 ){
                $nestedData["DT_RowClass"] = "green";
            }elseif($row["statut"] == 2 ){
                $nestedData["DT_RowClass"] = "red";
            }else{
                $nestedData["DT_RowClass"] = "";
            }

            $data[] = $nestedData;
            $i++;
        }
        // dd($data);
        $json_data = array(
            "draw" => intval($params->get('draw')),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data" => $data   
        );
        // die;
        return new Response(json_encode($json_data));
    }

    #[Route('/traiter/{emptime}/{type}', name: 'traiter')]
    public function traiter($emptime, $type)
    {
        $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance" => $emptime]);
        if($type == 2){ //!!retraitement
            if ($Xseance) {
                if ($Xseance->getStatut() == "2") {
                    return new JsonResponse(['error' => 'La séance est verouiller!'], 500);
                }
                if ($Xseance->getStatut() != "1") {
                    return new JsonResponse(['error' => 'La séance est pas encore traitée!'], 500);
                }
            }
        }else{
            if ($Xseance) {
                if ($Xseance->getStatut() == "1") {
                    return new JsonResponse(['error' => 'La séance est déja traitée!'], 500);
                }
                if ($Xseance->getStatut() == "2") {
                    return new JsonResponse(['error' => 'La séance est verouiller!'], 500);
                }
            }else{
                return new JsonResponse(['error' => 'no Xséance'], 500);
            }
        }

        $emptime = $this->em->getRepository(PlEmptime::class)->find($emptime);
        $id_seance = $emptime->getId();
        $element = $emptime->getProgrammation()->getElement();
        $promotion = $element->getModule()->getSemestre()->getPromotion();
        $salle = $emptime->getXsalle();
        $code_salle = $salle->getCode();

        $requete = "SELECT m.* FROM `machines` m INNER JOIN iseance_salle iss on iss.id_pointeuse = m.sn where iss.code_salle = '$code_salle'";

        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $pointeuses = $newstmt->fetchAll();
        // $sns = [];
        $sns ="";
        $dateSeance = $emptime->getStart()->format('Y-m-d');
        if (!$pointeuses) {
            dd($pointeuses);
        }
        // dd($pointeuses);
        foreach ($pointeuses as $machine) {
            $sn = $machine["sn"];
            $requete = "SELECT * FROM `checkinout` where sn = '$sn' and date(checktime) = '$dateSeance'";
            // dd($requete);

            $stmt = $this->emPointage->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $pointages = $newstmt->fetchAll();
            // dd($pointages);
            if ($pointages) {
                foreach ($pointages as $pointage) {
                    // $userInfo = $this->em->getRepository(Userinfo::class)->findOneBy(['Badgenumber'=>$attendace['id']]);

                    $id_checkinout = $pointage["id"];
                    $userid = $pointage["userid"];
                    $checktime = $pointage["checktime"];
                    $memoinfo = $pointage["memoinfo"];
                    $sn = $pointage["sn"];

                    //** checks if there is that checkinout in local database 'assiduite' **//
                    $requete = "SELECT * FROM `checkinout` where id = $id_checkinout LIMIT 1";

                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery();   
                    $checkinout = $newstmt->fetchAll();

                    // dd($requete);

                    if(!$checkinout){
                        $requete = "INSERT INTO `checkinout`(`id`,`userid`, `checktime`, `memoinfo`, `sn`) VALUES ('$id_checkinout','$userid','$checktime','$memoinfo','$sn')";

                        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                        $newstmt = $stmt->executeQuery();
                    }
                }
            }
            $sns .= "'$sn',";
            // array_push($sns,$sn);
        }
        $sn = rtrim($sns, ', ');
        // dd($sns);
        // dd("hi");

        $groupes = [];
        $annee = $this->em->getRepository(AcAnnee::class)->getActiveAnneeByFormation($promotion->getFormation());
        if($emptime->getGroupe()){
            $groupe = $emptime->getGroupe();
            array_push($groupes,$groupe);
                foreach ($groupe->getGroupes() as $groupe) {
                    if (!in_array($groupe, $groupes)){
                        array_push($groupes,$groupe);
                    }
                    foreach ($groupe->getGroupes() as $groupe) {
                        if (!in_array($groupe, $groupes)){
                            array_push($groupes,$groupe);
                        }
                    }
                }
            $inscriptions = $this->em->getRepository(TInscription::class)->getInscriptionsByAnneeAndPromoAndGroupe($promotion,$annee,$groupes);
        }else{
            $inscriptions = $this->em->getRepository(TInscription::class)->getInscriptionsByAnneeAndPromoNoGroup($promotion,$annee);
        }
        if (count($inscriptions) == 0) {
            die('Aucun Etudiant Trouver!!!');
        }
        $counter = 0;
        $ID_etablissement = $annee->getFormation()->getEtablissement()->getId();
        // $A = $ID_etablissement == 28 ? 20 : 15;
        if ($ID_etablissement == 28) {
            $A = 21;
            if ($emptime->getStart()->format('H:i') == '08:00') {
                $AA = -30;
            }else {
                $AA = -20;
            }
            $B = $A;
        }else{
            $A = 16;
            $AA = -15;
            $B = $A + 15;
        }
        $C = $B + 15;
        // $abcd = ['A'=>0,'B'=>0,'C'=>0,'D'=>0];
        $date = clone $emptime->getStart();
        $date->modify($AA.' min');
        $check_ = $date->format("Y-m-d H:i:s"); //!!!!!!!!!!!!!!!!!!!!!!!!!!
        // dd($inscriptions);
        // $update = "";
        // $insert = "";
        // foreach ($inscriptions as $inscription) {

        //     $id_admission = $inscription->getAdmission()->getCode();
        //     $id_module = $element->getModule()->getCode();
        //     $id_annee = $annee->getCode();
            
        //     $requete = "SELECT * FROM `userinfo` where street = '$id_admission' group by street LIMIT 1";
        //     // dd($requete);

        //     $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        //     $newstmt = $stmt->executeQuery();   
        //     $userInfo = $newstmt->fetchAll();
        //     if ($userInfo) {
        //         dd($inscriptions , $inscription);
        //     }
        // }
        // dd('hi');
        foreach ($inscriptions as $inscription) {
            // if ($inscription->getId() != 19117) {
            //     continue;
            // }
            // $capitaliseExist = $this->em->getRepository(XseanceCapitaliser::class)->findOneBy([
            //     'ID_Admission'=>$inscription->getAdmission()->getCode(),
            //     'ID_Module'=>$element->getModule()->getCode(),
            //     'ID_Année'=>$annee->getCode()]);

            $id_admission = $inscription->getAdmission()->getCode();
            $id_module = $element->getModule()->getCode();
            $id_annee = $annee->getCode();

            $requete = "SELECT * FROM `xseance_capitaliser` where id_admission = '$id_admission' and id_module = '$id_module' and id_année = '$id_annee' LIMIT 1";
            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $capitaliseExist = $newstmt->fetchAll();
            // dd($capitaliseExist);
            // $street = $inscription->getAdmission()->getCode();
            if (!$capitaliseExist) {
                $requete = "SELECT * FROM `userinfo` where street = '$id_admission' group by street LIMIT 1";

                $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                $newstmt = $stmt->executeQuery();   
                $userInfo = $newstmt->fetchAll();

                // dd($userInfo);
                // $userInfo = $this->em->getRepository(Userinfo::class)->findOneBy(['street'=>$inscription->getAdmission()->getCode()]);
                $checkinout = null;
                $cat = "D";
                // $sn = array_map(function($item) {
                //     return "'$item'";
                // }, $sns);
                // $sn = implode(',', $sn);
                // dd($sn);
                if ($userInfo) {
                    // dd($userInfo);
                    $userid = $userInfo[0]["userid"];
                    // $requete = "SELECT * FROM `checkinout` WHERE userid = '$userid' AND checktime like '$dateSeance%' AND sn in ($sn) ORDER BY checktime DESC";
                    $requete = "SELECT * FROM `checkinout` WHERE userid = '$userid' AND checktime >= '$check_' AND sn in ($sn) ORDER BY checktime ASC LIMIT 1";
                    
                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery();   
                    $checkinout = $newstmt->fetchAll();
                    // dd($checkinout);
                    // !!!!!!!!! here kat3tel + 3 sec
                    // $checkinout = $this->em->getRepository(Checkinout::class)->findOneBySNAndDateAndUserId($sns,$userInfo->getUSERID(),$date);
                }
                
                if ($checkinout) {
                    $checktime_ = new \DateTime($checkinout[0]["checktime"]);
                    $interval = ($checktime_->getTimestamp() - $emptime->getStart()->getTimestamp()) / 60;
                    
                    
                    if ($interval == 0) {
                        $cat = "A";
                    }elseif ($emptime->getStart() > $checktime_) {
                        if ($interval >= $AA) {
                            $cat = "A";
                        }else {
                            $cat = "D";
                        }
                    }elseif ($emptime->getStart() < $checktime_) {
                        if ($interval < $A) {
                            $cat = "A";
                        }elseif ($interval < $B) {
                            $cat = "B";
                        }elseif($interval < $C) {
                            $cat = "C";
                        }else {
                            $cat = "D";
                        }
                    }
                }
            }else {
                $cat = 'P';
            }
            // dd('hi');
            $requete = "SELECT * FROM `xseance_absences` where id_admission = '$id_admission' and id_séance = '$id_seance' and active = 1 LIMIT 1";
            // dd($requete);
            
            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $xAbseanceExist = $newstmt->fetchAll();
            // dd($xAbseanceExist[0]['id']);
            //!!!! + 1400
            
            // if ($id_admission == "ADM-FMA_MG00003760") {
            //     dd($xAbseanceExist,$cat,$type);
            // } 
            if($type == 2){ //!!retraitement

                
                $pointage = $checkinout != null ? (new \DateTime($checkinout[0]['checktime']))->format("H:i:s") : null;
                $categorie = $cat;

                $requete = "UPDATE `xseance_absences` SET `heure_pointage`='$pointage',`categorie_si`='$categorie',`categorie_f`='$categorie' WHERE `id` = ".$xAbseanceExist[0]['id'].";";
                // $requete = "UPDATE `xseance_absences` SET `heure_pointage`='$pointage',`categorie_si`='$categorie' WHERE `id_séance` = '$id_seance' AND `id_admission` = '$id_admission';";

                $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                $newstmt = $stmt->executeQuery(); 

                // $update .= $requete;

            }else{ //!!traitements
                if (!$xAbseanceExist) {
                    $nom = addslashes($inscription->getAdmission()->getPreinscription()->getEtudiant()->getNom());
                    $prenom = addslashes($inscription->getAdmission()->getPreinscription()->getEtudiant()->getPrenom());
                    $date = $checkinout != null ? $checkinout[0]["checktime"] : $emptime->getStart()->format('Y-m-d');
                    $pointage = $checkinout != null ? (new \DateTime($checkinout[0]['checktime']))->format("H:i:s") : null;
                    $categorie = $cat;
    
                    $requete = "INSERT INTO `xseance_absences`(`id_admission`, `id_séance`, `nom`, `prénom`, `date_pointage`, `heure_pointage`, `categorie`, `active`,`categorie_f`) VALUES ('$id_admission','$id_seance','$nom','$prenom','$date','$pointage','$categorie',1,'$categorie')";
                    // $requete = "('$id_admission','$id_seance','$nom','$prenom','$date','$pointage','$categorie'),";

                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery();
                    // $insert .= $requete;
    
                }else {

                    // $checkinout != null && dd($checkinout);
                    $pointage = $checkinout != null ? (new \DateTime($checkinout[0]['checktime']))->format("H:i:s") : null;
                    $categorie = $cat;
    
                    $requete = "UPDATE `xseance_absences` SET `heure_pointage`='$pointage',`categorie`='$categorie',`categorie_f`='$categorie',`active`=1 WHERE `id` = ".$xAbseanceExist[0]['id'].";";
                    // dd($requete);
                    // $requete = "UPDATE `xseance_absences` SET `heure_pointage`='$pointage',`categorie_si`='$categorie' WHERE `id_séance` = '$id_seance' AND `id_admission` = '$id_admission';";

                    // if ($id_admission == "ADM-FMA_MG00003760") {
                    //     dd($xAbseanceExist,$cat,$requete);
                    // } 
                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery();
                    // dd("hi"); + 1200
                    // $update .= $requete;
                }
            }
            // dd('hi');
            
            $counter++;
            // switch ($cat) {
            //     case 'A':
            //         $abcd['A']++;
            //         break;
            //     case 'B':
            //         $abcd['B']++;
            //         break;
            //     case 'C':
            //         $abcd['C']++;
            //         break;
            //     case 'D':
            //         $abcd['D']++;
            //         break;
            // }
        }
        // dd('testtt');
        // if($insert != ""){
        //     $insert_req = "INSERT INTO `xseance_absences`(`id_admission`, `id_séance`, `nom`, `prénom`, `date_pointage`, `heure_pointage`, `categorie`) VALUES ".$insert;
        //     $insert_req = rtrim($insert_req, ', ');
        //     // dd($update, $insert_req);
        //     $stmt = $this->emAssiduite->getConnection()->prepare($insert_req);
        //     $newstmt = $stmt->executeQuery(); 
        // }
        // if($update != ""){
        //     $stmt = $this->emAssiduite->getConnection()->prepare($update);
        //     $newstmt = $stmt->executeQuery(); 
        // }
        // dd("hi");
        // $this->em->flush();
        $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance"=> $id_seance]);
        if($Xseance){
            $Xseance->setStatut(1);
        }else{
            // dd($emptime->getId());
            // $programmation = $emptime->getProgrammation();
            $Xseance = new Xseance();
            $Xseance->setIDSéance($emptime->getId());
            $Xseance->setStatut(1);
            $Xseance->setDateSys(new \DateTime());
            $this->em->persist($Xseance);
            // $Xseance->setTypeséance($programmation->getNatureEpreuve()->getCode());
            // $Xseance->setIDEtablissement($programmation->getAnnee()->getFormation()->getEtablissement()->getCode())

            // $IDEtablissement=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getEtablissement()->getCode();
            // $IDFormation=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getCode();
            // $IDPromotion=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getCode();
            // $IDAnnée=$emptime->getProgrammation()->getAnnee()->getCode();     
            // $AnnéeLib=$emptime->getProgrammation()->getAnnee()->getDesignation();
            // $IDSemestre=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getCode();
            // $EmpGroupe= $emptime->getGroupe() ? $emptime->getGroupe()->getNiveau() : "";
            // $IDModule=$emptime->getProgrammation()->getElement()->getModule()->getCode();
            // $IDElement=$emptime->getProgrammation()->getElement()->getId();
            // $IDEnseignant=$emptime->getemptimens()[0]->getEnseignant()->getCode();
            // $IDSalle=strtoupper($emptime->getSalle()->getCode());
            // // $Xseance->setStatut(1);
            // $DateSéance=$emptime->getStart()->format("Y-m-d");
            // $EmpSemaine=$emptime->getSemaine()->getId();
            // $HeureDebut=$emptime->getHeurDb()->format("H:i");
            // $HeureFin=$emptime->getHeurFin()->format("H:i");
            // $DateSys=(new \DateTime())->format("Y-m-d");



            
            // $IDSéance = $emptime->getId();
            // $Typeséance=$emptime->getProgrammation()->getNatureEpreuve()->getCode();
            // $IDEtablissement=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getEtablissement()->getCode();
            // $IDFormation=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getCode();
            // $IDPromotion=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getCode();
            // $IDAnnée=$emptime->getProgrammation()->getAnnee()->getCode();     
            // $AnnéeLib=$emptime->getProgrammation()->getAnnee()->getDesignation();
            // $IDSemestre=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getCode();
            // $EmpGroupe= $emptime->getGroupe() ? $emptime->getGroupe()->getNiveau() : "";
            // $IDModule=$emptime->getProgrammation()->getElement()->getModule()->getCode();
            // $IDElement=$emptime->getProgrammation()->getElement()->getId();
            // $IDEnseignant=$emptime->getemptimens()[0]->getEnseignant()->getCode();
            // $IDSalle=strtoupper($emptime->getSalle()->getCode());
            // // $Xseance->setStatut(1);
            // $DateSéance=$emptime->getStart()->format("Y-m-d");
            // $EmpSemaine=$emptime->getSemaine()->getId();
            // $HeureDebut=$emptime->getHeurDb()->format("H:i");
            // $HeureFin=$emptime->getHeurFin()->format("H:i");
            // $DateSys=(new \DateTime())->format("Y-m-d");

            // $requete = "INSERT INTO `xseance`(`id_séance`, `typeséance`, `id_etablissement`, `id_formation`, `id_promotion`, `id_année`, `année_lib`, `id_semestre`, `groupe`, `id_module`, `id_element`, `id_enseignant`, `id_salle`, `date_séance`, `semaine`, `heure_debut`, `heure_fin`, `date_sys`, `statut`) VALUES ('$IDSéance','$Typeséance','$IDEtablissement','$IDFormation','$IDPromotion','$IDAnnée','$AnnéeLib','$IDSemestre','$EmpGroupe','$IDModule','$IDElement','$IDEnseignant','$IDSalle','$DateSéance','$EmpSemaine','$HeureDebut','$HeureFin','$DateSys','1')";
            // $stmt = $this->em->getConnection()->prepare($requete);
            // $newstmt = $stmt->executeQuery(); 
        }
        
        $this->em->flush();

        
        $abcd = ['A'=>0,'B'=>0,'C'=>0,'D'=>0];
        
        // $requete= "SELECT categories.categorie, IFNULL(t.count, 0) AS count FROM ( SELECT 'A' AS categorie UNION SELECT 'B' UNION SELECT 'C' UNION SELECT 'D' ) AS categories LEFT JOIN ( SELECT categorie, COUNT(*) AS count FROM xseance_absences WHERE id_séance = ".$emptime->getId()." and active =1 GROUP BY categorie ) AS t ON categories.categorie = t.categorie  order by categorie;";
        $requete= "SELECT categories.categorie, IFNULL(t.count, 0) AS count 
        FROM ( SELECT 'A' AS categorie UNION SELECT 'B' UNION SELECT 'C' UNION SELECT 'D' ) AS categories 
        LEFT JOIN ( SELECT categorie_f, COUNT(*) AS count FROM xseance_absences WHERE id_séance = ".$emptime->getId()."  and active =1 GROUP BY categorie_f ) AS t ON categories.categorie = t.categorie_f
        order by categorie;";
        // dd($requete);

        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();
        $etudiant = $newstmt->fetchAll();
        

        $abcd["A"] = $etudiant[0]['count'];
        $abcd["B"] = $etudiant[1]['count'];
        $abcd["C"] = $etudiant[2]['count'];
        $abcd["D"] = $etudiant[3]['count'];
        
        return new JsonResponse(['data'=>$abcd,'message'=>$counter .' Done from '. count($inscriptions),200]);
        // return new JsonResponse($counter .' Done from '. count($inscriptions),200);,200);
    }


//     #[Route('/traiter/{emptime}/{type}', name: 'traiter')]
//     public function traiter($emptime, $type)
//     {
//         if($type == 2){ //!!retraitement
//             $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance" => $emptime]);
//             if ($Xseance) {
//                 if ($Xseance->getStatut() == "2") {
//                     return new JsonResponse(['error' => 'La séance est verouiller!'], 500);
//                 }
//                 if ($Xseance->getStatut() != "1") {
//                     return new JsonResponse(['error' => 'La séance est pas encore traitée!'], 500);
//                 }
//             }
//         }    
//         // $abcd = ['A'=>201,'B'=>0,'C'=>0,'D'=>1];
//         // return new JsonResponse(['data'=>$abcd,'message'=>'test',200]);
//         $emptime = $this->em->getRepository(PlEmptime::class)->find($emptime);

//         // dd("hi");
//         $element = $emptime->getProgrammation()->getElement();
//         $promotion = $element->getModule()->getSemestre()->getPromotion();
//         $salle = $emptime->getXsalle();
//         // dd($salle->getCode());
//         // $pointeuses = $this->em->getRepository(ISeanceSalle::class)->findBy(['code_salle'=>$salle->getCode()]);

//         $code_salle = $salle->getCode();
//         $requete = "SELECT * FROM `iseance_salle` where code_salle like '$code_salle'";

//         $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//         $newstmt = $stmt->executeQuery();   
//         $pointeuses = $newstmt->fetchAll();

//         $sns = [];
//         $dateSeance = $emptime->getStart()->format('Y-m-d');
//         // dd($pointeuses);
//         foreach ($pointeuses as $pointeuse) {
//             $id_pointeuse = $pointeuse["id_pointeuse"];
//             $requete = "SELECT * FROM `machines` where sn = '$id_pointeuse' LIMIT 1";

//             $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//             $newstmt = $stmt->executeQuery();   
//             $machine = $newstmt->fetchAll();

//             // $machine = $this->em->getRepository(Machines::class)->findOneBy(['sn'=>$pointeuse->getIdPointeuse()]);
//             if (!$machine) {
//                 continue;
//             }
//             $zk = new \ZKLibrary($machine[0]["ip"], 4370);
//             $zk->connect();
//             $attendaces = $zk->getAttendance($dateSeance);
//             // dd($attendaces);
//             // dd($pointeuse->getIdPointeuse(),$attendaces[0]['timestamp']);
//             $zk->disconnect();
//             if ($attendaces) {
//                 foreach ($attendaces as $attendace) {
//                     // $userInfo = $this->em->getRepository(Userinfo::class)->findOneBy(['Badgenumber'=>$attendace['id']]);

//                     $badgenumber = $attendace['id'];

//                     $requete = "SELECT * FROM `userinfo` where badgenumber = '$badgenumber' LIMIT 1";

//                     $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//                     $newstmt = $stmt->executeQuery();   
//                     $userInfo = $newstmt->fetchAll();

//                     if ($userInfo) {
//                         // $checkIIN = $this->em->getRepository(Checkinout::class)->findOneBy([
//                         //     'sn' => $pointeuse->getIdPointeuse(),
//                         //     'USERID' => $userInfo->getUSERID(),
//                         //     'CHECKTIME' => new DateTime($attendace['timestamp']),
//                         // ]);

//                         $sn = $pointeuse["id_pointeuse"];
//                         $userid = $userInfo[0]["userid"];
//                         $CHECKTIME = $attendace['timestamp'];
//                         $memoinfo = $promotion->getFormation()->getEtablissement()->getAbreviation();
//                         // dd($CHECKTIME);

//                         $requete = "SELECT * FROM `checkinout` WHERE sn = '$sn' AND userid = '$userid' AND checktime = '$CHECKTIME' LIMIT 1";

//                         $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//                         $newstmt = $stmt->executeQuery();   
//                         $checkIIN = $newstmt->fetchAll();

//                         // dd($checkIIN);

//                         // if ($attendace['id'] == 9299) {
//                         //     dd($checkIIN,$pointeuse->getIdPointeuse(),$userInfo->getUSERID());
//                         // }
//                         if (!$checkIIN) {
//                             $requete = "INSERT INTO `checkinout`(`userid`, `checktime`, `memoinfo`, `sn`) VALUES ('$userid','$CHECKTIME','$memoinfo','$sn')";

//                             $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//                             $newstmt = $stmt->executeQuery();   
//                             $result = $newstmt->fetchAll();

//                             // $checkin = new Checkinout();
//                             // $checkin->setUSERID($userInfo->getUSERID());
//                             // $checkin->setCHECKTIME(new DateTime($attendace['timestamp']));
//                             // $checkin->setMemoinfo($promotion->getFormation()->getEtablissement()->getAbreviation());
//                             // $checkin->setSN($pointeuse->getIdPointeuse());
//                             // $this->em->persist($checkin);
//                         }
//                     }
//                 }
//             }
//             array_push($sns,$pointeuse["id_pointeuse"]);
//         }
//         // $this->em->flush();

//         $groupes = [];
//         $annee = $this->em->getRepository(AcAnnee::class)->getActiveAnneeByFormation($promotion->getFormation());
//         if($emptime->getGroupe()){
//             $groupe = $emptime->getGroupe();
//             array_push($groupes,$groupe);
//                 foreach ($groupe->getGroupes() as $groupe) {
//                     if (!in_array($groupe, $groupes)){
//                         array_push($groupes,$groupe);
//                     }
//                     foreach ($groupe->getGroupes() as $groupe) {
//                         if (!in_array($groupe, $groupes)){
//                             array_push($groupes,$groupe);
//                         }
//                     }
//                 }
//             $inscriptions = $this->em->getRepository(TInscription::class)->getInscriptionsByAnneeAndPromoAndGroupe($promotion,$annee,$groupes);
//         }else{
//             $inscriptions = $this->em->getRepository(TInscription::class)->getInscriptionsByAnneeAndPromoNoGroup($promotion,$annee);
//         }
//         if (count($inscriptions) == 0) {
//             die('Aucun Etudiant Trouver!!!');
//         }
//         $counter = 0;
//         $ID_etablissement = $annee->getFormation()->getEtablissement()->getId();
//         // $A = $ID_etablissement == 28 ? 20 : 15;
//         if ($ID_etablissement == 28) {
//             $A = 20;
//             if ($emptime->getStart()->format('H:i') == '08:00') {
//                 $AA = -30;
//             }else {
//                 $AA = -20;
//             }
//             $B = $A;
//         }else{
//             $A = 15;
//             $AA = -15;
//             $B = $A + 15;
//         }
//         $C = $B + 15;
//         $abcd = ['A'=>0,'B'=>0,'C'=>0,'D'=>0];
//         $date = clone $emptime->getStart();
//         $date->modify($AA.' min');
//         $check_ = $date->format("Y-m-d H:i:s"); //!!!!!!!!!!!!!!!!!!!!!!!!!!
//         foreach ($inscriptions as $inscription) {
//             // $capitaliseExist = $this->em->getRepository(XseanceCapitaliser::class)->findOneBy([
//             //     'ID_Admission'=>$inscription->getAdmission()->getCode(),
//             //     'ID_Module'=>$element->getModule()->getCode(),
//             //     'ID_Année'=>$annee->getCode()]);

//             $id_admission = $inscription->getAdmission()->getCode();
//             $id_module = $element->getModule()->getCode();
//             $id_annee = $annee->getCode();

//             $requete = "SELECT * FROM `xseance_capitaliser` where id_admission = '$id_admission' and id_module = '$id_module' and id_année = '$id_annee' LIMIT 1";
//             $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//             $newstmt = $stmt->executeQuery();   
//             $capitaliseExist = $newstmt->fetchAll();
            
//             $street = $inscription->getAdmission()->getCode();
//             if (!$capitaliseExist) {
//                 $requete = "SELECT * FROM `userinfo` where street = '$street' LIMIT 1";

//                 $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//                 $newstmt = $stmt->executeQuery();   
//                 $userInfo = $newstmt->fetchAll();

//                 // dd($userInfo);

//                 // $userInfo = $this->em->getRepository(Userinfo::class)->findOneBy(['street'=>$inscription->getAdmission()->getCode()]);
//                 $checkinout = null;
//                 $cat = "D";
//                 $CHECKTIME = $attendace['timestamp'];
                
//                 $sn = array_map(function($item) {
//                     return "'$item'";
//                 }, $sns);
//                 $sn = implode(',', $sn);
//                 if ($userInfo) {
//                     $userid = $userInfo[0]["userid"];
//                     $requete = "SELECT * FROM `checkinout` WHERE userid = '$userid' AND checktime = '$checktime' AND sn in ($sn) ORDER BY checktime DESC LIMIT 1";
// //                     $requete = "SELECT * FROM `checkinout` WHERE userid = '$userid' AND checktime >= '$check_' AND sn in ($sn) ORDER BY checktime ASC LIMIT 1";

//                     $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//                     $newstmt = $stmt->executeQuery();   
//                     $checkinout = $newstmt->fetchAll();
//                     // $checkinout = $this->em->getRepository(Checkinout::class)->findOneBySNAndDateAndUserId($sns,$userInfo->getUSERID(),$date);
//                     // dd($checkinout);
//                 }
                
                
//                 if ($checkinout) {
//                     $checktime_ = new \DateTime($checkinout[0]["checktime"]);
//                     $interval = ($checktime_->getTimestamp() - $emptime->getStart()->getTimestamp()) / 60;
                    
//                     if ($interval == 0) {
//                         $cat = "A";
//                     }elseif ($emptime->getStart() > $checktime_) {
//                         if ($interval >= $AA) {
//                             $cat = "A";
//                         }else {
//                             $cat = "D";
//                         }
//                     }elseif ($emptime->getStart() < $checktime_) {
//                         if ($interval <= $A) {
//                             $cat = "A";
//                         }elseif ($interval <= $B) {
//                             $cat = "B";
//                         }elseif($interval <= $C) {
//                             $cat = "C";
//                         }else {
//                             $cat = "D";
//                         }
//                     }
                    
//                     // if ($userInfo->getUSERID() == 54012) {
//                     //     dd($interval,$cat);
//                     // }
//                 }
//             }else {
//                 $cat = 'P';
//             }
//             $xAbseanceExist = $this->em->getRepository(XseanceAbsences::class)->findOneBy([
//                 'ID_Admission'=>$inscription->getAdmission()->getCode(),
//                 'ID_Séance'=>$emptime->getId(),
//             ]);
            
            
//             if($type == 2){ //!!retraitement
                    
//                 $xAbseanceExist->setDatePointage($checkinout != null ? (new \DateTime($checkinout[0]['checktime'])) : $emptime->getStart());
//                 $xAbseanceExist->setHeurePointage($checkinout != null ? (new \DateTime($checkinout[0]['checktime'])) : null);
//                 $xAbseanceExist->setCategorieSi($cat);

//                 // update in local

//                 $id_admission = $inscription->getAdmission()->getCode();
//                 $id_seance = $emptime->getId();
//                 $pointage = $checkinout != null ? (new \DateTime($checkinout[0]['checktime']))->format("H:i:s") : null;
//                 $categorie = $cat;

//                 $requete = "UPDATE `xseance_absences` SET `heure_pointage`='$pointage',`categorie_si`='$categorie' WHERE `id_séance` = '$id_seance' AND `id_admission` = '$id_admission'";

//                 // dd($requete);
//                 $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//                 $newstmt = $stmt->executeQuery(); 

//             }else{ //!!traitements
//                 if (!$xAbseanceExist) {
//                     $xAbseance = new XseanceAbsences();
//                     $xAbseance->setIDAdmission($inscription->getAdmission()->getCode());
//                     $xAbseance->setIDSéance($emptime->getId());
//                     $xAbseance->setNom($inscription->getAdmission()->getPreinscription()->getEtudiant()->getNom());
//                     $xAbseance->setPrénom($inscription->getAdmission()->getPreinscription()->getEtudiant()->getPrenom());
//                     $xAbseance->setDatePointage($checkinout != null ? (new \DateTime($checkinout[0]['checktime'])) : $emptime->getStart());
//                     $xAbseance->setHeurePointage($checkinout != null ? (new \DateTime($checkinout[0]['checktime'])) : null);
//                     $xAbseance->setCategorie($cat);
//                     $this->em->persist($xAbseance);
    
//                     // insert xseance in local database
    
//                     $id_admission = $inscription->getAdmission()->getCode();
//                     $id_seance = $emptime->getId();
//                     $nom = addslashes($inscription->getAdmission()->getPreinscription()->getEtudiant()->getNom());
//                     $prenom = addslashes($inscription->getAdmission()->getPreinscription()->getEtudiant()->getPrenom());
//                     $date = $checkinout != null ? $checkinout[0]["checktime"] : $emptime->getStart()->format('Y-m-d');
//                     $pointage = $checkinout != null ? (new \DateTime($checkinout[0]['checktime']))->format("H:i:s") : null;
//                     $categorie = $cat;
    
//                     $requete = "INSERT INTO `xseance_absences`(`id_admission`, `id_séance`, `nom`, `prénom`, `date_pointage`, `heure_pointage`, `categorie`) VALUES ('$id_admission','$id_seance','$nom','$prenom','$date','$pointage','$categorie')";
    
//                     // dd($requete);
//                     $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//                     $newstmt = $stmt->executeQuery();
    
//                 }else {
//                     $xAbseanceExist->setDatePointage($checkinout != null ? (new \DateTime($checkinout[0]['checktime'])) : $emptime->getStart());
//                     $xAbseanceExist->setHeurePointage($checkinout != null ? (new \DateTime($checkinout[0]['checktime'])) : null);
//                     $xAbseanceExist->setCategorie($cat);
    
//                     // update in local
    
//                     $id_admission = $inscription->getAdmission()->getCode();
//                     $id_seance = $emptime->getId();
//                     $pointage = $checkinout != null ? (new \DateTime($checkinout[0]['checktime']))->format("H:i:s") : null;
//                     $categorie = $cat;
    
//                     $requete = "UPDATE `xseance_absences` SET `heure_pointage`='$pointage',`categorie_si`='$categorie' WHERE `id_séance` = '$id_seance' AND `id_admission` = '$id_admission'";
    
//                     // dd($requete);
//                     $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//                     $newstmt = $stmt->executeQuery(); 
//                 }
//             }
            
//             $counter++;
//             switch ($cat) {
//                 case 'A':
//                     $abcd['A']++;
//                     break;
//                 case 'B':
//                     $abcd['B']++;
//                     break;
//                 case 'C':
//                     $abcd['C']++;
//                     break;
//                 case 'D':
//                     $abcd['D']++;
//                     break;
//             }
//         }
//         $this->em->flush();

// //conflis fixed like this 👇 
// //         $Xseance = new Xseance();
// //         $Xseance->setTypeséance($emptime->getProgrammation()->getNatureEpreuve()->getCode());
// //         $Xseance->setIDEtablissement($emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getEtablissement()->getCode());
// //         $Xseance->setIDFormation($emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getCode());
// //         $Xseance->setIDPromotion($emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getCode());
// //         $Xseance->setIDAnnée($emptime->getProgrammation()->getAnnee()->getCode());
// //         $Xseance->setAnnéeLib($emptime->getProgrammation()->getAnnee()->getDesignation());
// //         $Xseance->setIDSemestre($emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getCode());
// //         $Xseance->setGroupe($emptime->getGroupe()->getNiveau());
// //         $Xseance->setIDModule($emptime->getProgrammation()->getElement()->getModule()->getCode());
// //         $Xseance->setIDElement($emptime->getProgrammation()->getElement()->getId());
// //         $Xseance->setIDEnseignant($emptime->getemptimetimens()[0]->getEnseignant()->getCode());
// //         $Xseance->setIDSalle(strtoupper($emptime->getSalle()->getCode()));
// //         $Xseance->setDateSéance($emptime->getStart()->format("Y-m-d"));
// //         $Xseance->setSemaine($emptime->getSemaine()->getId());
// //         $Xseance->setHeureDebut($emptime->getHeurDb()->format("H:i"));
// //         $Xseance->setHeureFin($emptime->getHeurFin()->format("H:i"));
// //         $Xseance->setDateSys(new \DateTime());
// //         $Xseance->setIDSéance($emptime->getId());
// //         $Xseance->setStatut(1);

// //         $this->em->persist($Xseance);
// //         $this->em->flush();

//         // insert into xseance
//         $IDSéance = $emptime->getId();
//         $Typeséance=$emptime->getProgrammation()->getNatureEpreuve()->getCode();
//         $IDEtablissement=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getEtablissement()->getCode();
//         $IDFormation=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getCode();
//         $IDPromotion=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getCode();
//         $IDAnnée=$emptime->getProgrammation()->getAnnee()->getCode();     
//         $AnnéeLib=$emptime->getProgrammation()->getAnnee()->getDesignation();
//         $IDSemestre=$emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getCode();
//         $EmpGroupe=$emptime->getGroupe()->getNiveau();
//         $IDModule=$emptime->getProgrammation()->getElement()->getModule()->getCode();
//         $IDElement=$emptime->getProgrammation()->getElement()->getId();
//         $IDEnseignant=$emptime->getemptimens()[0]->getEnseignant()->getCode();
//         $IDSalle=strtoupper($emptime->getSalle()->getCode());
//         // $Xseance->setStatut(1);
//         $DateSéance=$emptime->getStart()->format("Y-m-d");
//         $EmpSemaine=$emptime->getSemaine()->getId();
//         $HeureDebut=$emptime->getHeurDb()->format("H:i");
//         $HeureFin=$emptime->getHeurFin()->format("H:i");
//         $DateSys=(new \DateTime())->format("Y-m-d");

//         $requete = "INSERT INTO `xseance`(`id_séance`, `typeséance`, `id_etablissement`, `id_formation`, `id_promotion`, `id_année`, `année_lib`, `id_semestre`, `groupe`, `id_module`, `id_element`, `id_enseignant`, `id_salle`, `date_séance`, `semaine`, `heure_debut`, `heure_fin`, `date_sys`, `statut`) VALUES ('$IDSéance','$Typeséance','$IDEtablissement','$IDFormation','$IDPromotion','$IDAnnée','$AnnéeLib','$IDSemestre','$EmpGroupe','$IDModule','$IDElement','$IDEnseignant','$IDSalle','$DateSéance','$EmpSemaine','$HeureDebut','$HeureFin','$DateSys','1')";


//         // // insert into xseance
   

//         // $requete = "INSERT INTO `xseance`(`id_séance`, `typeséance`, `id_etablissement`, `id_formation`, `id_promotion`, `id_année`, `année_lib`, `id_semestre`, `groupe`, `id_module`, `id_element`, `id_enseignant`, `id_salle`, `date_séance`, `semaine`, `heure_debut`, `heure_fin`, `date_sys`, `statut`) VALUES ('$IDSéance','$Typeséance','$IDEtablissement','$IDFormation','$IDPromotion','$IDAnnée','$AnnéeLib','$IDSemestre','$EmpGroupe','$IDModule','$IDElement','$IDEnseignant','$IDSalle','$DateSéance','$EmpSemaine','$HeureDebut','$HeureFin','$DateSys','1')";

//         // // dd($requete);
//         // $stmt = $this->emAssiduite->getConnection()->prepare($requete);
//         // $newstmt = $stmt->executeQuery();

//         return new JsonResponse(['data'=>$abcd,'message'=>$counter .' Done from '. count($inscriptions),200]);
//         // return new JsonResponse($counter .' Done from '. count($inscriptions),200);,200);
//     }

    #[Route('/reinitialiser/{seance}', name: 'reinitialiser_seance')]
    public function reinitialiser(Request $request, $seance)
    {
        $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance"=> $seance]);
        if ($Xseance) {
            if ($Xseance->getStatut() == "2") {
                return new JsonResponse(['error' => 'La séance est verouiller!'], 500);
            }
            if ($Xseance->getStatut() != "1") {
                return new JsonResponse(['error' => 'La séance est pas encore traitée!'], 500);
            }
        }else{
            return new JsonResponse(['error' => 'no Xséance'], 500);
        }

        $requete = "UPDATE `xseance_absences` SET `active` = 0 WHERE `id_séance` = '$seance' ";
        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery(); 

        $requete = "UPDATE `xseance` SET `statut` = 0 WHERE `id_séance` = '$seance' ";
        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery(); 

        $Xseance->setStatut(0);
        $this->em->flush();
        return new JsonResponse("Bien Réinitialisée",200);
    }

    #[Route('/existe/{seance}', name: 'existe_seance')]
    public function existe(Request $request, $seance)
    {
        $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance"=> $seance]);
        if ($Xseance) {
            if ($Xseance->getStatut() == "2") {
                return new JsonResponse(['error' => 'La séance est verouiller!'], 500);
            }
            if ($Xseance->getStatut() != "1") {
                return new JsonResponse(['error' => 'La séance est pas encore traitée!'], 500);
            }
            $Xseance->setExiste(1);
            $this->em->flush();
        }else{
            return new JsonResponse(['error' => 'no Xséance'], 500);
        }
        return new JsonResponse("Séance existe",200);
    }
    #[Route('/annuler/{seance}', name: 'annuler_seance')]
    public function annuler(Request $request, $seance)
    {
        $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance"=> $seance]);

        if ($Xseance) {
            if ($Xseance->getStatut() == "2") {
                return new JsonResponse(['error' => 'La séance est verouiller!'], 500);
            }
            if ($Xseance->getStatut() != "1") {
                return new JsonResponse(['error' => 'La séance est pas encore traitée!'], 500);
            }
            $Xseance->setAnnulée(1);
            $this->em->flush();
        }else{
            return new JsonResponse(['error' => 'no Xséance'], 500);
        }
        return new JsonResponse("Séance existe",200);
    }
    #[Route('/signer/{seance}', name: 'signer_seance')]
    public function existsignere(Request $request, $seance)
    {
        $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance"=> $seance]);
        if ($Xseance) {
            if ($Xseance->getStatut() == "2") {
                return new JsonResponse(['error' => 'La séance est verouiller!'], 500);
            }
            if ($Xseance->getStatut() != "1") {
                return new JsonResponse(['error' => 'La séance est pas encore traitée!'], 500);
            }
            $Xseance->setSigné(1);
            $this->em->flush();
        }else{
            return new JsonResponse(['error' => 'no Xséance'], 500);
        }
        return new JsonResponse("Séance signé",200);
    }

    #[Route('/verouiller/{seance}', name: 'verouiller_seance')]
    public function verouiller(Request $request, $seance)
    {
        $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance"=> $seance]);
        if ($Xseance) {
            $Xseance->setStatut(2);
            $this->em->flush();
        }else{
            return new JsonResponse(['error' => 'no Xséance'], 500);
        }
        return new JsonResponse("Séance existe",200);
    }

    #[Route('/modifiersalle/{seance}/{salle}', name: 'modifier_salle')]
    public function modifierSalle(Request $request, $seance, $salle)
    {
        $emptime = $this->em->getRepository(PlEmptime::class)->find($seance);
        $xsalle = $this->em->getRepository(PSalles::class)->find($salle);
        // dd($emptime, $xsalle);
        $emptime->setXsalle($xsalle);
        $this->em->flush();
        return new JsonResponse("Bien Modifier",200);
    }

    #[Route('/parlot/{hd}/{hf}/{day}', name: 'affichage_parlot')]
    public function affichage_parlot(Request $request,$hd,$hf,$day)
    {
        // dd($day);
        $todayDate = new \DateTime($day);
        $todayDate = $todayDate->format('Y-m-d');
        $todayDate = $todayDate . '%';
        // dd($todayDate, $hd, $hf);

        $requete = "SELECT emp.id as id_seance, emp.heur_db, emp.heur_fin, etab.abreviation as etbalissement, form.abreviation as formation, prm.designation as promotion, grp.niveau as groupe, sall.designation as salle, elm.designation as element, CONCAT(ens.nom,' ', ens.prenom) as enseignant from pl_emptime emp
        left join psalles sall on sall.id = emp.xsalle_id
        left join pgroupe grp on grp.id = emp.groupe_id
        inner join pl_emptimens empens on empens.seance_id = emp.id
        inner join penseignant ens on ens.id = empens.enseignant_id
        inner join pr_programmation prg on prg.id = emp.programmation_id
        inner join pnature_epreuve nat on nat.id = prg.nature_epreuve_id
        inner join ac_element elm on elm.id = prg.element_id
        inner join ac_module mdl on mdl.id = elm.module_id
        inner join ac_semestre sem on sem.id = mdl.semestre_id
        inner join ac_promotion prm on prm.id = sem.promotion_id
        inner join ac_formation form on form.id = prm.formation_id
        inner join ac_etablissement etab on etab.id = form.etablissement_id

        left join xseance xs on xs.id_séance = emp.id 

        WHERE emp.heur_db >= '$hd' and emp.heur_fin <= '$hf' and emp.start like '$todayDate' and (xs.statut not in (1,2) or xs.statut is null) group by emp.id";
        $stmt = $this->em->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $emptimes = $newstmt->fetchAll();
        // dd($emptimes);
        // $emptimes = $this->em->getRepository(PlEmptime::class)->getEmptimeByHdHfnonTraiter($hd, $hf, $todayDate);

        $html = $this->renderView('traitement/tables/parlot-table.html.twig', ['emptimes' => $emptimes]);

        return new JsonResponse(['html' => $html]);
    }

    #[Route('/etudiants/{seance}', name: 'etudiant_seance')]
    public function etudiant_seance(Request $request,$seance)
    {

        $emptime = $this->em->getRepository(PlEmptime::class)->find($seance);
        $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance" => $emptime]);
        $element = $emptime->getProgrammation()->getElement();
        $promotion = $element->getModule()->getSemestre()->getPromotion();
        $annee = $this->em->getRepository(AcAnnee::class)->getActiveAnneeByFormation($promotion->getFormation());

        $html1 = $this->renderView('traitement/pages/infos_seance.html.twig', ['emptime' => $emptime]);
        
        $etudiants = [];
        if(!$Xseance){
            $inscriptions = $this->em->getRepository(TInscription::class)->getInscriptionsByAnneeAndPromoNoGroup($promotion,$annee);
            array_push($etudiants, $inscriptions);
            // dd($inscriptions);
            $html2 = $this->renderView('traitement/tables/etudiant.html.twig', ['etudiants' => $etudiants[0], 'type' => "ins"]);
        }else if($Xseance->getStatut() == 1 or $Xseance->getStatut() == 2){
            // $XseanceAbsence = $this->em->getRepository(XseanceAbsences::class)->findBy([
            //     'ID_Séance'=>$emptime->getId(),
            //     'active'=> 1
            // ]);
            $requete = "SELECT * FROM `xseance_absences` where id_séance = '$seance' and active = 1";
            // dd($requete);
            
            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $XseanceAbsence = $newstmt->fetchAll();
            // dd($XseanceAbsence);
            array_push($etudiants, $XseanceAbsence);
            $html2 = $this->renderView('traitement/tables/etudiant.html.twig', ['etudiants' => $etudiants[0], 'type' => "xabs"]);
        }

        // dd($etudiants);


        return new JsonResponse(['html1' => $html1, 'html2' => $html2]);
    }
    
    #[Route('/open/{seance}', name: 'scan_seance')]
    public function open(Request $request, $seance)
    {


        $seance = (int)($seance);
        $file = '\\\172.20.0.54\uiass\pdf\\'.$seance.'.pdf';
        $filname = '"'.$seance.'"hello.pdf';
        // dd($file);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filname . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile($file);
        return new JsonResponse('pdf not found ');
    }

    #[Route('/count/{seance}', name: 'count_seance')]
    public function count(Request $request, $seance)
    {
        // dd($seance);
        $abcd = ['A'=>0,'B'=>0,'C'=>0,'D'=>0];
        
        // $requete= "SELECT categories.categorie, IFNULL(t.count, 0) AS count FROM ( SELECT 'A' AS categorie UNION SELECT 'B' UNION SELECT 'C' UNION SELECT 'D' ) AS categories LEFT JOIN ( SELECT categorie, COUNT(*) AS count FROM xseance_absences WHERE id_séance = $seance  and active =1 GROUP BY categorie ) AS t ON categories.categorie = t.categorie  order by categorie;";
        $requete= "SELECT categories.categorie, IFNULL(t.count, 0) AS count 
        FROM ( SELECT 'A' AS categorie UNION SELECT 'B' UNION SELECT 'C' UNION SELECT 'D' ) AS categories 
        LEFT JOIN ( SELECT categorie_f, COUNT(*) AS count FROM xseance_absences WHERE id_séance = $seance  and active =1 GROUP BY categorie_f ) AS t ON categories.categorie = t.categorie_f
        order by categorie;";
        // dd($requete);

        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();
        $etudiant = $newstmt->fetchAll();
        

        $abcd["A"] = $etudiant[0]['count'];
        $abcd["B"] = $etudiant[1]['count'];
        $abcd["C"] = $etudiant[2]['count'];
        $abcd["D"] = $etudiant[3]['count'];

        // dd($etudiant);


        // $requete= "SELECT xseance_absences.ID_Admission as  id_admission,xseance_absences.Nom,xseance_absences.Prénom,TIME_FORMAT(xseance_absences.Heure_Pointage, '%H:%i') AS Heure_Pointage,xseance_absences.Categorie
        // FROM xseance_absences
        // WHERE xseance_absences.ID_Séance=$seance and xseance_absences.Categorie='A'";
        // // dd($requete);

        // $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        // $newstmt = $stmt->executeQuery();
        // $etudiantA = $newstmt->fetchAll();

        // $requete2= "SELECT xseance_absences.ID_Admission as  id_admission,xseance_absences.Nom,xseance_absences.Prénom,TIME_FORMAT(xseance_absences.Heure_Pointage, '%H:%i') AS Heure_Pointage,xseance_absences.Categorie
        // FROM xseance_absences
        // WHERE xseance_absences.ID_Séance=$seance and xseance_absences.Categorie='B'";

        // $stmt = $this->emAssiduite->getConnection()->prepare($requete2);
        // $newstmt = $stmt->executeQuery();
        // $etudiantB = $newstmt->fetchAll();

        // $requete3= "SELECT xseance_absences.ID_Admission as  id_admission,xseance_absences.Nom,xseance_absences.Prénom,TIME_FORMAT(xseance_absences.Heure_Pointage, '%H:%i') AS Heure_Pointage,xseance_absences.Categorie
        // FROM xseance_absences
        // WHERE xseance_absences.ID_Séance=$seance and xseance_absences.Categorie='C'";

        // $stmt = $this->emAssiduite->getConnection()->prepare($requete3);
        // $newstmt = $stmt->executeQuery();
        // $etudiantC = $newstmt->fetchAll();

        // $requete4= "SELECT xseance_absences.ID_Admission as  id_admission,xseance_absences.Nom,xseance_absences.Prénom,TIME_FORMAT(xseance_absences.Heure_Pointage, '%H:%i') AS Heure_Pointage,xseance_absences.Categorie
        // FROM xseance_absences
        // WHERE xseance_absences.ID_Séance=$seance and xseance_absences.Categorie='D'";

        // $stmt = $this->emAssiduite->getConnection()->prepare($requete4);
        // $newstmt = $stmt->executeQuery();
        // $etudiantD = $newstmt->fetchAll();

        // $A= count($etudiantA);
        // $B= count($etudiantB);
        // $C= count($etudiantC);
        // $D= count($etudiantD);

        // $abcd["A"] = $A;
        // $abcd["B"] = $B;
        // $abcd["C"] = $C;
        // $abcd["D"] = $D;

        // dd($abcd);

        return new JsonResponse(['data'=>$abcd,200]);
    }

    #[Route('/z/{seance}', name: 'z_seance')]
    public function z(Request $request, $seance)
    {
        $requete = "UPDATE `xseance_absences` SET `categorie`='Z' WHERE `id_séance` = '$seance'";

        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();
        
        return new JsonResponse("Bien Modifier",200);
    }

    #[Route('/s/{seance}', name: 's_seance')]
    public function s(Request $request, $seance)
    {
        $requete = "UPDATE `xseance_absences` SET `categorie`='S' WHERE `id_séance` = '$seance'";

        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();
        
        return new JsonResponse("Bien Modifier",200);
    }

    #[Route('/imprimer/{seance}', name: 'imprimer_seance')]
    public function imprimer(Request $request, $seance)
    {
        $TodayDate= new \DateTime();
        $date= date_format($TodayDate, 'Y-m-d');
        setlocale(LC_TIME, "fr_FR", "French");
        $date2 = strftime("%A %d %B %G", strtotime($date)); 
        // $requete = "UPDATE `xseance_absences` SET `categorie`='S' WHERE `id_séance` = '$seance'";
        $emptime = $this->em->getRepository(PlEmptime::class)->find($seance);
        // dd($emptime->getGroupe());

        
        $requete= "SELECT xseance_absences.ID_Admission as  id_admission,xseance_absences.Nom,xseance_absences.Prénom,TIME_FORMAT(xseance_absences.Heure_Pointage, '%H:%i') AS Heure_Pointage,xseance_absences.categorie_f
        FROM xseance_absences
        WHERE xseance_absences.ID_Séance=$seance and xseance_absences.categorie_f='A'";
        // dd($requete);

        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();
        $etudiantA = $newstmt->fetchAll();

        $requete2= "SELECT xseance_absences.ID_Admission as  id_admission,xseance_absences.Nom,xseance_absences.Prénom,TIME_FORMAT(xseance_absences.Heure_Pointage, '%H:%i') AS Heure_Pointage,xseance_absences.categorie_f
        FROM xseance_absences
        WHERE xseance_absences.ID_Séance=$seance and xseance_absences.categorie_f='B'";

        $stmt = $this->emAssiduite->getConnection()->prepare($requete2);
        $newstmt = $stmt->executeQuery();
        $etudiantB = $newstmt->fetchAll();

        $requete3= "SELECT xseance_absences.ID_Admission as  id_admission,xseance_absences.Nom,xseance_absences.Prénom,TIME_FORMAT(xseance_absences.Heure_Pointage, '%H:%i') AS Heure_Pointage,xseance_absences.categorie_f
        FROM xseance_absences
        WHERE xseance_absences.ID_Séance=$seance and xseance_absences.categorie_f='C'";

        $stmt = $this->emAssiduite->getConnection()->prepare($requete3);
        $newstmt = $stmt->executeQuery();
        $etudiantC = $newstmt->fetchAll();

        $requete4= "SELECT xseance_absences.ID_Admission as  id_admission,xseance_absences.Nom,xseance_absences.Prénom,TIME_FORMAT(xseance_absences.Heure_Pointage, '%H:%i') AS Heure_Pointage,xseance_absences.categorie_f
        FROM xseance_absences
        WHERE xseance_absences.ID_Séance=$seance and xseance_absences.categorie_f='D'";

        $stmt = $this->emAssiduite->getConnection()->prepare($requete4);
        $newstmt = $stmt->executeQuery();
        $etudiantD = $newstmt->fetchAll();

        $A= count($etudiantA);
        $B= count($etudiantB);
        $C= count($etudiantC);
        $D= count($etudiantD);

        $total = $A + $B + $C + $D;
        // dd($A, $B, $C, $D, $total); 

        $html = $this->render('traitement/pdfs/feuilleAppel.html.twig' , [
            "emptime" => $emptime,
            "etudiantA" =>$etudiantA,
            "etudiantB" =>$etudiantB,
            "etudiantC" =>$etudiantC,
            "etudiantD" =>$etudiantD,
            "A" => $A,
            "B" => $B,
            "C" => $C,
            "D" => $D,
            "date" =>$date2,
        ])->getContent();
        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 100,
        ]);            
        $mpdf->SetTitle('Feuil');
        $mpdf->SetJS('this.print()');
        // $mpdf->showImageErrors = true;
        
        $mpdf->SetHTMLHeader(
            $this->render("traitement/pdfs/header.html.twig"
            , [
                "emptime" => $emptime,
                "A" => $A,
                "B" => $B,
                "C" => $C,
                "D" => $D,
                "Total" =>$total,
                "date" =>$date2,
                
            ])->getContent()
        );

        $mpdf->SetHTMLFooter(
            $this->render("traitement/pdfs/footer.html.twig"
            , [
                "emptime" => $emptime,
                "date" =>$date2,
                
            ])->getContent()
        );
        $mpdf->WriteHTML($html);
        $mpdf->Output('fueil' , 'I');
        
    
        
        // return new JsonResponse("Bien Modifier",200);
    }

    #[Route('/planing/{day}', name: 'planing_seance')]
    public function planing(Request $request, $day)
    {


        
        $styleFirstRow = [
            'font' => [
                'bold' => true,
                'size' => 14, // Adjust the font size as needed
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '0070C0', // Blue color
                ],
            ],
        ];
        
        $styleSecondRow = [
            'font' => [
                'bold' => false, // No bold for subsequent rows
                'size' => 12, // Adjust the font size as needed
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'BDD7EE', // Lighter blue color
                ],
            ],
        ];

        $styleSubsequentRows = [
            'font' => [
                'bold' => false, // No bold for subsequent rows
                'size' => 12, // Adjust the font size as needed
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true, // Enable text wrapping
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'BDD7EE', // Lighter blue color
                ],
            ],
        ];

        // $todayDate = $day->format('Y-m-d');
        $todayDate = $day . '%';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $day);
        $sheet->setCellValue('A2', 'Séance');
        $sheet->setCellValue('B2', 'HD');
        $sheet->setCellValue('C2', 'HF');
        $sheet->setCellValue('D2', 'ETABLISSEMENT');
        $sheet->setCellValue('E2', 'FORMATION');
        $sheet->setCellValue('F2', 'PROMOTION');
        $sheet->setCellValue('G2', 'GROUPE');
        $sheet->setCellValue('H2', 'SALLE');
        $sheet->setCellValue('I2', 'ENSEIGNANT');

        $sheet->getStyle('A1:I1')->applyFromArray($styleFirstRow);
        $sheet->getStyle('A2:I2')->applyFromArray($styleSecondRow);

        $sheet->mergeCells('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(30);
        $i=3;
        $count = 1 ;
        $emptimes = $this->em->getRepository(PlEmptime::class)->getEmptimeByDay($todayDate);
        foreach ($emptimes as $emptime) {
            $sheet->setCellValue('A'.$i, $emptime->getId());
            $sheet->setCellValue('B'.$i, $emptime->getHeurDb()->format('H:i'));
            $sheet->setCellValue('C'.$i, $emptime->getHeurFin()->format('H:i'));
            $sheet->setCellValue('D'.$i, $emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getEtablissement()->getAbreviation());
            $sheet->setCellValue('E'.$i, $emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getFormation()->getAbreviation());
            $sheet->setCellValue('F'.$i, $emptime->getProgrammation()->getElement()->getModule()->getSemestre()->getPromotion()->getDesignation());
            $sheet->setCellValue('G'.$i, $emptime->getGroupe() ? $emptime->getGroupe()->getNiveau() : "");
            $sheet->setCellValue('H'.$i, $emptime->getXSalle()->getDesignation());
            $sheet->setCellValue('I'.$i, $emptime->getEmptimens()[0]->getEnseignant()->getNom()." ".$emptime->getEmptimens()[0]->getEnseignant()->getPrenom());
            
            
            $i++;
        }

            
        $this->em->flush();
        $fileName = null;
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Planing_seances.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/etudiant_details/{admission}/{seance}', name: 'administration_epreuve_edit')]
    public function administrationEpreuveEdit($admission, $seance) {
        // $XseanceAbsence = $this->em->getRepository(XseanceAbsences::class)->findOneBy([
        //     'ID_Admission'=>$admission,
        //     'ID_Séance'=>$seance,
        // ]);
        $requete = "SELECT * FROM `xseance_absences` where id_admission = '$admission' and id_séance = '$seance' and active = 1 LIMIT 1";
        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $XseanceAbsence = $newstmt->fetchAll();
        // dd($admission,$XseanceAbsence);
        $html = $this->renderView('traitement/pages/etudiant_infos.html.twig', [
            'xabs' => $XseanceAbsence[0]
        ]);
        return new JsonResponse($html);
    }

    #[Route('/update_etudiant', name: 'update_etudiant')]
    public function update_etudiant(Request $request) {
        // dd($request);
       
        if(empty($request->get('cat_Ens')) or empty($request->get('observation'))) {
            return new JsonResponse("Veuillez remplir tous les champs!", 500);
        }
        if(empty($request->get('seance')) or empty($request->get('admission'))) {
            return new JsonResponse("No informations", 500);
        }

        $catEns = $request->get('cat_Ens');
        $obs = $request->get('observation');
        $admission = $request->get('admission');
        $seance = $request->get('seance');

        $requete = "UPDATE `xseance_absences` SET `categorie_enseig`='$catEns',`obs`= '$obs' WHERE `id_admission` = '$admission' and id_séance = $seance and active = 1;";

        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery(); 
        return new JsonResponse('Bien enregistre',200);

        
    }

    #[Route('/synthese/{datetoday}', name: 'synthese')]
    public function synthese($datetoday)
    {
        dd($datetoday);

    $TodayDate= new \DateTime();
    $date= date_format($TodayDate, 'Y-m-d');
    setlocale(LC_TIME, "fr_FR", "French");
    $date2 = strftime("%A %d %B %G", strtotime($date)); 
    //seance+date+prof
    $requete_promo_count = "SELECT COUNT(x_inscription_grp.code_admission) AS etud,x_inscription_grp.promotion_code 
                            FROM x_inscription_grp GROUP BY promotion_code";
    $count_global =  ApiController::execute($requete_promo_count,$this->em);

    $requete_promo_daily = "SELECT COUNT(xseance_absences.ID_Admission) as etud,xseance.ID_Promotion as promotion_code FROM xseance_absences 
                            INNER JOIN xseance ON xseance.ID_Séance=xseance_absences.ID_Séance 
                            WHERE  xseance.Date_Séance='$datetoday' GROUP by xseance.ID_Promotion
    ";
    $count_global_jr =  ApiController::execute($requete_promo_daily,$this->em);

    $requete_promo_abs = "SELECT COUNT(xseance.ID_Séance) as etud,xseance.ID_Promotion as promotion_code FROM xseance 
                            INNER JOIN xseance_absences ON xseance.ID_Séance=xseance_absences.ID_Séance
                            WHERE xseance.Date_Séance='$datetoday' AND (xseance_absences.Categorie='D' OR xseance_absences.Categorie='C'
                            OR xseance_absences.Categorie_Enseig='AD' OR xseance_absences.Categorie_Enseig='BD') GROUP BY xseance.ID_Promotion";
    $count_global_abs =  ApiController::execute($requete_promo_abs,$this->em);

    $date1 = date('Y-m-d'); // Date du jour
    setlocale(LC_TIME, "fr_FR", "French");
    $date2 = strftime("%A %d %B %G", strtotime($date1)); 
    $date3 = strftime("%A %d %B %G", strtotime($date)); 

    
        $html = $this->render('assiduite/pdf/synthese.html.twig' , [
        
            "count_global" => $count_global,
            "count_global_jr" => $count_global_jr,
            "count_global_abs" => $count_global_abs,
            "date" =>$date2,
            "dat" =>$date3,
            "date_today" =>$TodayDate,

        ])->getContent();

        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 45,
        ]);            
        $mpdf->SetTitle('Feuil');
        $mpdf->SetHTMLHeader(
            $this->render("assiduite/pdf/header_synthese.html.twig"
            , [
            
            "date_today" =>$TodayDate,
            
                
            ])->getContent()
        );
        $mpdf->SetHTMLFooter(
            $this->render("assiduite/pdf/footer_synthese.html.twig"
            , [
                "date" =>$date2,
                "dat" =>$date3,
                "date_today" =>$TodayDate,
                
            ])->getContent()
        );
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML($html);
        $mpdf->Output('fueil' , 'I');





    }

    #[Route('/parlot_traitement/{day}', name: 'parlot_traitement')]
    public function parlot_traitement(Request $request, $day) {
        $seances = array_unique(json_decode($request->get("seances")));
        $errors = [];
        $traités = [];
        $requete = "SELECT * FROM `checkinout` where date(checktime) = '$day'";

        $stmt = $this->emPointage->getConnection()->prepare($requete);
        $newstmt = $stmt->executeQuery();   
        $pointages = $newstmt->fetchAll();

        if ($pointages) {
            foreach ($pointages as $pointage) {
                $id_checkinout = $pointage["id"];
                $userid = $pointage["userid"];
                $checktime = $pointage["checktime"];
                $memoinfo = $pointage["memoinfo"];
                $sn = $pointage["sn"];

                //** checks if there is that checkinout in local database 'assiduite' **//
                $requete = "SELECT * FROM `checkinout` where id = $id_checkinout LIMIT 1";

                $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                $newstmt = $stmt->executeQuery();   
                $checkinout = $newstmt->fetchAll();

                if(!$checkinout){
                    $requete = "INSERT INTO `checkinout`(`id`,`userid`, `checktime`, `memoinfo`, `sn`) VALUES ('$id_checkinout','$userid','$checktime','$memoinfo','$sn')";

                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery();
                }
            }
        }

        foreach ($seances as $key => $value) {
            $emptime = $this->em->getRepository(PlEmptime::class)->find($value);
            $id_seance = $value;
            $element = $emptime->getProgrammation()->getElement();
            $promotion = $element->getModule()->getSemestre()->getPromotion();
            $salle = $emptime->getXsalle();
            $code_salle = $salle->getCode();

            $requete = "SELECT m.* FROM `machines` m INNER JOIN iseance_salle iss on iss.id_pointeuse = m.sn where iss.code_salle = '$code_salle'";

            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $pointeuses = $newstmt->fetchAll();
            $sns ="";
            if (!$pointeuses) {
                $message = "Séance: ".$id_seance." dans la salle: ".$code_salle." est pas traité, y'a pas de pointeuses.";
                array_push($errors,$message);
                continue;
            }
            foreach ($pointeuses as $machine) {
                $sn = $machine["sn"];
                $sns .= "'$sn',";
            }
            $sn = rtrim($sns, ', ');

            $groupes = [];
            $annee = $this->em->getRepository(AcAnnee::class)->getActiveAnneeByFormation($promotion->getFormation());
            if($emptime->getGroupe()){
                $groupe = $emptime->getGroupe();
                array_push($groupes,$groupe);
                    foreach ($groupe->getGroupes() as $groupe) {
                        if (!in_array($groupe, $groupes)){
                            array_push($groupes,$groupe);
                        }
                        foreach ($groupe->getGroupes() as $groupe) {
                            if (!in_array($groupe, $groupes)){
                                array_push($groupes,$groupe);
                            }
                        }
                    }
                $inscriptions = $this->em->getRepository(TInscription::class)->getInscriptionsByAnneeAndPromoAndGroupe($promotion,$annee,$groupes);
            }else{
                $inscriptions = $this->em->getRepository(TInscription::class)->getInscriptionsByAnneeAndPromoNoGroup($promotion,$annee);
            }
            if (count($inscriptions) == 0) {
                $message = "Séance: ".$id_seance." dans la salle: ".$code_salle." est pas traité, Aucun Etudiant Trouvé.";
                array_push($errors,$message);
                continue;
            }
            $counter = 0;
            $ID_etablissement = $annee->getFormation()->getEtablissement()->getId();
            if ($ID_etablissement == 28) {
                $A = 20;
                if ($emptime->getStart()->format('H:i') == '08:00') {
                    $AA = -30;
                }else {
                    $AA = -20;
                }
                $B = $A;
            }else{
                $A = 15;
                $AA = -15;
                $B = $A + 15;
            }
            $C = $B + 15;
            // $abcd = ['A'=>0,'B'=>0,'C'=>0,'D'=>0];
            $date = clone $emptime->getStart();
            $date->modify($AA.' min');
            $check_ = $date->format("Y-m-d H:i:s");
            
            foreach ($inscriptions as $inscription) {

                $id_admission = $inscription->getAdmission()->getCode();
                $id_module = $element->getModule()->getCode();
                $id_annee = $annee->getCode();

                $requete = "SELECT * FROM `xseance_capitaliser` where id_admission = '$id_admission' and id_module = '$id_module' and id_année = '$id_annee' LIMIT 1";
                $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                $newstmt = $stmt->executeQuery();   
                $capitaliseExist = $newstmt->fetchAll();
                if (!$capitaliseExist) {
                    $requete = "SELECT * FROM `userinfo` where street = '$id_admission' group by street LIMIT 1";

                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery();   
                    $userInfo = $newstmt->fetchAll();

                    $checkinout = null;
                    $cat = "D";

                    if ($userInfo) {
                        $userid = $userInfo[0]["userid"];
                        $requete = "SELECT * FROM `checkinout` WHERE userid = '$userid' AND checktime >= '$check_' AND sn in ($sn) ORDER BY checktime ASC LIMIT 1";
                        
                        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                        $newstmt = $stmt->executeQuery();   
                        $checkinout = $newstmt->fetchAll();
                    }
                    
                    if ($checkinout) {
                        $checktime_ = new \DateTime($checkinout[0]["checktime"]);
                        $interval = ($checktime_->getTimestamp() - $emptime->getStart()->getTimestamp()) / 60;
                        
                        
                        if ($interval == 0) {
                            $cat = "A";
                        }elseif ($emptime->getStart() > $checktime_) {
                            if ($interval >= $AA) {
                                $cat = "A";
                            }else {
                                $cat = "D";
                            }
                        }elseif ($emptime->getStart() < $checktime_) {
                            if ($interval <= $A) {
                                $cat = "A";
                            }elseif ($interval <= $B) {
                                $cat = "B";
                            }elseif($interval <= $C) {
                                $cat = "C";
                            }else {
                                $cat = "D";
                            }
                        }
                    }
                }else {
                    $cat = 'P';
                }

                $requete = "SELECT * FROM `xseance_absences` where id_admission = '$id_admission' and id_séance = '$id_seance' LIMIT 1";
                
                $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                $newstmt = $stmt->executeQuery();   
                $xAbseanceExist = $newstmt->fetchAll();

                if (!$xAbseanceExist) {
                    $nom = addslashes($inscription->getAdmission()->getPreinscription()->getEtudiant()->getNom());
                    $prenom = addslashes($inscription->getAdmission()->getPreinscription()->getEtudiant()->getPrenom());
                    $date = $checkinout != null ? $checkinout[0]["checktime"] : $emptime->getStart()->format('Y-m-d');
                    $pointage = $checkinout != null ? (new \DateTime($checkinout[0]['checktime']))->format("H:i:s") : null;
                    $categorie = $cat;
    
                    $requete = "INSERT INTO `xseance_absences`(`id_admission`, `id_séance`, `nom`, `prénom`, `date_pointage`, `heure_pointage`, `categorie`, `active`) VALUES ('$id_admission','$id_seance','$nom','$prenom','$date','$pointage','$categorie',1)";

                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery();
    
                }else {
                    $pointage = $checkinout != null ? (new \DateTime($checkinout[0]['checktime']))->format("H:i:s") : null;
                    $categorie = $cat;
    
                    $requete = "UPDATE `xseance_absences` SET `heure_pointage`='$pointage',`categorie_si`='$categorie',`active`=1 WHERE `id` = ".$xAbseanceExist[0]['id'].";";

                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery(); 

                }
                
                $counter++;
                
            }

            $Xseance = $this->em->getRepository(Xseance::class)->findOneBy(["ID_Séance"=> $id_seance]);
            if($Xseance){
                $Xseance->setStatut(1);
            }else{
                $Xseance = new Xseance();
                $Xseance->setIDSéance($emptime->getId());
                $Xseance->setStatut(1);
                $Xseance->setDateSys(new \DateTime());
                $this->em->persist($Xseance);
            }
            
            $this->em->flush();

            array_push($traités,$id_seance);

        }
        return new JsonResponse(['errors'=>$errors,'traités'=>$traités,200]);
    }


}