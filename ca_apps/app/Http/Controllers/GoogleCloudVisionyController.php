<?php

namespace App\Http\Controllers;
// namespace Google\Cloud\Samples\Vision;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use File;
use Illuminate\Http\Request;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Core\ServiceBuilder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Cars;
use App\Models\CarBrands;
use App\Models\CarModels;
use App\Models\Primenergie;
use App\Models\CarsValues;
use Storage;
use Google\Cloud\Vision\VisionClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

    
class GoogleCloudVisionyController extends Controller
{
    //

    public function detecttext(request $request){



    // $imageAnnotator = new ImageAnnotatorClient();

    // # annotate the image

    // $path  =public_path('assets/images/cg.png');

    // $image = file_get_contents($path);
    // $response = $imageAnnotator->textDetection($image);
    // $texts = $response->getTextAnnotations();

    // printf('%d texts found:' . PHP_EOL, count($texts));
    // foreach ($texts as $text) {
    //     print($text->getDescription() . PHP_EOL);

    //     # get bounds
    //     $vertices = $text->getBoundingPoly()->getVertices();
    //     $bounds = [];
    //     foreach ($vertices as $vertex) {
    //         $bounds[] = sprintf('(%d,%d)', $vertex->getX(), $vertex->getY());
    //     }
    //     print('Bounds: ' . join(', ', $bounds) . PHP_EOL);
    // }

    // $imageAnnotator->close();

        $dir="scancg/";
         // $imgattesation = $request->file('Imgattesation');
         $imgcartegrise = $request->file('Imgcartegrise');
         $url_attestationassurance ='';
         $urlcarte_grise='';


        $returnedToken = 'ya29.a0Ad52N3-g9x_1zbu83cVJPh-iYyHwgb21Rzj3QHVk5mMvltR0igyWHG5gBSMplwaG2u4J8EKWRToiEB2n7HHEQsgbY7f8P0zz7pzga8xBITmhznmtmvjnpONzIgcqSFlDyywKh5--ewBxqmwn15Sta9CgY3ZgcQxMsMqOEiKAtuYaCgYKAW4SARASFQHGX2MigKUbn2xZmmT8DZQjxL8Qhw0178';

       // $image = base64_encode(file_get_contents($request->file('image')->path()));

       // $imagePath =public_path('assets/images/cg.png'); 
       // $image = base64_encode(file_get_contents($imagePath));


       if ($request->hasFile('Imgcartegrise')) {
                $imageCartegriseName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgcartegrise->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageCartegriseName, file_get_contents($imgcartegrise));
                // $urlcarte_grise = '/storage/scancg/'.$imageCartegriseName;
                $urlcarte_grise = $imageCartegriseName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            // return response()->json(['message' => 'failed to upload carte grise'], 400);
            $typeError[]=2;
        }



        //$imagePath =public_path('assets/images/cg.png'); 
       // $image = base64_encode(file_get_contents('scancg/'.$imageCartegriseName));
    //dd($urlcarte_grise);
       // $link= Storage::get('scancg/'.$urlcarte_grise);

        // $link= Storage::get('scancg/cg.png');
        
     // dd($link);
        // $image = base64_encode(file_get_contents($link));
       

      // dd($image);

        $imagePath =public_path('assets/images/ncg.png'); 
       $image = base64_encode(file_get_contents($imagePath));
      // $image = base64_encode($imgcartegrise);


      
       // dd($image);

        // $link= Storage::disk('public')->get('scancg/'.$urlcarte_grise);
        // $image = base64_encode(($link));
       


                $client0 = new Client;
                $response0 = $client0->request('POST','https://vision.googleapis.com/v1/images:annotate', [
                          'headers' => [
                               'Authorization' => 'Bearer '.$returnedToken,
                               // 'Authorization' => "Bearer $(gcloud auth print-access-token)",
                               'x-goog-user-project' => 'dev-antler-418219',
                               'Content-Type' => 'application/json; charset=utf-8',
                           ],
                           'json' => [
                                 "requests" => [
                                         [
                                            "image" => [
                                               "content" => $image 
                                            ], 
                                            "features" => [
                                                  [
                                                     "type" => "TEXT_DETECTION" 
                                                  ] 
                                               ] 
                                         ] 
                                      ] 
                                ] 
                       ]);
                

               
                  $response_api0 = json_decode($response0->getBody(), true);

                 // dd($response_api0);

                  // $textdata = $response_api0 ['responses'][0]['fullTextAnnotation']['text'];
                  $textdata = $response_api0 ['responses'][0]['textAnnotations'][0]['description'];
                    //dd($textdata);

                  $cleantextdata=  str_replace('"""', '',$textdata);
                  $arraytext = explode("\n", $cleantextdata);

                     // dd($arraytext);

                  // $proprietaire = $arraytext[7];
                     $proprietaire = $arraytext[14];
                  $immatriculation = $arraytext[2];
                  $carburant = $arraytext[27];
                  $nbreplace = $arraytext[35];
                  $puissance = $arraytext[36];
                  $modele = $arraytext[21];
                  $misecirculation = $arraytext[15];
                  $marque = $arraytext[17];


                  // dd($immatriculation);

                  return 'successfull*'.$proprietaire.'*'.$immatriculation.'*'.$carburant.'*'.$nbreplace.'*'.$puissance.'*'.$modele.'*'.$misecirculation.'*'.$marque;



     }


     public function detecttext_form (request $request){

        // file_get_contents('pu/scancg/2024-03-26-6602db400c65f.png');

        // file_get_contents(asset('scancg/2024-03-26-6602db400c65f.png'));

        //$link=storage_path('scancg/2024-03-26-6602db400c65f.png');
       //  $link=storage_path('scancg/2024-03-26-6602db400c65f.png');
        

       //  $link= Storage::disk('public')->get('scancg/2024-03-26-6602db400c65f.png');
       //  //dd($link);
       // // file_get_contents($link);

       //   $image = base64_encode($link);

       //   dd($image);

        // phpinfo();


        $returnedToken = 'ya29.a0Ad52N3-5-YAS_gtok98sxLoHfbsQ7v4WcVceLaq3iu-pg_CuABBgtNYVEPhXlaDjmaLuao27E0N44yIjhA2EU5O24G4ugqMaBV2wdgHKHhncaXWOYwYQ-mwB9pyrZgmQM3DNk-IqPhKaMXzfyyY4XUilqj7g9Djqe62GgEwRyaEaCgYKAfQSARASFQHGX2MiXoJ75QTMOTzJYVbvJ0TkDg0178';



         $imagePath =public_path('assets/images/macartegrisecopie.png'); 
       $image = base64_encode(file_get_contents($imagePath));
$client0 = new Client;
                $response0 = $client0->request('POST','https://vision.googleapis.com/v1/images:annotate', [
                          'headers' => [
                               'Authorization' => 'Bearer '.$returnedToken,
                               // 'Authorization' => "Bearer $(gcloud auth print-access-token)",
                               'x-goog-user-project' => 'dev-antler-418219',
                               'Content-Type' => 'application/json; charset=utf-8',
                           ],
                           'json' => [
                                 "requests" => [
                                         [
                                            "image" => [
                                               "content" => $image 
                                            ], 
                                            "features" => [
                                                  [
                                                     "type" => "TEXT_DETECTION" 
                                                  ] 
                                               ] 
                                         ] 
                                      ] 
                                ] 
                       ]);
                

               
                  $response_api0 = json_decode($response0->getBody(), true);

                 dd($response_api0);

                  // $textdata = $response_api0 ['responses'][0]['fullTextAnnotation']['text'];
                  $textdata = $response_api0 ['responses'][0]['textAnnotations'][0]['description'];
                    //dd($textdata);

                  $cleantextdata=  str_replace('"""', '',$textdata);
                  $arraytext = explode("\n", $cleantextdata);

                     // dd($arraytext);

                  // $proprietaire = $arraytext[7];
                     $proprietaire = $arraytext[14];
                  $immatriculation = $arraytext[2];
                  $carburant = $arraytext[27];
                  $nbreplace = $arraytext[35];
                  $puissance = $arraytext[36];
                  $modele = $arraytext[21];
                  $misecirculation = $arraytext[15];
                  $marque = $arraytext[17];



        return view('scan_cg_form');
     }



     public function detecttextinapp () {   

        $imagePath =public_path('assets/images/macartegrisecopie.png'); 
        // $imagePath =public_path('assets/images/mcg.jpg'); 

        
        

         // $imagePath =public_path('assets/images/2024-04-03-660d796f9a066.jpg'); 

        // $imagePath =public_path('assets/images/2024-04-04-660ee3ebb2d5c.jpg'); 


         $imagePath =public_path('assets/images/2024-04-04-660ee176f0f88.jpg'); 


        
         
           // $imagePath =public_path('assets/images/peujor.jpg'); 

         // $imagePath =public_path('assets/images/c200kompressor.jpg'); 

        //$imagePath =public_path('assets/images/cgtest.png'); 

        
        //$imagePath =public_path('assets/images/ncg.png'); 
        $KeyFile = public_path('assets/js/dev-antler-418219-3b3887e9ff25.json');
        $vision = new VisionClient([
            'projectId' => 'dev-antler-418219',
            'keyFilePath' => $KeyFile
        ]);

        // Annotate an image, detecting faces.
        $image = $vision->image(
            // fopen('read.png', 'r'),
            fopen($imagePath, 'r'),
            ['text']
        );

        $tadaa = $vision->annotate($image);

        $final = $tadaa->info();
        //  dd($final);
        // dd($final['textAnnotations'][0]['description']);
        $textfinal = $final['textAnnotations'][0]['description'];
        $cleantextdata=  str_replace('"""', '',$textfinal);
        $lines = explode("\n", $cleantextdata);


          //   dd($lines);

        $immatriculation="";
        $misecirculation="";
        $model="";
        $proprietaire="";
        $marque="";
        $energie="";
        $nbreplace="";
        $puissance="";

        for($i = 0; $i < count($lines); $i++) {

            if (strpos(strtolower($lines[$i]), 'type commercial') !== false){
                // dd('type '. $i);
                // $posima = strpos($textfinal, 'immatriculation');
                $marque = str_replace('Voiture', '',$lines[$i-1]) ;
                
            }

            if (strpos(strtolower($lines[$i]), 'immatriculation') !== false){
                // dd($i);
                // $posima = strpos($textfinal, 'immatriculation');
                $immatriculation = $lines[$i+1];
            }

            if (strpos(strtolower($lines[$i]), 'circulation') !== false){
                // dd($i);
                // $posima = strpos($textfinal, 'circulation');
                $misecirculation = $lines[$i+1];
            }

            if (strpos(strtolower($lines[$i]), 'couleur') !== false){
                // dd('Couleur '. $i);
                // $posima = strpos($textfinal, 'couleur');
                $model = $lines[$i-1];
            }


            if (strpos(strtolower($lines[$i]), 'carte grise') !== false){
                // dd($i);
                // $posima = strpos($textfinal, 'CARTE GRISE');
                $proprietaire = $lines[$i+1];

                if ($proprietaire == 'identité du propriétaire' || $proprietaire == 'identite du propriétaire' || $proprietaire == 'identite du proprietaire') {
                    // code...
                    $proprietaire = $lines[$i+2];
                }
            }
            


             if (strpos(strtolower($lines[$i]), 'usage') !== false){
                // dd($i);
                // $posima = strpos($textfinal, 'couleur');

               if (preg_match('/^-?\d+$/', $lines[$i+1]) ) {
                  $nbreplace = $lines[$i-1];
                }

                
            }

            if (strpos(strtolower($lines[$i]), 'fiscale') !== false){
                // dd($i);
                // $posima = strpos($textfinal, 'couleur');
               if (preg_match('/^-?\d+$/', $lines[$i+1]) ) {
                  $nbreplace = $lines[$i+1];
                  $puissance = $lines[$i+2];
                }
            }


            if (strpos($lines[$i], "d'édition") !== false){
               
               // dd( $lines[$i+1]);
                // dd(filter_var("5", FILTER_VALIDATE_INT));
                // $posima = strpos($textfinal, 'couleur');
                // if (filter_var($lines[$i+1], FILTER_VALIDATE_INT) === true ) {
                if(preg_match('/^-?\d+$/', $lines[$i+1]) ) {
                  $nbreplace = $lines[$i+1];
                  $puissance = $lines[$i+2];

                }
            }




        }

        if (strpos($cleantextdata, 'Essence') !== false){
            $energie ="Essence";
        }else
         $energie ="Gas-oil";




        dd($proprietaire.'*'.$immatriculation.'*'.$model.'*'.$misecirculation.'*'.$marque.'*'.$energie.'*'.$nbreplace.'*'.$puissance);



        echo '<pre>';
        var_dump($tadaa->text());
        echo '</pre>';



     }


     public function formulaire_cotation (request $request){

       
        $carlist = Cars::select('brand')->groupBy('brand')->get()->toArray();
      
        return view('simulation_form',compact('carlist'));
     }


     public function formulaire_cotation_sc (request $request){

      
        return view('simulation_form_manuel',);
     }

     public function create_cotation_frcg (request $request){

      $mise_circulation_cg =   $request->mise_circulation_cg;
      $marque_cg =    $request->marque_cg;
      $energie_cg =    $request->energie_cg;
      $num_matricule_cg =    $request->num_matricule_cg;
      $nbre_place_cg =    $request->nbre_place_cg;
      $puissance_cg =    $request->puissance_cg;
      $model_cg =    $request->model_cg;


        return view('simulation_form_manuel',compact('mise_circulation_cg','marque_cg','energie_cg','num_matricule_cg','nbre_place_cg','puissance_cg','model_cg'));
     }

     


     public function lecteur_carte_grise (request $request){

        

        return view('lecteur_carte_grise',);
     }



     public function formulaire_ajout_vehicule (request $request){


        $carlist = Cars::select('brand')->groupBy('brand')->get()->toArray();

         return view('ajout_vehicule_form',compact('carlist'));
     }



     public function checkmultistep (request $request){

       
        $carlist = Cars::select('brand')->groupBy('brand')->get()->toArray();
      
        return view('simulation_form_test',compact('carlist'));
     }




     public function find_carmodel (request $request){

       $brand = $request->marque;

     
         $carmodel = Cars::select('model','car_code')
         ->where([
            ['brand', '=', $brand],
            ])
         ->groupBy('model','car_code')->get()->toArray();

            // dd($carmodel);
       
         return view('carmodels',compact('carmodel'));

     }



     public function find_new_carmodel (request $request){

       $brand = $request->marque;

     
         $carmodel = Cars::select('model','car_code')
         ->where([
            ['brand', '=', $brand],
            ])
         ->groupBy('model','car_code')->get()->toArray();


         if(count($carmodel)==0)
         $carmodel = CarModels::select('marque','libelle')
         ->where([
            ['marque', '=', $brand],
            ])
         ->groupBy('marque','libelle')->get()->toArray();

            // dd($carmodel);
       
         return view('newcarmodels',compact('carmodel'));

     }


     public function calcul_cotation (request $request) {

        //les champs attendus
         // dd($request->mise_circulation);
         $marque = $request->marque;

         // dd($marque);
         $plaqueimma = $request->plaqueimma;
         $proprietaire = $request->proprietaire;
         $model = $request->model;
         $agevehicule=0;

         $valeur_neuve =0;
         $valeur_venale =0;

         $arraymodel= explode('-',$model);

         // dd($model);
         $energie = $request->energie;
         $mise_circulation = $request->mise_circulation;
         $nbreplace = $request->nbreplace;
         $puissance = $request->puissance;
         $bns = $request->bns;
         $csp = $request->csp;
         $redcom = $request->redcom;


       $arr= array('marque' => $marque,
                'plaqueimma' => $plaqueimma,
                'proprietaire' => $proprietaire,
                'model' => $model,
                'energie' => $energie,
                'mise_circulation' => $mise_circulation,
                'nbreplace' => $nbreplace,
                'puissance' => $puissance,
                'bns' => $bns,
                'csp' => $csp,
                'redcom' => $redcom,
            );
 ;
          Log::info(json_encode($arr));
         


         //correspondance energie puissance



          $prime_puissance = Primenergie::select($energie)->where('cv',$puissance)->get();

          $prime_energie=$prime_puissance[0]->$energie;



          //recupe valeur nevue



            $mise_circulation_annee = explode('-',$mise_circulation);


            $received_date= $mise_circulation_annee[0];

             // dd((int)$received_date);

            if ($received_date < 2012) {
                // code...
                $received_date ='PLUS DE 10 ANS';
            }

          //valeur neuve
            $valeurneuveDb=0;
            if( $request->valeurneuve ==null || $request->valeurneuve ==0){
          $valeur_neuve_collection = CarsValues::select('amount')->where([
            ['date',$received_date],
            ['car_code',$arraymodel[1]]
        ])->get();

           $valeurneuveDb= $valeur_neuve_collection->count();
        }

           // dd($received_date);

            $prime_finale_tiers_simple=0;
            $prime_finale_tiers_complet=0;
            $prime_finale_tiers_ameliore=0;
            $prime_finale_tout_risque=0;
            $prime_finale_tiers_collision=0;

          $currentdate = date('Y');
          $agevehicule = (int)$currentdate - (int)$mise_circulation_annee[0];


           // dd($request->valeurneuve);

      if ($valeurneuveDb > 0 || $request->valeurneuve !=null) {
               // code...
        
        if($valeurneuveDb > 0)
          $valeur_neuve = $valeurneuveDb;


      if($request->valeurneuve !=null && $request->valeurneuve > 0)
          $valeur_neuve = $request->valeurneuve ;


          //valeur venale
         

         

          // dd((int)$currentdate);
          $valeur_venale= 0;    
          switch ($agevehicule) {
              case 1:
                  // 1ans...
                  $valeur_venale = 0.15 * $valeur_neuve;
                  break;

              case 2:
                  // 2ans...
                  $valeur_venale = 0.25 * $valeur_neuve;
                  break;

              case 3:
                  // 2ans...
                  $valeur_venale = 0.35 * $valeur_neuve;
                  break;

              case 4:
                  // 4ans...
                  $valeur_venale = 0.45 * $valeur_neuve;
                  break;

               case 5:
                  // 4ans...
                  $valeur_venale = 0.55 * $valeur_neuve;
                  break;

                case 6:
                  // 4ans...
                  $valeur_venale = 0.65 * $valeur_neuve;
                  break;

                 case 7:
                  // 4ans...
                  $valeur_venale = 0.70 * $valeur_neuve;
                  break;

                 case 8:
                  // 4ans...
                  $valeur_venale = 0.80 * $valeur_neuve;
                  break;
              
              default:
                  // code...
                  break;
          }

          if ($agevehicule > 8 ) {
             $valeur_venale = 0.80 * $valeur_neuve;
          }


           if ($agevehicule > 10 ) {
             $valeur_venale = 0.10 * $valeur_neuve;
          }

          // dd($valeur_venale);


          //Parametres
          $accessoir_compagnie  = 5000; // annuel
          $accessoire_apporteur = 5000; // annuel
          $cartebrune = 1000;
          $bns_param = (100 - $bns) / 100;
          $csp_param = ($csp/100);
          $redcom_param = (100 - $redcom) / 100;




          // Responsabilite civile 
          $respons_civile =   $prime_energie * $bns_param * $csp_param;
          

          // Defense et recours 
          $defence_recours_tiers_collision = 4240 * $redcom_param * $bns_param;
          $defence_recours_tout_risque = 4240 * $redcom_param * $bns_param;
          $defence_recours_tiers_ameliore = 7950 * $redcom_param * $bns_param;
          $defence_recours_tiers_complet = 7950 * $redcom_param * $bns_param;
          $defence_recours_tiers_simple = 7950 * $redcom_param * $bns_param;



         // Recours anticipe
          $recourt_ant_tiers_collision = 0;
          $recourt_ant_tout_risque = 0;
          $recourt_ant_tiers_simple = 15000 * $redcom_param * $bns_param;
          $recourt_ant_tiers_ameliore = 15000 * $redcom_param * $bns_param;
          $recourt_ant_tiers_complet = 15000 * $redcom_param * $bns_param;



        // Incendie explosion
          $incendie_explosion_tiers_simple = 0;
          $incendie_explosion_tiers_complet = $valeur_venale * 0.003* $redcom_param * $bns_param;
          $incendie_explosion_tout_risque = $valeur_venale * 0.003* $redcom_param * $bns_param;
          $incendie_explosion_tiers_collisiion = $valeur_venale * 0.003* $redcom_param * $bns_param;
          $incendie_explosion_tiers_ameliore = 15000 * 0.003 * $redcom_param * $bns_param;

           // dd($incendie_explosion_tiers_complet);

        // Vol agression
          $vol_agression_tiers_simple = 0;
          $vol_agression_tiers_collision= $valeur_venale * 0.003* $redcom_param * $bns_param;
          $vol_agression_tout_risque  = $valeur_venale * 0.003* $redcom_param * $bns_param;
          $vol_agression_tiers_ameliore = $valeur_venale * 0.003* $redcom_param * $bns_param;
          $vol_agression_tiers_complet = $valeur_venale * 0.003* $redcom_param * $bns_param;


         //Vol accessoir
          $vol_accessoire_tiers_simple  = 0;
          $vol_accessoire_tiers_ameliore=  20000 * $redcom_param * $bns_param;
          $vol_accessoire_tout_risque=  20000 * $redcom_param * $bns_param;
          $vol_accessoire_tiers_collision=  20000 * $redcom_param * $bns_param;
          $vol_accessoire_tiers_complet=  20000 * $redcom_param * $bns_param;


        // Brise glasse
          $brise_glace_tiers_simple = 0;
          $brise_glace_tout_risque= 0;
          $brise_glace_tiers_ameliore = 0;
          $brise_glace_tiers_collision = 0;
          $brise_glace_tiers_complet = $valeur_neuve * 0.0021* $redcom_param * $bns_param;


        //Dommage accident
          $pourcent_domage= 4.7/100;
          $dommage_accident_tiers_simple = 0;
          $dommage_accident_tiers_complet = 0;
          $dommage_accident_tiers_ameliore = 0;
          $dommage_accident_tiers_collision = 0;
          $dommage_accident_tout_risque = $valeur_neuve * $pourcent_domage * $redcom_param * $bns_param;


        //Dommage collision
          $pourcent_domage_col= 2.56/100;
          $dommage_collision_tiers_simple= 0;
          $dommage_collision_tiers_complet= 0;
          $dommage_collision_tiers_ameliore= 0;
          $dommage_collision_tout_risque= 0;
          $dommage_collision_tiers_collision = $valeur_neuve * $pourcent_domage_col * $redcom_param * $bns_param;


        // Personne transportes /formule 1 par defaut
          $formule1 =5900;
          $personne_transp_tiers_simple = $formule1  * $redcom_param * $bns_param;
          $personne_transp_tiers_complet =  $formule1  * $redcom_param * $bns_param;
          $personne_transp_tiers_ameliore = $formule1  * $redcom_param * $bns_param;
          $personne_transp_tout_risque =  $formule1  * $redcom_param * $bns_param;
          $personne_transp_tiers_collision =  $formule1  * $redcom_param * $bns_param;


        // Assistance automobile

          $assistance_auto_tiers_simple = 0;
          $assistance_auto_tiers_complet = 0;
          $assistance_auto_tiers_ameliore = 0;
          $assistance_auto_tout_risque = 0;
          $assistance_auto_tiers_collision = 0;


        // Totat prime
          $total_prime_tiers_simple = $respons_civile+ $defence_recours_tiers_simple + $recourt_ant_tiers_simple +$incendie_explosion_tiers_simple + $vol_agression_tiers_simple + $vol_accessoire_tiers_simple + $brise_glace_tiers_simple + $dommage_accident_tiers_simple + $dommage_collision_tiers_simple;

          $total_prime_tiers_complet = $respons_civile + $defence_recours_tiers_complet + $recourt_ant_tiers_complet+$incendie_explosion_tiers_complet+$vol_agression_tiers_complet+$vol_accessoire_tiers_complet+$brise_glace_tiers_complet+$dommage_accident_tiers_complet+$dommage_collision_tiers_complet+$personne_transp_tiers_complet+$assistance_auto_tiers_complet;


          $total_prime_tiers_ameliore = $respons_civile + $defence_recours_tiers_ameliore +$recourt_ant_tiers_ameliore + $incendie_explosion_tiers_ameliore + $vol_agression_tiers_ameliore + $vol_accessoire_tiers_ameliore + $brise_glace_tiers_ameliore + $dommage_collision_tiers_ameliore + $personne_transp_tiers_ameliore + $assistance_auto_tiers_ameliore;

          $total_prime_tout_risque = $respons_civile+$defence_recours_tout_risque+$recourt_ant_tout_risque+$incendie_explosion_tout_risque+$vol_agression_tout_risque+$vol_accessoire_tout_risque+$brise_glace_tout_risque+$dommage_accident_tout_risque+$dommage_collision_tout_risque+$personne_transp_tout_risque+$assistance_auto_tout_risque;


          $total_prime_tiers_collision = $respons_civile+$defence_recours_tiers_collision+$recourt_ant_tiers_collision+$incendie_explosion_tiers_collisiion+$vol_agression_tiers_collision+$vol_accessoire_tiers_collision+$brise_glace_tiers_collision+$dommage_accident_tiers_collision+$dommage_collision_tiers_collision+$personne_transp_tiers_collision+$assistance_auto_tiers_collision;



        // Prime finale
          $fond_garantie_auto = 0.02 * $respons_civile; 

          $prime_finale_tiers_simple = $total_prime_tiers_simple + $accessoir_compagnie + $accessoire_apporteur +$fond_garantie_auto + ($total_prime_tiers_simple +$accessoir_compagnie + $accessoire_apporteur ) * 0.145;
          $prime_finale_tiers_complet = $total_prime_tiers_complet + $accessoir_compagnie + $accessoire_apporteur +$fond_garantie_auto + ($total_prime_tiers_complet +$accessoir_compagnie + $accessoire_apporteur ) * 0.145;
          $prime_finale_tiers_ameliore = $total_prime_tiers_ameliore + $accessoir_compagnie + $accessoire_apporteur +$fond_garantie_auto + ($total_prime_tiers_ameliore +$accessoir_compagnie + $accessoire_apporteur ) * 0.145;;
          $prime_finale_tout_risque = $total_prime_tout_risque + $accessoir_compagnie + $accessoire_apporteur +$fond_garantie_auto + ($total_prime_tout_risque +$accessoir_compagnie + $accessoire_apporteur ) * 0.145;
         
          $prime_finale_tiers_collision =$total_prime_tiers_collision + $accessoir_compagnie + $accessoire_apporteur +$fond_garantie_auto + ($total_prime_tiers_collision +$accessoir_compagnie + $accessoire_apporteur ) * 0.145;
         ;


         $prime_finale_tiers_simple = round($prime_finale_tiers_simple,2);
         $prime_finale_tiers_complet = round($prime_finale_tiers_complet,2);
         $prime_finale_tiers_ameliore = round($prime_finale_tiers_ameliore,2);
         $prime_finale_tout_risque = round($prime_finale_tout_risque,2);
         $prime_finale_tiers_collision = round($prime_finale_tiers_collision,2);

 



            // $listeprime = $prime_finale_tiers_simple .'*'.$prime_finale_tiers_complet.'*'.$prime_finale_tiers_ameliore.'*'.$prime_finale_tiers_collision.'*'.$prime_finale_tout_risque;










        return view('cotation',compact('prime_finale_tiers_simple','prime_finale_tiers_complet','prime_finale_tiers_ameliore','prime_finale_tout_risque','prime_finale_tiers_collision','marque','model','energie','mise_circulation','puissance','agevehicule','valeur_neuve','valeur_venale','nbreplace'));

        }else
        {
            $nodata =true;
              return view('cotation',compact('prime_finale_tiers_simple','prime_finale_tiers_complet','prime_finale_tiers_ameliore','prime_finale_tout_risque','prime_finale_tiers_collision','marque','model','energie','mise_circulation','puissance','agevehicule','nodata','valeur_neuve','valeur_venale','nbreplace'));
        }



     }



     public function OpenAiReadText(request $request){



    //enregistrer l'image 

        $dir="cartes_grise/";
         // $imgattesation = $request->file('Imgattesation');
         $imgcartegrise = $request->file('image');
         
         $urlcarte_grise='';



       if ($request->hasFile('image')) {
                $imageCartegriseName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgcartegrise->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageCartegriseName, file_get_contents($imgcartegrise));
                // $urlcarte_grise = '/storage/scancg/'.$imageCartegriseName;
                $urlcarte_grise = $imageCartegriseName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            // return response()->json(['message' => 'failed to upload carte grise'], 400);
            $typeError[]=2;
        }




        // dd(env('OPENAI_API_KEY'));


            // $pathToImage= 'assets/images/carte_grise.png';

            // $response = Http::withHeaders([
            //     'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            // ])
            // ->attach('file', fopen($pathToImage, 'r'), 'carte_grise.png')
            // ->post('https://api.openai.com/v1/chat/completions', [
            //     'model' => 'gpt-4-vision-preview',
            //     'messages' => [
            //         [
            //             'role' => 'user',
            //             'content' => [
            //                 [
            //                     'type' => 'text',
            //                     'text' => 'Lis les informations de cette carte grise et donne-moi les champs structurés.',
            //                 ],
            //                 [
            //                     'type' => 'image_url',
            //                     'image_url' => [
            //                         'url' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents($pathToImage)),
            //                     ],
            //                 ],
            //             ],
            //         ],
            //     ],
            //     'max_tokens' => 1000,
            // ]);




//             use GuzzleHttp\Client;

// public function lireCarteGrise(Request $request)
// {
    // Chemin vers ton image (tu peux adapter pour utiliser $request->file('image'))
    // $imagePath = storage_path('app/public/carte_grise.jpg');

            // Donne-moi les champs de la carte grise sous forme d'objet JSON avec des clés comme : nom_proprietaire, numero_serie, carburant, etc.
    //$imagePath= 'assets/images/carte_grise.png';

     $base64Image = base64_encode(file_get_contents($request->file('image')->path()));
    // $base64Image = base64_encode(file_get_contents($imagePath));

    $client = new Client();

    $response = $client->post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'model' => 'gpt-4.1',
             // 'model' => 'gpt-4-vision-preview',
            'messages' => [
                 [
                    'role' => 'system',
                    'content' => 'Tu es un assistant qui extrait les champs d’une carte grise ivoirienne. Rends le résultat sous forme JSON clair avec les champs : immatriculation, nom_proprietaire, marque, type_commercial, date_mise_en_circulation, couleur, carburant, etc.',
                ],
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            // 'text' => 'Lis les champs de cette carte grise et renvoie-moi un JSON structuré avec toutes les données importantes.',

                            // 'text' => "Donne-moi les champs de la carte grise sous forme d'objet JSON avec des clés comme : nom_proprietaire, numero_serie, carburant, marque, modele, carosserie, couleur,immatriculation, energie, nombre_place, usage_vehicule, mise_en_circulation,puissance_fiscale",

                           'text'  =>"Donne-moi les champs de la carte grise sous forme d'objet JSON avec des clés comme : nom_proprietaire, numero_serie, carburant, etc."
                        ],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => 'data:image/jpeg;base64,' . $base64Image,
                            ],
                        ],
                    ],
                ],
            ],
            'max_tokens' => 1000,
        ],
    ]);

    $body = json_decode($response->getBody(), true);

    $text = $body['choices'][0]['message']['content'];


     // dd($text);
     // $res = preg_match('~\{(?:[^{}]|(?R))*\}~', $text);

     $matches = array();
    if (preg_match('~\{(?:[^{}]|(?R))*\}~', $text, $matches)) {

        $cg_datas = json_decode($matches[0],true);




        // dd($cg_datas);
        // numero_immatriculation
        // dd($cg_datas['numero_immatriculation']);
        // $abb = json_encode($matches[0]);
        // dd($abb['numero_cinematique']);

        Log::info(json_encode($cg_datas));
        $image_to_display ='/storage/'.$dir.$urlcarte_grise; //$request->file('image')->path();

        return view('infos_carte_grise',compact('cg_datas','image_to_display'));

    }


    
    // return response()->json([
    //     'data' => $body['choices'][0]['message']['content'] ?? 'Aucune donnée extraite',
    // ]);
// }


            // dd($response);




     }
} 
