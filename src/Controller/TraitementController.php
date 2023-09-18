<?php

namespace App\Controller;

use App\Entity\AcAnnee;
use App\Entity\AcEtablissement;
use App\Entity\Checkinout;
use App\Entity\ISeanceSalle;
use App\Entity\Machines;
use App\Entity\PlEmptime;
use App\Entity\TInscription;
use App\Entity\Userinfo;
use App\Entity\XseanceAbsences;
use App\Entity\XseanceCapitaliser;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// use ZKLibrary;

//!! require '../zklibrary.php';

//!! require '../ZKLib.php';


// require '../ZK/Nouveau dossier/zklibrary.php';


// require __DIR__ . '../../../vendor/autoload.php';

#[Route('/assiduite/traitement')]
class TraitementController extends AbstractController
{
    private $em;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }
    #[Route('/', name: 'traitement')]
    public function index(Request $request)
    {
        $operations = ApiController::check($this->getUser(), 'traitement', $this->em, $request);
        if(!$operations) {
            return $this->render("errors/403.html.twig");
        }
        // return $this->render('parametre/element/index.html.twig', [
        return $this->render('traitement/index.html.twig', [
            'etablissements' => $this->em->getRepository(AcEtablissement::class)->findBy(['active' => 1]),
            // 'natures' => $this->em->getRepository(TypeElement::class)->findAll(),
            'operations' => $operations
        ]);
    }
    #[Route('/list', name: 'parametre_element_list')]
    public function list(Request $request)
    {
        $params = $request->query;
        // dd($params);
        $where = $totalRows = $sqlRequest = "";
        // $filtre = "where 1 = 1 and elm.active = 1";   
        $filtre = "where 1 = 1 ";   
        // dd($params->all('columns')[0]['search']['value']);
        if (!empty($params->all('columns')[0]['search']['value'])) {
            $filtre .= " and emp.start like '" . $params->all('columns')[0]['search']['value'] . "%' ";
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

        $filtre group by emp.id";
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
            // dd($row);
            foreach (array_values($row) as $key => $value) {
                $nestedData[] = $value;
                
            }
            $nestedData["DT_RowId"] = $cd;
            // $nestedData["DT_RowClass"] = $cd;
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


    #[Route('/traiter/{emptime}', name: 'traiter')]
    public function traiter($emptime)
    {
        
        $abcd = ['A'=>21,'B'=>0,'C'=>0,'D'=>1];
        return new JsonResponse(['data'=>$abcd,'message'=>'test',200]);
        $emptime = $this->em->getRepository(PlEmptime::class)->find($emptime);


        $element = $emptime->getProgrammation()->getElement();
        $promotion = $element->getModule()->getSemestre()->getPromotion();
        $salle = $emptime->getXsalle();
        // dd($salle->getCode());
        $pointeuses = $this->em->getRepository(ISeanceSalle::class)->findBy(['code_salle'=>$salle->getCode()]);
        $sns = [];
        $dateSeance = $emptime->getStart()->format('Y-m-d');
        // dd($pointeuses);
        foreach ($pointeuses as $pointeuse) {
            $machine = $this->em->getRepository(Machines::class)->findOneBy(['sn'=>$pointeuse->getIdPointeuse()]);
            if (!$machine) {
                continue;
            }
            $zk = new \ZKLibrary($machine->getIP(), 4370);
            $zk->connect();
            $attendaces = $zk->getAttendance($dateSeance);
            // dd($attendaces);
            // dd($pointeuse->getIdPointeuse(),$attendaces[0]['timestamp']);
            $zk->disconnect();
            if ($attendaces) {
                foreach ($attendaces as $attendace) {
                    $userInfo = $this->em->getRepository(Userinfo::class)->findOneBy(['Badgenumber'=>$attendace['id']]);
                    if ($userInfo) {
                        $checkIIN = $this->em->getRepository(Checkinout::class)->findOneBy([
                            'sn' => $pointeuse->getIdPointeuse(),
                            'USERID' => $userInfo->getUSERID(),
                            'CHECKTIME' => new DateTime($attendace['timestamp']),
                        ]);
                        // if ($attendace['id'] == 9299) {
                        //     dd($checkIIN,$pointeuse->getIdPointeuse(),$userInfo->getUSERID());
                        // }
                        if (!$checkIIN) {
                            $checkin = new Checkinout();
                            $checkin->setUSERID($userInfo->getUSERID());
                            $checkin->setCHECKTIME(new DateTime($attendace['timestamp']));
                            $checkin->setMemoinfo($promotion->getFormation()->getEtablissement()->getAbreviation());
                            $checkin->setSN($pointeuse->getIdPointeuse());
                            $this->em->persist($checkin);
                        }
                    }
                }
            }
            array_push($sns,$pointeuse->getIdPointeuse());
        }
        $this->em->flush();

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
        $abcd = ['A'=>0,'B'=>0,'C'=>0,'D'=>0];
        $date = clone $emptime->getStart();
        $date->modify($AA.' min');
        foreach ($inscriptions as $inscription) {
            $capitaliseExist = $this->em->getRepository(XseanceCapitaliser::class)->findOneBy([
                'ID_Admission'=>$inscription->getAdmission()->getCode(),
                'ID_Module'=>$element->getModule()->getCode(),
                'ID_Année'=>$annee->getCode()]);

            if (!$capitaliseExist) {
                $userInfo = $this->em->getRepository(Userinfo::class)->findOneBy(['street'=>$inscription->getAdmission()->getCode()]);
                $checkinout = null;
                $cat = "D";
                
                if ($userInfo) {
                    $checkinout = $this->em->getRepository(Checkinout::class)->findOneBySNAndDateAndUserId($sns,$userInfo->getUSERID(),$date);
                }
                
                
        // dd($checkinout,$userInfo->getUSERID(),$inscription->getAdmission()->getCode());
                if ($checkinout) {
                    $interval = ($checkinout->getCHECKTIME()->getTimestamp() - $emptime->getStart()->getTimestamp()) / 60;
                    
                    if ($interval == 0) {
                        $cat = "A";
                    }elseif ($emptime->getStart() > $checkinout->getCHECKTIME()) {
                        if ($interval >= $AA) {
                            $cat = "A";
                        }else {
                            $cat = "D";
                        }
                    }elseif ($emptime->getStart() < $checkinout->getCHECKTIME()) {
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
                    
                    // if ($userInfo->getUSERID() == 54012) {
                    //     dd($interval,$cat);
                    // }
                }
            }else {
                $cat = 'P';
            }
            $xAbseanceExist = $this->em->getRepository(XseanceAbsences::class)->findOneBy([
                'ID_Admission'=>$inscription->getAdmission()->getCode(),
                'ID_Séance'=>$emptime->getId(),
            ]);
            
            if (!$xAbseanceExist) {
                $xAbseance = new XseanceAbsences();
                $xAbseance->setIDAdmission($inscription->getAdmission()->getCode());
                $xAbseance->setIDSéance($emptime->getId());
                $xAbseance->setNom($inscription->getAdmission()->getPreinscription()->getEtudiant()->getNom());
                $xAbseance->setPrénom($inscription->getAdmission()->getPreinscription()->getEtudiant()->getPrenom());
                $xAbseance->setDatePointage($checkinout != null ? $checkinout->getCHECKTIME() : $emptime->getStart());
                $xAbseance->setHeurePointage($checkinout != null ? $checkinout->getCHECKTIME() : null);
                $xAbseance->setCategorie($cat);
                $this->em->persist($xAbseance);
            }else {
                $xAbseanceExist->setDatePointage($checkinout != null ? $checkinout->getCHECKTIME() : $emptime->getStart());
                $xAbseanceExist->setHeurePointage($checkinout != null ? $checkinout->getCHECKTIME() : null);
                $xAbseanceExist->setCategorie($cat);
            }
            $counter++;
            switch ($cat) {
                case 'A':
                    $abcd['A']++;
                    break;
                case 'B':
                    $abcd['B']++;
                    break;
                case 'C':
                    $abcd['C']++;
                    break;
                case 'D':
                    $abcd['D']++;
                    break;
            }
        }
        $this->em->flush();

        return new JsonResponse(['data'=>$abcd,'message'=>$counter .' Done from '. count($inscriptions),200]);
        // return new JsonResponse($counter .' Done from '. count($inscriptions),200);,200);
    }

    // public function GetArrayABCD($cat){
        
    // }

}
