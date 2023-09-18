<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use DateTime;
use App\Entity\PFrais;
use App\Entity\AcAnnee;
use App\Entity\PGroupe;
use App\Entity\XBanque;
use App\Entity\AcModule;
use App\Entity\ExGnotes;
use App\Entity\Mouchard;
use App\Entity\Sanction;
use App\Entity\UsModule;
use App\Entity\AcElement;
use App\Entity\AcEpreuve;
use App\Entity\Agression;
use App\Entity\TEtudiant;
use App\Entity\AcSemestre;
use App\Entity\POrganisme;
use App\Entity\TAdmission;
use App\Entity\AcFormation;
use App\Entity\AcPromotion;
use App\Entity\UsOperation;
use App\Entity\TInscription;
use App\Entity\UsSousModule;
use App\Entity\NatureDemande;
use App\Entity\SousAgression;
use App\Entity\TOperationcab;
use App\Entity\PNatureEpreuve;
use App\Entity\AcEtablissement;
use App\Entity\PAnonymatActuel;
use App\Entity\PrProgrammation;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ApiController extends AbstractController
{
    private $em;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
        // $this->emUniv = $doctrine->getManager("univ");
        // $em = $this->getDoctrine()->getManager();
    }
    #[Route('/etablissement', name: 'getetablissement')]
    public function getetbalissement(): Response
    {
        $etbalissements = $this->em->getRepository(AcEtablissement::class)->findBy(['active'=>1]);
        $data = self::dropdown($etbalissements,'Etablissement');
        return new JsonResponse($data);
    }
    #[Route('/formation/{id}', name: 'getformation')]
    public function getformation($id): Response
    {
        $formations = $this->em->getRepository(AcFormation::class)->findBy(['etablissement'=>$id, 'active' => 1],['id'=>'ASC']);
        $data = self::dropdown($formations,'Formation');
        return new JsonResponse($data);
    }

    
    #[Route('/promotion/{formation}', name: 'getPromotion')]
    public function getPromotion($formation): Response
    {   
        $promotions = $this->em->getRepository(AcPromotion::class)->findBy(['formation'=>$formation, 'active' => 1],['id'=>'ASC']);
        // dd($promotions);
        $data = self::dropdown($promotions,'promotion');
        return new JsonResponse($data);
    }
    #[Route('/annee/{id}', name: 'getAnnee')]
    public function getAnnee($id): Response
    {   
        $annee = $this->em->getRepository(AcAnnee::class)->findBy(['formation'=>$id, 'active' => 1],['designation'=>'DESC']);
        $data = self::dropdown($annee,'Annee');
        return new JsonResponse($data);
    }
    
    #[Route('/semestre/{id}', name: 'getSemestre')]
    public function getSemestre($id): Response
    {   
        $semestre = $this->em->getRepository(AcSemestre::class)->findBy(['promotion'=>$id, 'active' => 1],['designation'=>'ASC']);
        $data = self::dropdown($semestre,'Semestre');
        return new JsonResponse($data);
    }

    #[Route('/module/{id}', name: 'getModule')]
    public function getModule($id): Response
    {   
        $module = $this->em->getRepository(AcModule::class)->findBy(['semestre'=>$id, 'active' => 1],['designation'=>'ASC']);
        $data = self::dropdown($module,'Module');
        return new JsonResponse($data);
    }

    #[Route('/element/{id}', name: 'getElement')]
    public function getElement($id): Response
    {   
        $element = $this->em->getRepository(AcElement::class)->findBy(['module'=>$id, 'active' => 1],['designation'=>'ASC']);
        $data = self::dropdown($element,'Element');
        return new JsonResponse($data);
    }

    #[Route('/enseignantsByProgramme/{element}/{nature_epreuve}', name: 'enseignantsByProgramme')]
    public function enseignantsByProgramme(AcElement $element,PNatureEpreuve $nature_epreuve): Response
    {   
        $annee = $this->em->getRepository(AcAnnee::class)->findOneBy([
            'formation'=>$element->getModule()->getSemestre()->getPromotion()->getFormation(),
            'validation_academique' => 'non'
        ]);
        $programmation = $this->em->getRepository(PrProgrammation::class)->findOneBy([
            'element'=> $element,
            'nature_epreuve' => $nature_epreuve,
            'annee' =>  $annee]
        );
        
        $data = "<option enabled value='' disabled='disabled'>Choix Enseignants</option>";
        if ($programmation != NULL) {
            foreach ($programmation->getEnseignants() as $enseignant) {
                $data .="<option value=".$enseignant->getId().">".$enseignant->getNom()." ".$enseignant->getPrenom()."</option>";
            }
        }
        return new JsonResponse($data);
    }
    
    #[Route('/nature_demande', name: 'nature_demande')]
    public function getnature_demande(): Response
    {
        $nature = $this->em->getRepository(NatureDemande::class)->findBy(['active' => 1]);
        $data = self::dropdown($nature,'Nature De Demande');
        return new JsonResponse($data);
    }

    #[Route('/anneeProgrammation/{formation}', name: 'anneeProgrammation')]
    public function anneeProgrammation(AcFormation $formation): Response
    {   
        $annee = $this->em->getRepository(AcAnnee::class)->findBy(['formation'=>$formation,'active'=>1],['id'=>'DESC'],4);
        $data = self::dropdown($annee,'Annee');
        return new JsonResponse($data);
    }
    #[Route('/formationAndanneeOuverte/{formation}', name: 'formationAndanneeOuverte')]
    public function formationAndanneeOuverte(AcFormation $formation): Response
    {   
        $annee = $this->em->getRepository(AcAnnee::class)->getActiveAnneeByFormation($formation);
        $data = [   'formation' => $formation->getDesignation(),
                    'annee' => $annee->getDesignation()];
        return new JsonResponse($data);
    }
    
    #[Route('/anneeresidanat/{id}', name: 'anneeResidanat')]
    public function anneeResidanat(AcFormation $formation): Response
    {   
        // if((strpos($formation->getDesignation(), 'Résidanat') === false) && $formation->getEtablissement()->getId() != 25){
        if((strpos($formation->getDesignation(), 'Résidanat') === false) && $formation->getEtablissement()->getId() != 25){
            return new JsonResponse(1);
        }else{
            $annee = $this->em->getRepository(AcAnnee::class)->findBy(['formation'=>$formation],['id'=>'DESC'],3);
            $data = self::dropdown($annee,'Annee');
            return new JsonResponse($data);
        }
        
    }
    #[Route('/organisme', name: 'getorganisme')]
    public function getOrganisme(): Response
    {   
        $organisme = $this->em->getRepository(POrganisme::class)->findBy(['active'=>1]);
        $data = self::dropdown($organisme,'organisme');
        return new JsonResponse($data);        
    }
    
    #[Route('/getorganismepasPayant', name: 'getorganismepasPayant')]
    public function getOrganismepasPayant(): Response
    {  
        //  dd('test');
        $organisme = $this->em->getRepository(POrganisme::class)->getorganismepasPayant();
        // dd($organisme);
        $data = self::dropdown($organisme,'organisme');
        return new JsonResponse($data);        
    }

    // #[Route('/organisme/{operationcab}', name: 'getOrganismeByoperation')]
    // public function getOrganismeByoperation(TOperationcab $operationcab): Response
    // {   
    //     $organismes = $this->em->getRepository(POrganisme::class)->findBy(['active'=>1]);
    //     $data = "<option selected disabled value=''>Choix Organisme</option>";
    //     foreach ($organismes as $organisme) {
    //         if ($organisme === $operationcab->getOrganisme()) {
    //             $data .="<option selected value=".$organisme->getId().">".$organisme->getDesignation()."</option>";
    //         }else{
    //             $data .="<option value=".$organisme->getId().">".$organisme->getDesignation()."</option>";
    //         }
    //     }
    //     return new JsonResponse($data);        
    // }
    
    #[Route('/nature_etudiant/{admission}', name: 'getnatureetudiant')]
    public function getNatureEtudiant(TAdmission $admission): Response
    {   
        $nature = $admission->getPreinscription()->getEtudiant()->getNatureDemande()->getDesignation();
        // dd($nature);
        if ($nature !== 'Payant') {
            $organisme = $this->em->getRepository(POrganisme::class)->findAll();
        }else {
            $organisme = [];
        }
        $data = self::dropdown($organisme,'organisme');
        return new JsonResponse($data);        
    }
    #[Route('/frais/{admission}', name: 'getFraisByFormation')]
    public function getFraisByFormation(TAdmission $admission): Response
    {   
        $formation = $admission->getPreinscription()->getAnnee()->getFormation();
        $operationcab = $this->em->getRepository(TOperationcab::class)->findOneBy(['preinscription'=>$admission->getPreinscription(),'categorie'=>'admission']);
        $frais = $this->em->getRepository(PFrais::class)->findBy(["formation" => $formation, 'categorie' => "admission",'active'=>1]);
        $data = self::dropdownData($frais,'frais');
                
        return new JsonResponse(['list' => $data, 'codefacture' => $operationcab->getCode()]);        
    }
  
    #[Route('/banque', name: 'getbanque')]
    public function getbanque(): Response
    {
        $banques = $this->em->getRepository(XBanque::class)->findAll();
        $data = self::dropdown($banques,'Banque');
        return new JsonResponse($data);
    }
  
    #[Route('/paiement', name: 'getpaiement')]
    public function getpaiement(): Response
    {
        $paiements = $this->em->getRepository(XModalites::class)->findAll();
        $data = self::dropdown($paiements,'Type De Paiement');
        return new JsonResponse($data);
    }
    #[Route('/nature_erpeuve/{nature}', name: 'getNatureEpreuveByNature')]
    public function getNatureEpreuveByNature($nature): Response
    {   
        $natrueEpreuves = $this->em->getRepository(PNatureEpreuve::class)->findBy(["nature" => $nature]);
        $data = self::dropdown($natrueEpreuves,'nature epreuve');
        return new JsonResponse($data);        
    }
    
    #[Route('/niv1/{promotion}', name: 'getNiv1Bypromotion')]
    public function getNiv1Bypromotion(AcPromotion $promotion): Response
    {   
        $annee = $this->em->getRepository(AcAnnee::class)->getActiveAnneeByFormation($promotion->getFormation());
        $inscriptions = $this->em->getRepository(TInscription::class)->getNiveaux($promotion,$annee);
        $data = "<option selected enabled value=''>Choix Niveau 1</option>";
        $groupes = [];
        foreach ($inscriptions as $inscription) {
            $groupe = $inscription->getGroupe();
            // if ($groupe != Null) {
                if ($groupe->getGroupe() == Null) {
                    if (!in_array($groupe, $groupes)){
                        array_push($groupes,$groupe);
                    }
                    // $data .="<option value=".$groupe->getId().">".$groupe->getNiveau()."</option>";
                }elseif ($groupe->getGroupe()->getGroupe() == Null) {
                    $groupe = $groupe->getGroupe();
                    if (!in_array($groupe, $groupes)){
                        array_push($groupes,$groupe);
                    }
                    // $data .="<option value=".$groupe->getId().">".$groupe->getNiveau()."</option>";
                }else {
                    $groupe = $groupe->getGroupe()->getGroupe();
                    if (!in_array($groupe, $groupes)){
                        array_push($groupes,$groupe);
                    }
                    // $data .="<option value=".$groupe->getId().">".$groupe->getNiveau()."</option>";
                }
                
                // $data .="<option value=".$groupe->getId().">".$groupe->getNiveau()."</option>";
                
            // }
        }
        foreach ($groupes as $groupe) {
            $data .="<option value=".$groupe->getId().">".$groupe->getNiveau()."</option>";
        }
        return new JsonResponse($data);
    }

    #[Route('/niv2/{niv1}', name: 'getNiv2ByNiv1')]
    public function getNiv2ByNiv1(PGroupe $niv1): Response
    {   
        $niveaux2 = $this->em->getRepository(PGroupe::class)->findBy(['groupe'=>$niv1]);
        $data = "<option selected enabled value=''>Choix Niveau 2</option>";
        foreach ($niveaux2 as $niveau2) {
                $data .="<option value=".$niveau2->getId().">".$niveau2->getNiveau()."</option>";
        }
        return new JsonResponse($data);     
    }

    #[Route('/niv3/{niv2}', name: 'getNiv2ByNiv3')]
    public function getNiv2ByNiv3($niv2): Response
    {   
        // $niveaux3 = $this->em->getRepository(PGroupe::class)->findBy(['groupe'=>$niv2]);
        $niveaux3 = $this->em->getRepository(PGroupe::class)->getInscriptionsByNiveaux3($niv2);
        // dd($niveaux3);
        $data = "<option selected enabled value=''>Choix Niveau 3</option>";
        foreach ($niveaux3 as $niveau3) {
                $data .="<option value=".$niveau3->getId().">".$niveau3->getNiveau()."</option>"; 
        }
        return new JsonResponse($data);       
    } 
    #[Route('/salle/{promotion}', name: 'getSalle')]
    public function getSalle(AcPromotion $promotion): Response
    {   
        $annee = $this->em->getRepository(AcAnnee::class)->getActiveAnneeByFormation($promotion->getFormation());
        // dump($annee->getId(), $promotion->getId());
        $salles = $this->em->getRepository(TInscription::class)->getSalle($promotion, $annee);
        // dd($salles);
        $data = "<option selected enabled value=''>Choix Salle</option>";
        foreach ($salles as $salle) {
            $sallearray = explode("-", $salle['salle']);
            $data .="<option value='".$salle['salle']."'>".$sallearray[0]." ". $sallearray[1] ."</option>";
            // dd($data);
         }
        return new JsonResponse($data);
    }
    
    #[Route('/changeAnonymat', name: 'changeAnonymat')]
    public function changeAnonymat(Request $request): Response
    {   
        $anonymatActuel = $this->em->getRepository(PAnonymatActuel::class)->find(1);
        $an_actuel = "";
        if ($request->get('anonymat') == 0) {
            $anonymatActuel->setDesignation('Anonymat');
            $anonymatActuel->setAbreviation('anonymat');
            $an_actuel = "Anonymat Actuel: <span style='text-transform: uppercase;font-weight: 800;color:green'>anonymat</span>";
        }else{
            $anonymatActuel->setDesignation('Anonymat Ratrappage');
            $anonymatActuel->setAbreviation('anonymatrat');
            $an_actuel = "Anonymat Actuel: <span style='text-transform: uppercase;font-weight: 800;color:orange'>anonymatrat</span>";
        }
        $anonymatActuel->setCreated(new DateTime('now'));
        $anonymatActuel->setUserCreated($this->getUser());
        if ($an_actuel != "") {
            $this->em->flush();
        }
        return new JsonResponse($an_actuel,200);
    }
    
    #[Route('/sousagression/{agression}', name: 'getsousagression')]
    public function getsousagression(Agression $agression): Response
    {   
        $sousagression = $this->em->getRepository(SousAgression::class)->findBy(['agression'=>$agression, 'active' => 1],['designation'=>'ASC']);
        $data = self::dropdown($sousagression,'Incident');
        return new JsonResponse($data);
    }
    #[Route('/sanction/{agression}', name: 'getsanction')]
    public function getsanction(Agression $agression): Response
    {   
        $sanctions = $this->em->getRepository(Sanction::class)->findBy(['agression'=>$agression, 'active' => 1],['designation'=>'ASC']);
        // $data = self::dropdown($sanctions,'Sanction');
        // $data = "<option selected enabled value=''>Choix ".$choix."</option>";
        $data ="";
        foreach ($sanctions as $sanction) {
            $data .="<option value=".$sanction->getId().">".$sanction->getDesignation()."</option>";
         }
        //  return $data;
        return new JsonResponse($data);
    }
    
    // #[Route('/findSemaine', name: 'findSemaine')]
    // public function findSemaine(Request $request): Response
    // {
    //     dd($request->query->get("search"));
    //     $semaines = $this->em->getRepository(Semaine::class)->findSemaine($request->query->get("search"));
    //     $html = '<option value="">Choix semaine</option>';
    //     foreach ($semaines as $semaine) {
    //         // $html .= '<option value='.$semaine->getId().'>Semaine '.$semaine->getNsemaine().' de: '..' à '..{{semaine.datefin | date('j/m')}} {{semaine.datefin | date('Y')}}</option>'
    //         $html .= '<option value='.$semaine->getId().'>Semaine '.$semaine->getNsemaine().' de: '.$semaine->getDateDebut()->format('j/m').' à '.$semaine->getDateFin()->format('j/m').'</option>';
    //     }
    //     dd($html);
    //     // dd($admissions);
    //     // return new Response(json_encode($admissions));
    // }

    static function dropdown($objects,$choix)
    {
        $data = "<option selected enabled value=''>Choix ".$choix."</option>";
        foreach ($objects as $object) {
            $data .="<option value=".$object->getId().">".$object->getDesignation()."</option>";
         }
         return $data;
    }
    static function dropdownData($objects,$choix)
    {
        $data = "<option selected enabled value=''>Choix ".$choix."</option>";
        foreach ($objects as $object) {
            $data .="<option value=".$object->getId()." data-frais=".$object->getMontant().">".$object->getDesignation()."</option>";
         }
         return $data;
    }
    static function dropDownSelected($objects,$choix, $value)
    {
        $data = "<option selected enabled value=''>Choix ".$choix."</option>";
        foreach ($objects as $object) {
            if($object->getId() === $value->getId()) {
                $data .="<option value=".$object->getId()." selected>".$object->getDesignation()."</option>";
            } else {
                $data .="<option value=".$object->getId()." >".$object->getDesignation()."</option>";
            }
         }
         return $data;
    }

    static function check($user, $link, $em, $request) {
        if(!$request->getSession()->get("modules")){
            if(in_array('ROLE_ADMIN', $user->getRoles())){
                $sousModules = $em->getRepository(UsSousModule::class)->findBy([],['ordre'=>'ASC']);
            } else {
                $sousModules = $em->getRepository(UsSousModule::class)->findByUserOperations($user);
            }
            $modules = $em->getRepository(UsModule::class)->getModuleBySousModule($sousModules);
            $data = [];
            foreach($modules as $module) {
                $sousModuleArray = [];
                foreach ($sousModules as $sousModule) {
                    if($sousModule->getModule()->getId() == $module->getId()) {
                        array_push($sousModuleArray,$sousModule);
                    }
                }
                array_push($data, [
                    'module' => $module,
                    'sousModule' => $sousModuleArray
                ]);
            }
            // dd($data);
            $request->getSession()->set('modules', $data);
            
        }
        if(in_array('ROLE_ADMIN', $user->getRoles())) {
            $operations = $em->getRepository(UsOperation::class)->findAllBySousModule($link);
            return $operations;
        }
        $operations = $em->getRepository(UsOperation::class)->getOperationByLinkSousModule($user, $link);
        return $operations;
    }
    
    static function mouchard($user,$em,$object,$table,$action)
    {
        $entity = "App\Entity\\".$table;
        $array = (array) $object;
        foreach ($array as $key => $value) {
            if (!is_object($value)) {
                $nkey = str_replace($entity, '', $key) ;
                $nkey = preg_replace('/[\x00-\x1F\x7F]/u', '', $nkey);
                $array[$nkey] = $array[$key];
            }
            unset($array[$key]);
        }
        $mouchard = new Mouchard();
        $mouchard->setCreated(new \DateTime('now'));
        $mouchard->setUserCreated($user);
        $mouchard->setObservation($array);
        $mouchard->setFromTable($table);
        $mouchard->setAction($action);
        $em->persist($mouchard);
        $em->flush();
    }
    
    // /**
    //  * @Route("/gnote", name="app_gnote")
    //  */
    // public function Gnotes(): Response
    // {
    //     //1560650 last id i get
    //     $emUniv = $this->emUniv;   
    //     $gnotes ="SELECT
    //                 ex_gnotes.id as id,
    //                 note,
    //                 absent as absence,
    //                 ex_gnotes.observation,
    //                 ex_gnotes.date_creation as created ,
    //                 ex_gnotes.anonymat,
    //                 ac_epreuve.id_epreuve as epreuve_id,
    //                 t_inscription.id_inscription as inscription_id
    
    //             FROM `ex_gnotes`
    //                 INNER JOIN ac_epreuve  on ac_epreuve.code =ex_gnotes.code_epreuve
    //                 INNER JOIN t_inscription  on t_inscription.code = ex_gnotes.code_inscription
    //                 INNER JOIN ac_annee  on ac_annee.code = t_inscription.code_annee
    //                 where ac_annee.designation= '2021/2022'";

    //     $result = $emUniv->getConnection()->prepare($gnotes);
    //     $stmt = $result->executeQuery();
    //     $resulta = $stmt->fetchAll();

    //     //  dd($resulta);
    //     foreach ($resulta as $data)
    //     { 
    //         //   dd($data['created']);
    //         $epreuve = $this->em->getRepository(AcEpreuve::class)->find($data['epreuve_id']);
    //         $inscription = $this->em->getRepository(TInscription::class)->find($data['inscription_id']);
    //         $gnote = new ExGnotes();
    //         $gnote->setEpreuve($epreuve);
    //         $gnote->setId($data['id']);
    //         $gnote->setInscription($inscription);
    //         $gnote->setUserCreated($this->getUser());
    //         $gnote->setCreated(new \DateTime($data['created']));
    //         $gnote->setAnonymat($data['anonymat']);     
    //         $gnote->setNote($data['note']);
    //         $gnote->setAbsence($data['absence']);
    //         $gnote->setObservation($data['observation']);
    //         $this->em->persist($gnote);
    //     }
    //     $this->em->flush();
  
    //     // return $this->render('gnote/index.html.twig', [
    //     //     'controller_name' => 'GnoteController',
    //     // ]);
    //     return new Response('good');
    // }


    // ::::::::::::::::::::::::: for evasym
    // /**
    //  * @Route("/getExtractionByAmine", name="getExtractionByAmine")
    //  */
    // public function getExtractionByAmine() {
    //     //   die("amine");
    //        $sql = "select epreuve.designation, t_inscription.code_admission, t_etudiant.nom, t_etudiant.prenom,
    //        epreuve_etudiant_correction.note, question.id,  question.libelle, 
    //         epreuve_etudiant_correction_detail.reponses
              
    //           from epreuve_etudiant_correction
    //           inner join epreuve on epreuve.id = epreuve_etudiant_correction.epreuve_id
    //           inner join t_inscription on t_inscription.id = epreuve_etudiant_correction.t_inscription_id
    //           inner join t_admission on t_admission.id = t_inscription.t_admission_id
    //           inner join t_preinscription on t_preinscription.id = t_admission.t_preinscription_id
    //           inner join t_etudiant on t_etudiant.id = t_preinscription.t_etudiant_id
    //           inner join epreuve_etudiant_correction_detail on epreuve_etudiant_correction_detail.epreuve_etudiant_correction_id = epreuve_etudiant_correction.id
    //           inner join question on question.id = epreuve_etudiant_correction_detail.question_id
              
    //           where epreuve.id in (582)";
    //       $conn = $this->em->getConnection();
    //       $stmt = $conn->prepare($sql)->executeQuery();
    //     //   $stmt->executeQuery();
          
    //     //   $stmt = $this->em->getConnection()->prepare($sql);
    //     //   $stmt = $stmt->executeQuery();
    //     //   $semaine = $resultSet->fetchAll();
    //       $etudiants = $stmt->fetchAll();
    //     //   dd($etudiants);
          
    //       $spreadsheet = new Spreadsheet();
    //     //   die("amine");
    //       $sheet = $spreadsheet->getActiveSheet();
    //       $sheet->setCellValue('A1', 'Epreuve');
    //       $sheet->setCellValue('B1', 'Code Admission');
    //       $sheet->setCellValue('C1', 'Nom');
    //       $sheet->setCellValue('D1', 'Prenom');
    //       $sheet->setCellValue('E1', 'Note');
    //       $sheet->setCellValue('F1', 'id');
    //       $sheet->setCellValue('G1', 'libelle');
    //       $sheet->setCellValue('H1', 'Reponses Etudiant');
    //       $sheet->setCellValue('I1', 'Reponses Correct');
    //       $rowCount = 2;
    //       foreach($etudiants as $etudiant) {
    //          //  dd($etudiant);
    //           $i = 0;
    //           $letters = "";
    //           $var = explode(";",$etudiant['reponses']);
    //           foreach($var as $v){
    //               if($i > 0) {
    //                   $num = explode(":", $v);
    //                   if(isset($num[1])) {
    //                       if($num[1] > 400){
    //                           //dd("select lettre from question_choix where id = $num[1]");
    //                           $sql1 = "select lettre from question_choix where id = $num[1]";
    //                           $stmt1 = $conn->prepare($sql1)->executeQuery();
    //                         //   $stmt1->executeQuery();
    //                          //  dd($stmt1->fetch()['lettre']);
    //                          $letters .= $stmt1->fetch()['lettre'].",";
    //                       }
    //                   }
    //               }
    //               $i++;
    //           }
    //          $id = $etudiant['id'];
    //          $sql2 = "select lettre from question_choix where reponse = 1 and question_id = $id ";
    //          $stmt2 = $conn->prepare($sql2)->executeQuery();
    //         //  $stmt2->execute();
    //          $reponses = $stmt2->fetchAll();
    //          $lettreReponse = "";
    //          foreach($reponses as $reponse) {
    //              $lettreReponse .= $reponse['lettre'].",";
    //          }
    //          $sheet->setCellValue('A' . $rowCount, $etudiant['designation']);
    //          $sheet->setCellValue('B' . $rowCount, $etudiant['code_admission']);
    //          $sheet->setCellValue('C' . $rowCount, $etudiant['nom']);
    //          $sheet->setCellValue('D' . $rowCount, $etudiant['prenom']);
    //          $sheet->setCellValue('E' . $rowCount, $etudiant['note']);
    //          $sheet->setCellValue('F' . $rowCount, $etudiant['id']);
    //          $sheet->setCellValue('G' . $rowCount,  $etudiant['libelle']);
    //          $sheet->setCellValue('H' . $rowCount,  $letters);
    //          $sheet->setCellValue('I' . $rowCount,  $lettreReponse);
             
    //          $rowCount++;
    //      }
         
         
    //      $writer = new Xlsx($spreadsheet);
    //      $fileName = 'exctraction_epreuve.xlsx';
    //      $temp_file = tempnam(sys_get_temp_dir(), $fileName);
    //      $writer->save($temp_file);
    
    //      return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
            
    //     }
}
