<?php

namespace App\Controller;

use App\Entity\AcEtablissement;
use App\Entity\PSalles;
use App\Entity\Machines;
use App\Entity\PlEmptime;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

require '../zklibrary.php';
class ImportController extends AbstractController
{
    private $em;
    private $emAssiduite;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
        $this->emAssiduite = $doctrine->getManager('assiduite');
    }

    #[Route('/', name: 'app_import')]
    public function index(): Response
    {
        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
        ]);
    }

    #[Route('/importPointeuse', name: 'importPointeuse')]
    public function importPointeuse(): Response
    {
        // $ids = ['52284'];
        // $ids = ['52064','52085'];
        // $dateD = date('Y-m-d 00:00:00');
        // $dateF = date('Y-m-d 23:59:59');
        // dd($dateD,$dateF);
        // $emptimes = $this->em->getRepository(PlEmptime::class)->getEmptimeByCurrentDay($dateD,$dateF);
        $emptimes = $this->em->getRepository(PlEmptime::class)->getEmptimeByCurrentDay();
        // $emptimes = $this->em->getRepository(PlEmptime::class)->findBy(['id'=>$ids]);
        dd($emptimes);
        $counter = 0;
        foreach ($emptimes as $emptime) {
            $element = $emptime->getProgrammation()->getElement();
            $promotion = $element->getModule()->getSemestre()->getPromotion();
            $salle = $emptime->getXsalle();
            // dd($salle->getCode());
            // $pointeuses = $this->em->getRepository(ISeanceSalle::class)->findBy(['code_salle'=>$salle->getCode()]);

            $code_salle = $salle->getCode();
            $requete = "SELECT * FROM `iseance_salle` where code_salle like '$code_salle'";

            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
            $newstmt = $stmt->executeQuery();   
            $pointeuses = $newstmt->fetchAll();

            // $sns = [];
            $dateSeance = $emptime->getStart()->format('Y-m-d');
            // dd($pointeuses);
            foreach ($pointeuses as $pointeuse) {
                $id_pointeuse = $pointeuse["id_pointeuse"];
                $requete = "SELECT * FROM `machines` where sn = '$id_pointeuse' LIMIT 1";

                $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                $newstmt = $stmt->executeQuery();   
                $machine = $newstmt->fetchAll();

                // $machine = $this->em->getRepository(Machines::class)->findOneBy(['sn'=>$pointeuse->getIdPointeuse()]);
                if (!$machine) {
                    continue;
                }
                $zk = new \ZKLibrary($machine[0]["ip"], 4370);
                $zk->connect();
                $attendaces = $zk->getAttendance($dateSeance);
                // dd($attendaces);
                // dd($pointeuse->getIdPointeuse(),$attendaces[0]['timestamp']);
                $zk->disconnect();
                if ($attendaces) {
                    foreach ($attendaces as $attendace) {
                        // $userInfo = $this->em->getRepository(Userinfo::class)->findOneBy(['Badgenumber'=>$attendace['id']]);

                        $badgenumber = $attendace['id'];

                        $requete = "SELECT * FROM `userinfo` where badgenumber = '$badgenumber' LIMIT 1";

                        $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                        $newstmt = $stmt->executeQuery();   
                        $userInfo = $newstmt->fetchAll();

                        if ($userInfo) {
                            

                            $sn = $pointeuse["id_pointeuse"];
                            $userid = $userInfo[0]["userid"];
                            $CHECKTIME = $attendace['timestamp'];
                            $memoinfo = $promotion->getFormation()->getEtablissement()->getAbreviation();
                            // dd($CHECKTIME);

                            $requete = "SELECT * FROM `checkinout` WHERE sn = '$sn' AND userid = '$userid' AND checktime = '$CHECKTIME' LIMIT 1";

                            $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                            $newstmt = $stmt->executeQuery();   
                            $checkIIN = $newstmt->fetchAll();
                            
                            if (!$checkIIN) {
                                $requete = "INSERT INTO `checkinout`(`userid`, `checktime`, `memoinfo`, `sn`) VALUES ('$userid','$CHECKTIME','$memoinfo','$sn')";

                                $stmt = $this->emAssiduite->getConnection()->prepare($requete);
                                $newstmt = $stmt->executeQuery();   
                                $result = $newstmt->fetchAll();
                                $counter++;
                            }
                        }
                    }
                }
                // array_push($sns,$pointeuse["id_pointeuse"]);
            }
        }
        return new JsonResponse('Nombre des pointages Importer est: '.$counter,200);
        dd($emptime);
    }
}
