<?php

namespace App\Controller;

use App\Entity\AcEtablissement;
use App\Entity\PSalles;
use App\Entity\Machines;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


// require '../zklibrary.php';
// require '../ZKLib.php';


#[Route('/assiduite/pointeuse')]
class PointeuseController extends AbstractController
{
    private $em;
    private $emAssiduite;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
        $this->emAssiduite = $doctrine->getManager('assiduite');
    }
    #[Route('/', name: 'app_pointeuse')]
    public function index(): Response
    {
        // dd('test');
        return $this->render('pointeuse/index.html.twig', [
            'etablissements' => $this->em->getRepository(AcEtablissement::class)->findBy(['active' => 1]),
            'salles' => $this->em->getRepository(PSalles::class)->findAll(),
            // 'natures' => $this->em->getRepository(TypeElement::class)->findAll(),
            // 'operations' => $operations
        ]);
    }
    #[Route('/list', name: 'pointeuses_list')]
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
            $filtre .= " and sall.id = '" . $params->all('columns')[0]['search']['value'] . "' ";
        }
        

        // dd($filtre);
        $columns = array(
            array( 'db' => 'mach.id','dt' => 0),
            array( 'db' => 'sall.code','dt' => 1),
            array( 'db' => 'UPPER(sall.designation)','dt' => 2),
            array( 'db' => 'upper(mach.sn)','dt' => 3),
            array( 'db' => 'upper(mach.ip)','dt' => 4),
        );
        $sql = "SELECT " . implode(", ", DatatablesController::Pluck($columns, 'db')) . "
        from psalles sall 
        inner join iseance_salle isall on isall.code_salle = sall.code
        inner join machines mach on mach.sn = isall.id_pointeuse
        $filtre ";
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
                if ($key == 0) {
                    $value = '<input id="check" type="checkbox" data-id="'.$value.'"/>';
                    // $class = $reglement->getAnnuler() == 1 ? "etat_bg_nf" : "" ;
                }
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

       
    #[Route('/attendance/{pointeuse}/{date_debut}/{date_fin}', name: 'attendence')]
    public function attendence($pointeuse,$date_debut,$date_fin)
    {
        // dd($pointeuse,$date_debut, $date_fin);
        $pointeuse = $this->em->getRepository(Machines::class)->find($pointeuse);
        if (!$pointeuse || $date_debut == "" || $date_fin == "") {
            return new JsonResponse('Veuillez selectioner une pointeuse valide, et une periode!');
        }
        // dd($pointeuse);
        
        $zk = new \ZKLibrary($pointeuse->getIP(), 4370);
        $zk->connect();
        $attendaces = $zk->getAttendance($dateSeance);
        // dd($attendaces);
        // dd($pointeuse->getIdPointeuse(),$attendaces[0]['timestamp']);
        $zk->disconnect();
        if ($attendaces) {
            foreach ($attendaces as $attendace) {
                // $userInfo = $this->em->getRepository(Userinfo::class)->findOneBy(['Badgenumber'=>$attendace['id']]);

                dd($attendace);
                $badgenumber = $attendace['id'];

                $requete = "SELECT * FROM `userinfo` where badgenumber = '$badgenumber' LIMIT 1";

                $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                $newstmt = $stmt->executeQuery();   
                $userInfo = $newstmt->fetchAll();

                if ($userInfo) {
                    // $checkIIN = $this->em->getRepository(Checkinout::class)->findOneBy([
                    //     'sn' => $pointeuse->getIdPointeuse(),
                    //     'USERID' => $userInfo->getUSERID(),
                    //     'CHECKTIME' => new DateTime($attendace['timestamp']),
                    // ]);

                    $sn = $pointeuse["id_pointeuse"];
                    $userid = $userInfo[0]["userid"];
                    $CHECKTIME = $attendace['timestamp'];
                    $memoinfo = $promotion->getFormation()->getEtablissement()->getAbreviation();
                    // dd($CHECKTIME);

                    $requete = "SELECT * FROM `checkinout` WHERE sn = '$sn' AND userid = '$userid' AND checktime = '$CHECKTIME' LIMIT 1";

                    $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                    $newstmt = $stmt->executeQuery();   
                    $checkIIN = $newstmt->fetchAll();

                    // dd($checkIIN);

                    // if ($attendace['id'] == 9299) {
                    //     dd($checkIIN,$pointeuse->getIdPointeuse(),$userInfo->getUSERID());
                    // }
                    if (!$checkIIN) {
                        $requete = "INSERT INTO `checkinout`(`userid`, `checktime`, `memoinfo`, `sn`) VALUES ('$userid','$CHECKTIME','$memoinfo','$sn')";

                        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                        $newstmt = $stmt->executeQuery();   
                        $result = $newstmt->fetchAll();

                        // $checkin = new Checkinout();
                        // $checkin->setUSERID($userInfo->getUSERID());
                        // $checkin->setCHECKTIME(new DateTime($attendace['timestamp']));
                        // $checkin->setMemoinfo($promotion->getFormation()->getEtablissement()->getAbreviation());
                        // $checkin->setSN($pointeuse->getIdPointeuse());
                        // $this->em->persist($checkin);
                    }
                }
            }
        }
        array_push($sns,$pointeuse["id_pointeuse"]);



        $html =  $this->render('tables/table_pointage.html.twig', [
            'data' => $data
        ])->getContent();

        return new JsonResponse($html,200);
    }

    
}
