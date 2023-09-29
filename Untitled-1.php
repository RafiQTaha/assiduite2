#[Route('/pdfsynthese/{datetoday}', name: 'pdfsynthese')]
public function pdfsynthese($datetoday)
{

    ini_set("pcre.backtrack_limit", "5000000");

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