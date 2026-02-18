<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProspectionClient;
use App\Models\Prospectors;
use App\Models\Administrators;
use App\Models\Canals;
use App\Models\NoteOpportunites;
use App\Models\AgentBackoffices;
use App\Models\AffectationOpportunites;
use App\Models\Contrats;
use App\Models\Cars;
use App\Models\CarsValues;
use App\Models\CarBrands;
use App\Models\CarModels;
use App\Models\Assureur;
use Illuminate\Support\Facades\Hash;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Carbon\Carbon;
use ValidateDateStringHelper;
use Storage;
use Session;
use Redirect;
use DB;

class AdminsController extends Controller
{
    //



    public function login (request $request){


      // if (Session::has('userlogin')) {
      //   return \Redirect::back();
      // }else
      //  return view('login');

       if(Session::has('agentbackofficeid'))
        return  Redirect::back();
        else
        return view('login');


    }

    public function registercanal (request $request){

        $libellecanal = $request->libellecanal;
        $newInsert = Canals::create([
                        'libelle'=>$libellecanal,
                        'donebyuser'=>'1',
                        'isactive'=>1,
                    ]);

          if(!$newInsert->id){
              return 'Error';
          }else {
              return 'inserted';
        }

    }

    public function registerassureur (request $request){


      $libellecanal = $request->libellecanal;
        $newInsert = Assureur::create([
                        'libelle'=>$libellecanal,
                        'isvisible'=>1,
                    ]);

          if(!$newInsert->id){
              return 'Error';
          }else {
              return 'inserted';
        }


    }


    public function testOcr(request $request){



      // Path to the scanned image
      // $imagePath = '/assets/images/cg.png';
      $imagePath =public_path('assets/images/cg.png');
      // public_path("images\") . $filename
      //return response()->file($imagePath);;
      // Create a new instance of TesseractOCR
      // $tesseract = new TesseractOCR($imagePath);

      // // Set the language of the text in the image
      // $tesseract->lang('eng');

      // // Get the text from the image
      // $text = $tesseract->run();



      try {
    
                $tesseract = (new TesseractOCR($imagePath))
                    ->setLanguage('eng')
                    ->run();
              echo $tesseract;
            } catch (Exception $e) {
    
                echo $e->getMessage();
    
            }





      // Print the extracted text
      // echo $text;


    }


    public function createcanal (Request $request){
 
       return view('createcanal');
    }


    public function liste_canaux (Request $request){

      $liste_canaux = Canals::with('AgentBackoffice')->get()->toArray();

      return view('liste_canaux',compact('liste_canaux'));
    }


    public function edit_canal($idcanal){

      $foundcanal = Canals::with('AgentBackoffice')
      ->where('id',$idcanal)
      ->get()->toArray();

 
       return view('editcanal',compact('foundcanal'));
    }


    public function update_canal (request $request){


      $idcanal =  $request->idcanal;
      $visible = $request->visible;
      $activ   = $request->activ;

       try {
                $newInsert = Canals::where([
                                  'id'=> $request->idcanal,
                                 
                              ])->update(
                                [
                                 'status'=>0,
                                 'isactive'=> $activ,
                                 'isvisible'=> $visible,
                            ]);
                 // return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }
    }


    public function listecommerciaux (Request $request){

    $listecommerciaux = Prospectors::all()->toArray();
    // dd($listeprospection);
    return view('liste_commerciaux', compact('listecommerciaux'));

   }


   public function registernote(request $request){


      $idopportunite = $request->idopp;
      $souscritpar = $request->souscritpar;
      $paymentmode = $request->paymentmode;
      $Today = date('Y-m-d');


      $dateecheance= $request->dateecheance;
      $daterelance=  $request->daterelance;
      $heurerelance_received= $request->heurerelance;


      $dir="preuve_avenant/";
      $fichier_preuve_paiement = $request->file('preuve_paiement');
      $fichier_avenant = $request->file('avenant');




         // $imgattesation = $request->file('Imgattesation');
         // $imgcartegrise = $request->file('Imgcartegrise');

       
         $url_preuve_paiement ='';
         $url_avenant='';

        //dd($imgcartegrise);
        if ($request->hasFile('preuve_paiement')) {
          
                $preuveFileName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $fichier_preuve_paiement->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$preuveFileName, file_get_contents($fichier_preuve_paiement));
                $url_preuve_paiement = '/storage/preuve_avenant/'.$preuveFileName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            $typeError[]=1;
            // return response()->json(['message' => 'failed to upload attestation'], 400);
        } 
       // return response()->json(['message' => trans('/storage/test/'.$imageAttestationName)], 200);



        if ($request->hasFile('avenant')) {

          
                $avenantFileName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $fichier_avenant->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$avenantFileName, file_get_contents($fichier_avenant));
                $url_avenant = '/storage/preuve_avenant/'.$avenantFileName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            // return response()->json(['message' => 'failed to upload carte grise'], 400);
            $typeError[]=2;
        } 

         

       
       //   $checker = new ValidateDateStringHelper();
       //   $isvalidDateech  = $checker->validateDate($dateecheance);
       //   $isvalidDaterel = $checker->validateDate($daterelance);
       //   //dd($dateecheance .' ' .$isvalidDateech .' '.$daterelance.' '. $isvalidDaterel);

       //  if(!$isvalidDateech || $dateecheance )
       //   return response()->json(['message' => 'date echeance invalid'], 201);

       // if(!$isvalidDaterel)
       //   return response()->json(['message' => 'date relance invalid'], 201);


       // dd($daterelance);

      $createheure_relance = $daterelance .' '.$heurerelance_received;
      $relance_sys =0;
      $heurerelance = date("Y-m-d H:i:s", strtotime($createheure_relance));

      //dd($heurerelance);

       if ($heurerelance_received == ''|| empty($heurerelance_received) || $heurerelance_received =null ) {
        // code...
        $heurerelance = date("Y-m-d H:i:s", strtotime('1980-01-01 00:00:00'));
      }

       if ($dateecheance == ''|| empty($dateecheance) || $dateecheance ==null ) {
        // code...
        $dateecheance = null;
      }

// date('Y-m-d H:i:s')

      $observation=  $request->observation;

      $sante=  $request->sante ?? 0;
      $voyage=  $request->voyage ?? 0;
      $autre=  $request->autre ?? 0;
      $flotteauto=  $request->flotteauto ?? 0;
      $inthabitation=  $request->habitation ?? 0;

      $inthabitation=  $request->habitation ?? 0;
      $inthabitation=  $request->habitation ?? 0;
      $inthabitation=  $request->habitation ?? 0;

      $primenet=  $request->primenet ?? 0;
       $primettc=  $request->primettc ?? 0;
      $assureur_actuel=  $request->assureur ?? 'non defini';
      $periode_soucription=  $request->periodesousc ?? 0;

      $interetclient= $request->interetclient;
      $resultatentretien= $request->resultatentretien;


      $idagentbackoffice=Session::get('agentbackofficeid');
      $donesouscritpar =null;

      if (!is_null($souscritpar) && $souscritpar!='') {
        // code...

        $idagentbackoffice = $souscritpar;
        $donesouscritpar = Session::get('agentbackofficeid');
      }


       if ($periode_soucription <= 2) {
        // code...
        $relance_sys =7;
      }


       if ($periode_soucription >= 2 && $periode_soucription <= 6) {
        // code...
        $relance_sys =14;
      }


       if ($periode_soucription >6) {
        // code...
        $relance_sys =30;
      }



     
      //dd($heurerelance);
      //moise

      $has_attestation = 'noattestation';
      $has_cartegrise = 'noassurance';

        $opp = ProspectionClient::where('id',$idopportunite)
         ->select('urlcarte_grise_terrain','url_attestationassurance_terrain','urlcarte_grise','url_attestationassurance')
         ->get()->toArray();


         // dd($opp);

        if ($opp[0]['url_attestationassurance'] == null && $opp[0]['url_attestationassurance_terrain'] == '') {
            // code...
             $has_attestation = 'noattestation';
        }else
         $has_attestation = 'attestation';


         if ($opp[0]['url_attestationassurance'] == null && $opp[0]['url_attestationassurance_terrain'] == null) {
            // code...
             $has_attestation = 'noattestation';
        }else
         $has_attestation = 'attestation';


         if ($opp[0]['url_attestationassurance'] == '' && $opp[0]['url_attestationassurance_terrain'] == '') {
            // code...
             $has_attestation = 'noattestation';
        }else
         $has_attestation = 'attestation';

        if ($opp[0]['urlcarte_grise_terrain'] == null && $opp[0]['urlcarte_grise'] == '') {
            // code...
             $has_cartegrise = 'nocartegrise';
        }else
         $has_cartegrise = 'cartegrise';

        if ($opp[0]['urlcarte_grise_terrain'] == null && $opp[0]['urlcarte_grise'] == null) {
            // code...
             $has_cartegrise = 'nocartegrise';
        }else
         $has_cartegrise = 'cartegrise';

        if ($opp[0]['urlcarte_grise_terrain'] == '' && $opp[0]['urlcarte_grise'] == '') {
            // code...
             $has_cartegrise = 'nocartegrise';
        }else
         $has_cartegrise = 'cartegrise';

         if ($opp[0]['urlcarte_grise_terrain'] == '' && $opp[0]['urlcarte_grise'] == null) {
            // code...
             $has_cartegrise = 'nocartegrise';
        }else
         $has_cartegrise = 'cartegrise';





      //end moise 

      



       if ($resultatentretien !='gagne' ) {
           // code...
      try{
      $newInsert = NoteOpportunites::create([
                          "idopportunite"=> $idopportunite,
                           "idagentbackoffice"=>  $idagentbackoffice,
                           "inthabitation"=> $inthabitation,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intvoyage"=>  $voyage,
                           "intautre"=>  $autre,
                           "daterelance"=>$daterelance,
                           "heure_relance"=>$heurerelance,
                           "echeance"=>  $dateecheance,
                           "observation"=>  $observation,
                           "interetclient"=>  $interetclient,
                           "resultat"=>  $resultatentretien,
                           "assureur_actuel"=>  $assureur_actuel,
                           "souscrit_par"=>  $donesouscritpar,
                           "periode_soucription"=>  $periode_soucription,
                           "primettc"=>  $primettc,
                           "primenet"=>  $primenet,
                           "relance_sys"=>  $relance_sys,
                           'url_preuve_paiement'=>  $url_preuve_paiement,
                           'url_avenant'=>  $url_avenant,



                    ]);
       return 'inserted';
      }   catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                      // dd($ex->getMessage());
                      // dd($ex->getCode())
           $errorcode =  $ex->getCode();

                      if ($errorcode = 22007) {
                        // code...
                        return 'date relance non valide';
                      }else
                       return $ex;
      }

          // if(!$newInsert->id){
          //     return 'Error';
          //     //$typeError[]=3;
          // }else {
             
          //     return 'inserted';
          //     //return response()->json(['message' => 'successfull'], 200);
          // }

      }else if($has_cartegrise =='cartegrise' && $has_attestation =='attestation' && $resultatentretien == 'gagne') {


        $lastcommentaire = NoteOpportunites::where([
                  ['idopportunite', '=', $idopportunite],
                  ['isvisible', '=', 1],
                 ])->orderBy('id', 'DESC')
                 ->first();
        if ($lastcommentaire) {
          // code...
          $lastcommentaire = $lastcommentaire->toArray();
          $lastecheance=Carbon::parse($lastcommentaire['echeance'])->format('Y-m-d');

          if ($lastecheance == $dateecheance)
            return 'change_echeance_date';
        }

          // dd($lastcommentaire);


          // {{\Carbon\Carbon::parse($lastcommentaire['echeance'])->format('Y-m-d')}}

         

        



          $newInsert = NoteOpportunites::create([
                          "idopportunite"=> $idopportunite,
                           "idagentbackoffice"=>  $idagentbackoffice,
                           "inthabitation"=> $inthabitation,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intvoyage"=>  $voyage,
                           "intautre"=>  $autre,
                           "daterelance"=>$daterelance,
                           "heure_relance"=>$heurerelance,
                           "echeance"=>  $dateecheance,
                           "observation"=>  $observation,
                           "interetclient"=>  $interetclient,
                           "resultat"=>  $resultatentretien,
                           "assureur_actuel"=>  $assureur_actuel,
                           "periode_soucription"=>  $periode_soucription,
                           "souscrit_par"=>  $donesouscritpar,
                           "primettc"=>  $primettc,
                           "primenet"=>  $primenet,
                           "paymentmode"=>  $paymentmode,
                           "relance_sys"=>  $relance_sys,
                           'url_preuve_paiement'=>  $url_preuve_paiement,
                           'url_avenant'=>  $url_avenant,
                    ]);

          if(!$newInsert->id){
              return 'Error';
              //$typeError[]=3;
          }else {
              // return  response()->json('successfull', 200);


             if ($resultatentretien == 'gagne') {
                // code...

              $statement = DB::select("SHOW TABLE STATUS LIKE 'contrats'");
              $nextId = $statement[0]->Auto_increment;


              //verifier que l'opportunite exite pour la terminaison RN
              //si l'opportunite exite pas terminaison AN


              $numpolice = str_pad($nextId,5,0,STR_PAD_LEFT). '-AN';

              $trouveOpport = Contrats::where([
                ['idopportunite', '=', $idopportunite],
              ])->first();

              if ($trouveOpport) {
                // code...
                // $numpolice = $trouveOpport->numpolice. '-RN';
                $numpolice = Str::replace('-AN', '-RN', $trouveOpport->numpolice);
              }

              $contracInsert = Contrats::create([
                          "idopportunite"=> $idopportunite,
                          "numpolice"=>  $numpolice,
                          "commentaire"=> $newInsert->id,
                    ]);


              }



              return 'inserted';
              //return response()->json(['message' => 'successfull'], 200);
          }


      }else{

        return 'charger_document';
      }

    }



    public function updatenote(request $request){


      $idopportunite = $request->idopp;
      $souscritpar = $request->souscritpar;
      $paymentmode = $request->paymentmode;
      $Today = date('Y-m-d');

      $lastpreuve = $request->lastpreuve;
      $lastavenant = $request->lastavenant;



      $dateecheance= $request->dateecheance;
      $daterelance=  $request->daterelance;
      $heurerelance_received= $request->heurerelance;


      $dir="preuve_avenant/";
      $fichier_preuve_paiement = $request->file('preuve_paiement');
      $fichier_avenant = $request->file('avenant');




         // $imgattesation = $request->file('Imgattesation');
         // $imgcartegrise = $request->file('Imgcartegrise');

       
         $url_preuve_paiement ='';
         $url_avenant='';

        //dd($imgcartegrise);
        if ($request->hasFile('preuve_paiement')) {
          
                $preuveFileName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $fichier_preuve_paiement->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$preuveFileName, file_get_contents($fichier_preuve_paiement));
                $url_preuve_paiement = '/storage/preuve_avenant/'.$preuveFileName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            $typeError[]=1;
            $url_preuve_paiement = $lastpreuve;


            // return response()->json(['message' => 'failed to upload attestation'], 400);
        } 
       // return response()->json(['message' => trans('/storage/test/'.$imageAttestationName)], 200);



        if ($request->hasFile('avenant')) {

          
                $avenantFileName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $fichier_avenant->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$avenantFileName, file_get_contents($fichier_avenant));
                $url_avenant = '/storage/preuve_avenant/'.$avenantFileName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            // return response()->json(['message' => 'failed to upload carte grise'], 400);
            $typeError[]=2;
            $url_avenant = $lastavenant;
        } 

         

       
       //   $checker = new ValidateDateStringHelper();
       //   $isvalidDateech  = $checker->validateDate($dateecheance);
       //   $isvalidDaterel = $checker->validateDate($daterelance);
       //   //dd($dateecheance .' ' .$isvalidDateech .' '.$daterelance.' '. $isvalidDaterel);

       //  if(!$isvalidDateech || $dateecheance )
       //   return response()->json(['message' => 'date echeance invalid'], 201);

       // if(!$isvalidDaterel)
       //   return response()->json(['message' => 'date relance invalid'], 201);


       // dd($daterelance);

      $createheure_relance = $daterelance .' '.$heurerelance_received;
      $relance_sys =0;
      $heurerelance = date("Y-m-d H:i:s", strtotime($createheure_relance));

      //dd($heurerelance);

       if ($heurerelance_received == ''|| empty($heurerelance_received) || $heurerelance_received =null ) {
        // code...
        $heurerelance = date("Y-m-d H:i:s", strtotime('1980-01-01 00:00:00'));
      }

       if ($dateecheance == ''|| empty($dateecheance) || $dateecheance ==null ) {
        // code...
        $dateecheance = null;
      }

// date('Y-m-d H:i:s')

      $observation=  $request->observation;

      $sante=  $request->sante ?? 0;
      $voyage=  $request->voyage ?? 0;
      $autre=  $request->autre ?? 0;
      $flotteauto=  $request->flotteauto ?? 0;
      $inthabitation=  $request->habitation ?? 0;

      $inthabitation=  $request->habitation ?? 0;
      $inthabitation=  $request->habitation ?? 0;
      $inthabitation=  $request->habitation ?? 0;

      $primenet=  $request->primenet ?? 0;
       $primettc=  $request->primettc ?? 0;
      $assureur_actuel=  $request->assureur ?? 'non defini';
      $periode_soucription=  $request->periodesousc ?? 0;

      $interetclient= $request->interetclient;
      $resultatentretien= $request->resultatentretien;


      $idagentbackoffice=Session::get('agentbackofficeid');
      $donesouscritpar =null;

      if (!is_null($souscritpar) && $souscritpar!='') {
        // code...

        $idagentbackoffice = $souscritpar;
        $donesouscritpar = Session::get('agentbackofficeid');
      }


       if ($periode_soucription <= 2) {
        // code...
        $relance_sys =7;
      }


       if ($periode_soucription >= 2 && $periode_soucription <= 6) {
        // code...
        $relance_sys =14;
      }


       if ($periode_soucription >6) {
        // code...
        $relance_sys =30;
      }



     
      //dd($heurerelance);
      //moise

      $has_attestation = 'noattestation';
      $has_cartegrise = 'noassurance';

        $opp = ProspectionClient::where('id',$idopportunite)
         ->select('urlcarte_grise_terrain','url_attestationassurance_terrain','urlcarte_grise','url_attestationassurance')
         ->get()->toArray();


         // dd($opp);

        if ($opp[0]['url_attestationassurance'] == null && $opp[0]['url_attestationassurance_terrain'] == '') {
            // code...
             $has_attestation = 'noattestation';
        }else
         $has_attestation = 'attestation';


         if ($opp[0]['url_attestationassurance'] == null && $opp[0]['url_attestationassurance_terrain'] == null) {
            // code...
             $has_attestation = 'noattestation';
        }else
         $has_attestation = 'attestation';


         if ($opp[0]['url_attestationassurance'] == '' && $opp[0]['url_attestationassurance_terrain'] == '') {
            // code...
             $has_attestation = 'noattestation';
        }else
         $has_attestation = 'attestation';

        if ($opp[0]['urlcarte_grise_terrain'] == null && $opp[0]['urlcarte_grise'] == '') {
            // code...
             $has_cartegrise = 'nocartegrise';
        }else
         $has_cartegrise = 'cartegrise';

        if ($opp[0]['urlcarte_grise_terrain'] == null && $opp[0]['urlcarte_grise'] == null) {
            // code...
             $has_cartegrise = 'nocartegrise';
        }else
         $has_cartegrise = 'cartegrise';

        if ($opp[0]['urlcarte_grise_terrain'] == '' && $opp[0]['urlcarte_grise'] == '') {
            // code...
             $has_cartegrise = 'nocartegrise';
        }else
         $has_cartegrise = 'cartegrise';

         if ($opp[0]['urlcarte_grise_terrain'] == '' && $opp[0]['urlcarte_grise'] == null) {
            // code...
             $has_cartegrise = 'nocartegrise';
        }else
         $has_cartegrise = 'cartegrise';





      //end moise 

      
// $newInsert = Canals::where([
//                                   'id'=> $request->idcanal,
                                 
//                               ])->update(
//                                 [
//                                  'status'=>0,
//                                  'isactive'=> $activ,
//                                  'isvisible'=> $visible,
//                             ]);


       if ($resultatentretien !='gagne' ) {
           // code...
      try{
     if (!is_null($souscritpar) && $souscritpar!='')
      $newInsert = NoteOpportunites::where([
                                  'id'=> $request->commentid,
                          ])->update([
                          // "idopportunite"=> $idopportunite,
                          
                          "idagentbackoffice"=>  $idagentbackoffice,
                           "inthabitation"=> $inthabitation,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intvoyage"=>  $voyage,
                           "intautre"=>  $autre,
                           "daterelance"=>$daterelance,
                           "heure_relance"=>$heurerelance,
                           "echeance"=>  $dateecheance,
                           "observation"=>  $observation,
                           "interetclient"=>  $interetclient,
                           "resultat"=>  $resultatentretien,
                           "assureur_actuel"=>  $assureur_actuel,
                           "souscrit_par"=>  $donesouscritpar,
                           "periode_soucription"=>  $periode_soucription,
                           "primettc"=>  $primettc,
                           "primenet"=>  $primenet,
                           "relance_sys"=>  $relance_sys,
                           'url_preuve_paiement'=>  $url_preuve_paiement,
                           'url_avenant'=>  $url_avenant,

                    ]);
        if (is_null($souscritpar) || $souscritpar=='')
      $newInsert = NoteOpportunites::where([
                                  'id'=> $request->commentid,
                          ])->update([
                          // "idopportunite"=> $idopportunite,
                          
                          // "idagentbackoffice"=>  $idagentbackoffice,
                           "inthabitation"=> $inthabitation,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intvoyage"=>  $voyage,
                           "intautre"=>  $autre,
                           "daterelance"=>$daterelance,
                           "heure_relance"=>$heurerelance,
                           "echeance"=>  $dateecheance,
                           "observation"=>  $observation,
                           "interetclient"=>  $interetclient,
                           "resultat"=>  $resultatentretien,
                           "assureur_actuel"=>  $assureur_actuel,
                           "souscrit_par"=>  $donesouscritpar,
                           "periode_soucription"=>  $periode_soucription,
                           "primettc"=>  $primettc,
                           "primenet"=>  $primenet,
                           "relance_sys"=>  $relance_sys,
                           'url_preuve_paiement'=>  $url_preuve_paiement,
                           'url_avenant'=>  $url_avenant,

                    ]);
       return 'inserted';
      }   catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                      // dd($ex->getMessage());
                      // dd($ex->getCode())
           $errorcode =  $ex->getCode();

                      if ($errorcode = 22007) {
                        // code...
                        return 'date relance non valide';
                      }else
                       return $ex;
      }

          // if(!$newInsert->id){
          //     return 'Error';
          //     //$typeError[]=3;
          // }else {
             
          //     return 'inserted';
          //     //return response()->json(['message' => 'successfull'], 200);
          // }

      }else if($has_cartegrise =='cartegrise' && $has_attestation =='attestation' && $resultatentretien == 'gagne') {


        // $lastcommentaire = NoteOpportunites::where([
        //           ['idopportunite', '=', $idopportunite],
        //           ['isvisible', '=', 1],
        //          ])->orderBy('id', 'DESC')
        //          ->first();
        // if ($lastcommentaire) {
        //   // code...
        //   $lastcommentaire = $lastcommentaire->toArray();
        //   $lastecheance=Carbon::parse($lastcommentaire['echeance'])->format('Y-m-d');

        //   if ($lastecheance == $dateecheance)
        //     return 'change_echeance_date';
        // }

          // dd($lastcommentaire);


          // {{\Carbon\Carbon::parse($lastcommentaire['echeance'])->format('Y-m-d')}}

        try {
          
          if (!is_null($souscritpar) && $souscritpar!='')
          $newInsert = NoteOpportunites::where([
                                  'id'=> $request->commentid,
                          ])->update([
                          // "idopportunite"=> $idopportunite,
                           "idagentbackoffice"=>  $idagentbackoffice,
                           "inthabitation"=> $inthabitation,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intvoyage"=>  $voyage,
                           "intautre"=>  $autre,
                           "daterelance"=>$daterelance,
                           "heure_relance"=>$heurerelance,
                           "echeance"=>  $dateecheance,
                           "observation"=>  $observation,
                           "interetclient"=>  $interetclient,
                           "resultat"=>  $resultatentretien,
                           "assureur_actuel"=>  $assureur_actuel,
                           "periode_soucription"=>  $periode_soucription,
                           "souscrit_par"=>  $donesouscritpar,
                           "primettc"=>  $primettc,
                           "primenet"=>  $primenet,
                           "paymentmode"=>  $paymentmode,
                           "relance_sys"=>  $relance_sys,
                           'url_preuve_paiement'=>  $url_preuve_paiement,
                           'url_avenant'=>  $url_avenant,
                    ]);

         if (is_null($souscritpar) && $souscritpar=='')
          $newInsert = NoteOpportunites::where([
                                  'id'=> $request->commentid,
                          ])->update([
                          // "idopportunite"=> $idopportunite,
                           // "idagentbackoffice"=>  $idagentbackoffice,
                           "inthabitation"=> $inthabitation,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intvoyage"=>  $voyage,
                           "intautre"=>  $autre,
                           "daterelance"=>$daterelance,
                           "heure_relance"=>$heurerelance,
                           "echeance"=>  $dateecheance,
                           "observation"=>  $observation,
                           "interetclient"=>  $interetclient,
                           "resultat"=>  $resultatentretien,
                           "assureur_actuel"=>  $assureur_actuel,
                           "periode_soucription"=>  $periode_soucription,
                           "souscrit_par"=>  $donesouscritpar,
                           "primettc"=>  $primettc,
                           "primenet"=>  $primenet,
                           "paymentmode"=>  $paymentmode,
                           "relance_sys"=>  $relance_sys,
                           'url_preuve_paiement'=>  $url_preuve_paiement,
                           'url_avenant'=>  $url_avenant,
                    ]);

                      return 'inserted';
                          } catch (Exception $e) {
                  dd($e);
              } 

          


      }else{

        return 'charger_document';
      }

    }



   public function reaff_newnote (request $request){


      $dataopp = $request->numopp;
      $id_agent = $request->id_agent; //agent a qui on affecte
      $dateaffect = $request->dateaffect;
      $dateaffect = $dateaffect .' '.date('H:i:s');



      $arraydataopp = explode('|', $dataopp);

      // dd($arraydataopp);
      $idopportunite = $arraydataopp[0];
      $dateecheance  = $arraydataopp[1];
      $daterelance  =  $arraydataopp[2];
      $heurerelance_received= $arraydataopp[3];

      

     




       // dd($daterelance);

      $createheure_relance = $daterelance .' '.$heurerelance_received;

      // dd($createheure_relance);

      $heurerelance = date("Y-m-d H:i:s", strtotime($createheure_relance));
      $daterelance = date("Y-m-d H:i:s", strtotime($daterelance));
        //dd($heurerelance);

       if ($heurerelance_received == ''|| empty($heurerelance_received) || $heurerelance_received =null ) {
        // code...
        $heurerelance = date("Y-m-d H:i:s", strtotime('1980-01-01 00:00:00'));
      }

      if ($dateecheance == '' || $dateecheance == null) {
        // code...
        $dateecheance = null;
      }

// date('Y-m-d H:i:s')

      $observation=  $request->observation;

      $sante=  $request->sante ?? 0;
      $voyage=  $request->voyage ?? 0;
      $autre=  $request->autre ?? 0;
      $flotteauto=  $request->flotteauto ?? 0;
      $inthabitation=  $request->habitation ?? 0;


      $primenet= $arraydataopp[4];
      $primettc= $arraydataopp[5];
      $periode_soucription= $arraydataopp[6];
      $assureur_actuel= $arraydataopp[7];

      // $primenet=  $request->primenet ?? 0;
      //  $primettc=  $request->primettc ?? 0;
      // $assureur_actuel=  $request->assureur ?? 'non defini';
      // $periode_soucription=  $request->periodesousc ?? 0;

      $resultatentretien= $request->resultatentretien;


      $idagentbackoffice = $request->id_agent;


     
      //dd($heurerelance);

      $newInsert = NoteOpportunites::create([
                          "idopportunite"=> $idopportunite,
                           "idagentbackoffice"=>  $idagentbackoffice,
                           "inthabitation"=> $inthabitation,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intvoyage"=>  $voyage,
                           "intautre"=>  $autre,
                           "daterelance"=>$daterelance,
                           "heure_relance"=>$heurerelance,
                           "echeance"=>  $dateecheance,
                           "observation"=>  'reaffectation',
                           "resultat"=>  'poursuivre',
                           "reaff_par"=> Session::get('agentbackofficeid'),
                           "date_affect"=>$dateaffect,
                           "assureur_actuel"=>  $assureur_actuel,
                           "periode_soucription"=>  $periode_soucription,
                           "primettc"=>  $primettc,
                           "primenet"=>  $primenet,
                    ]);

          if(!$newInsert->id){
              return 'Error';
              //$typeError[]=3;
          }else {
             
              return 'inserted';
              //return response()->json(['message' => 'successfull'], 200);
          }

   }


   public function reaff_newnote_rn (request $request){


      $dataopp = $request->numopp;
      $id_agent = $request->id_agent; //agent a qui on affecte
      $dateaffect = $request->dateaffect;
      $dateaffect = $dateaffect .' '.date('H:i:s');



      $arraydataopp = explode('|', $dataopp);

      // dd($arraydataopp);
      $idopportunite = $arraydataopp[0];
      $dateecheance  = $arraydataopp[1];
      $daterelance  =  $arraydataopp[2];
      $heurerelance_received= $arraydataopp[3];




       // dd($daterelance);

      $createheure_relance = $daterelance .' '.$heurerelance_received;

      // dd($createheure_relance);

      $heurerelance = date("Y-m-d H:i:s", strtotime($createheure_relance));
      $daterelance = date("Y-m-d H:i:s", strtotime($daterelance));
        //dd($heurerelance);

       if ($heurerelance_received == ''|| empty($heurerelance_received) || $heurerelance_received =null ) {
        // code...
        $heurerelance = date("Y-m-d H:i:s", strtotime('1980-01-01 00:00:00'));
      }

      if ($dateecheance == '' || $dateecheance == null) {
        // code...
        $dateecheance = null;
      }

// date('Y-m-d H:i:s')

      $observation=  $request->observation;

      $sante=  $request->sante ?? 0;
      $voyage=  $request->voyage ?? 0;
      $autre=  $request->autre ?? 0;
      $flotteauto=  $request->flotteauto ?? 0;
      $inthabitation=  $request->habitation ?? 0;

      // $primenet=  $request->primenet ?? 0;
      //  $primettc=  $request->primettc ?? 0;
      // $assureur_actuel=  $request->assureur ?? 'non defini';
      // $periode_soucription=  $request->periodesousc ?? 0;


      $primenet= $arraydataopp[4];
      $primettc= $arraydataopp[5];
      $periode_soucription= $arraydataopp[6];
      $assureur_actuel= $arraydataopp[7];

      $resultatentretien= $request->resultatentretien;


      $idagentbackoffice = $request->id_agent;


     
      //dd($heurerelance);

      $newInsert = NoteOpportunites::create([
                          "idopportunite"=> $idopportunite,
                           "idagentbackoffice"=>  $idagentbackoffice,
                           "inthabitation"=> $inthabitation,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intflotteauto"=>$flotteauto,
                           "intsante"=>$sante,
                           "intvoyage"=>  $voyage,
                           "intautre"=>  $autre,
                           "daterelance"=>$daterelance,
                           "heure_relance"=>$heurerelance,
                           "echeance"=>  $dateecheance,
                           "observation"=>  'reaffectation_rn',
                           "resultat"=>  'poursuivre_rn',
                           "reaff_par"=> Session::get('agentbackofficeid'),
                           "date_affect"=>$dateaffect,
                           "assureur_actuel"=>  $assureur_actuel,
                           "periode_soucription"=>  $periode_soucription,
                           "primettc"=>  $primettc,
                           "primenet"=>  $primenet,
                    ]);

          if(!$newInsert->id){
              return 'Error';
              //$typeError[]=3;
          }else {
             
              return 'inserted';
              //return response()->json(['message' => 'successfull'], 200);
          }

   }


   public function reaff_newnote_mass (request $request){

      $liste_opp = $request->arraylist;
      $idagentbackoffice = $request->id_agent;
      $dateaffect = $request->dateaffect;
      $dateaffect = $dateaffect.' '.date('H:i:s');


      foreach ($liste_opp as $liste_opp_el ) {
        // code...

            $arraydataopp = explode('|', $liste_opp_el);

            // dd($arraydataopp);
            $idopportunite = $arraydataopp[0];
            $dateecheance  = $arraydataopp[1];
            $daterelance  =  $arraydataopp[2];
            $heurerelance_received= $arraydataopp[3];

            // dd($daterelance);

            $createheure_relance = $daterelance .' '.$heurerelance_received;

            // dd($createheure_relance);

            $heurerelance = date("Y-m-d H:i:s", strtotime($createheure_relance));
            $daterelance = date("Y-m-d H:i:s", strtotime($daterelance));
              //dd($heurerelance);

             if ($heurerelance_received == ''|| empty($heurerelance_received) || $heurerelance_received =null ) {
              // code...
              $heurerelance = date("Y-m-d H:i:s", strtotime('1980-01-01 00:00:00'));
            }


            if ($dateecheance == '' || $dateecheance == null) {
              // code...
              $dateecheance = null;
            }




            $observation=  $request->observation;
            $sante=  $request->sante ?? 0;
            $voyage=  $request->voyage ?? 0;
            $autre=  $request->autre ?? 0;
            $flotteauto=  $request->flotteauto ?? 0;
            $inthabitation=  $request->habitation ?? 0;
            // $primenet=  $request->primenet ?? 0;
            // $primettc=  $request->primettc ?? 0;
            // $assureur_actuel=  $request->assureur ?? 'non defini';
            // $periode_soucription=  $request->periodesousc ?? 0;

            $primenet= $arraydataopp[4];
            $primettc= $arraydataopp[5];
            $periode_soucription= $arraydataopp[6];
            $assureur_actuel= $arraydataopp[7];
            $resultatentretien= $request->resultatentretien;
            $idagentbackoffice = $request->id_agent;
            //dd($heurerelance);

            $newInsert = NoteOpportunites::create([
                                "idopportunite"=> $idopportunite,
                                 "idagentbackoffice"=>  $idagentbackoffice,
                                 "inthabitation"=> $inthabitation,
                                 "intflotteauto"=>$flotteauto,
                                 "intsante"=>$sante,
                                 "intflotteauto"=>$flotteauto,
                                 "intsante"=>$sante,
                                 "intvoyage"=>  $voyage,
                                 "intautre"=>  $autre,
                                 "daterelance"=>$daterelance,
                                 "heure_relance"=>$heurerelance,
                                 "echeance"=>  $dateecheance,
                                 "observation"=>  'reaffectation en masse',
                                 "date_affect"=>$dateaffect,
                                 "resultat"=>  'poursuivre',
                                 "reaff_par"=> Session::get('agentbackofficeid'),
                                 "assureur_actuel"=>  $assureur_actuel,
                                 "periode_soucription"=>  $periode_soucription,
                                 "primettc"=>  $primettc,
                                 "primenet"=>  $primenet,
                          ]);

                if(!$newInsert->id){
                    echo 'Error';
                    //$typeError[]=3;
                }else {
                  //echo 'successfull <br>';
                  //return response()->json(['message' => 'successfull'], 200);
                }

      }

       return 'inserted';


   }




   public function reaff_newnote_mass_rn (request $request){

      $liste_opp = $request->arraylist;
      $idagentbackoffice = $request->id_agent;
      $dateaffect = $request->dateaffect;
      $dateaffect = $dateaffect.' '.date('H:i:s');


      foreach ($liste_opp as $liste_opp_el ) {
        // code...

            $arraydataopp = explode('|', $liste_opp_el);

            // dd($arraydataopp);
            $idopportunite = $arraydataopp[0];
            $dateecheance  = $arraydataopp[1];
            $daterelance  =  $arraydataopp[2];
            $heurerelance_received= $arraydataopp[3];

            // dd($daterelance);

            $createheure_relance = $daterelance .' '.$heurerelance_received;

            // dd($createheure_relance);

            $heurerelance = date("Y-m-d H:i:s", strtotime($createheure_relance));
            $daterelance = date("Y-m-d H:i:s", strtotime($daterelance));
              //dd($heurerelance);

             if ($heurerelance_received == ''|| empty($heurerelance_received) || $heurerelance_received =null ) {
              // code...
              $heurerelance = date("Y-m-d H:i:s", strtotime('1980-01-01 00:00:00'));
            }


            if ($dateecheance == '' || $dateecheance == null) {
              // code...
              $dateecheance = null;
            }




            $observation=  $request->observation;
            $sante=  $request->sante ?? 0;
            $voyage=  $request->voyage ?? 0;
            $autre=  $request->autre ?? 0;
            $flotteauto=  $request->flotteauto ?? 0;
            $inthabitation=  $request->habitation ?? 0;
            // $primenet=  $request->primenet ?? 0;
            // $primettc=  $request->primettc ?? 0;
            // $assureur_actuel=  $request->assureur ?? 'non defini';
            // $periode_soucription=  $request->periodesousc ?? 0;

            $primenet= $arraydataopp[4];
            $primettc= $arraydataopp[5];
            $periode_soucription= $arraydataopp[6];
            $assureur_actuel= $arraydataopp[7];

            $resultatentretien= $request->resultatentretien;
            $idagentbackoffice = $request->id_agent;
            //dd($heurerelance);

            $newInsert = NoteOpportunites::create([
                                "idopportunite"=> $idopportunite,
                                 "idagentbackoffice"=>  $idagentbackoffice,
                                 "inthabitation"=> $inthabitation,
                                 "intflotteauto"=>$flotteauto,
                                 "intsante"=>$sante,
                                 "intflotteauto"=>$flotteauto,
                                 "intsante"=>$sante,
                                 "intvoyage"=>  $voyage,
                                 "intautre"=>  $autre,
                                 "daterelance"=>$daterelance,
                                 "heure_relance"=>$heurerelance,
                                 "echeance"=>  $dateecheance,
                                 "observation"=>  'reaffectation en masse rn',
                                 "date_affect"=>$dateaffect,
                                 "resultat"=>  'poursuivre_rn',
                                 "reaff_par"=> Session::get('agentbackofficeid'),
                                 "assureur_actuel"=>  $assureur_actuel,
                                 "periode_soucription"=>  $periode_soucription,
                                 "primettc"=>  $primettc,
                                 "primenet"=>  $primenet,
                          ]);

                if(!$newInsert->id){
                    echo 'Error';
                    //$typeError[]=3;
                }else {
                  //echo 'successfull <br>';
                  //return response()->json(['message' => 'successfull'], 200);
                }

      }

       return 'inserted';


   }



   // public function loginadmin ( request $request ){

   //      $lastname = $request->adminusername;
   //      $password = $request->adminpwd;

   //      // dd($password);

   //      $findAdministrator = Administrators::where([
   //                ['username', '=', $lastname],
   //                // ['password', '=', $password],
   //                ])->first();

   //     // dd($findAdministrator->count());
   //      $verif = Hash::check($password, $user->password);

   //      if ($verif) {
   //        $foundlogin= $findAdministrator[0]['login'];

   //        dd($foundlogin);
   //        // $foundrole= $finduser[0]['role'];
   //        Session::put('userlogin',$foundlogin);
   //        // Session::put('userrole',$foundrole);
   //        return 'exist';
   //     }else
   //      return 'notexist';

   // }




   public function find_available_agent (request $request){

      $agents_dispo = AgentBackoffices::with('Affectations')
          ->where([
                  // ['privilege', '!=', 'niveau1'],
                  ['isactive', '=', '1']])
          ->orderBy('firstname', 'ASC')
          // ->orWhereNull('privilege')
          ->get()->toArray();

       // dd($agents_dispo);

      return view('available_agents',compact('agents_dispo'));

    }


    public function find_histo_rn (request $request){

      $histo_rnlist = NoteOpportunites::with('Opportunite','AgentBackoffice')
          ->where([
                  ['idopportunite', '=', $request->idopp],
                  ['resultat', '=', 'gagne'],
                  ['isvisible', '=', '1']])
          // ->orWhereNull('privilege')
          ->get()->toArray();

         // dd($histo_rnlist);

      return view('historique_rn',compact('histo_rnlist'));

    }

    public function stat_compagnie (request $request){

     $datedebut = $request->datedebut ?? date('Y-m-d');
     $datefin = $request->datefin ?? date('Y-m-d');

          $stat_comp = NoteOpportunites::select('assureur_actuel')
          ->whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
          ->where('resultat', '=', "gagne")
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))
          ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%RN%") then 1 else 0 end) as nombre_contrat_rn'))
          ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%AN%") then 1 else 0 end) as nombre_contrat_an'))
          ->groupBy('assureur_actuel')
          ->get()->toArray();


    return view('stats_compagnie', compact('stat_comp','datedebut','datefin'));

    }


    public function stat_renouvellement(request $request){

      $datedebut = date('Y-m-d');
      $datefin = date('Y-m-d');
       

       $nbre_rn_attendu = NoteOpportunites::with('Opportunite','AgentBackoffice')
          ->where([
                  ['resultat', '=', 'gagne'],
                  ['isvisible', '=', '1']])
          ->whereDate('echeance','>=', $datedebut)
          ->whereDate('echeance','<=', $datefin)
          ->get()->count();


        // $renouv_eff = NoteOpportunites::where([
        //         ['resultat', '=', 'gagne'],
        //         ['isvisible', '=', '1']])
        // ->whereDate('created_at','>=', $datedebut)
        // ->whereDate('created_at','<=', $datefin)
        //  ->select('idopportunite')
        // ->get();

          $renouv_eff = Contrats::where([
              ['numpolice', 'LIKE', "%RN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at','>=', $datedebut)
              ->whereDate('created_at','<=', $datefin)
              ->select('idopportunite')
              ->get();



        $nbre_rn_eff = Contrats::where([
              ['numpolice', 'LIKE', "%RN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at','>=', $datedebut)
              ->whereDate('created_at','<=', $datefin)
           ->count();

         $renouv_eff_array= $renouv_eff->toArray();


      // dd($renouv_eff);

      $nbre_rn_eff = $renouv_eff->count();

      // $renouv_eff_av = NoteOpportunites::where([
      //           ['resultat', '=', 'gagne'],
      //           ['isvisible', '=', '1']])
      //   ->whereDate('echeance','<', $datedebut)
      //   ->select('idopportunite')
      //   ->get()->toArray();


    $renouv_eff_av = NoteOpportunites::whereIn('id', function($query) {
        $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['resultat', '=', 'gagne'],
                ['isvisible', '=', '1']])
        ->whereDate('echeance','<', $datefin)
        // ->groupBy('idopportunite',)
        ->select('idopportunite')
        ->get()->toArray();


        $nbre_rn_rattrap = NoteOpportunites::whereIn('idopportunite',$renouv_eff_av)->where([
                ['resultat', '=', 'gagne'],
                ['isvisible', '=', '1']])
        ->whereDate('created_at','>=', $datedebut)
        ->whereDate('created_at','<=', $datefin)
        ->get()->count();



        //rn attendu non dans rn effectue
        $nbre_rn_non_eff = NoteOpportunites::whereNotIn('idopportunite',$renouv_eff_array)
          ->where([
                  ['resultat', '=', 'gagne'],
                  ['isvisible', '=', '1']])
          ->whereDate('echeance','>=', $datedebut)
          ->whereDate('echeance','<=', $datefin)
          ->get()->count();

      // return view('stats_renouvellement',compact('renouv_attendu','datedebut','datefin'));
        return view('stats_renouvellement',compact('nbre_rn_attendu','nbre_rn_eff','nbre_rn_rattrap','nbre_rn_non_eff','datedebut','datefin'));

    }


    public function filter_stat_renouvellemnt(request $request){

      // $datedebut = date('Y-m-d');
      // $datefin = date('Y-m-d');
       $datefin=$request->datefin;
       $datedebut=$request->datedebut;

       //renouvellement attendus OK
       $nbre_rn_attendu = NoteOpportunites::with('Opportunite','AgentBackoffice')
          ->where([
                  ['resultat', '=', 'gagne'],
                  ['isvisible', '=', '1']])
          ->whereDate('echeance','>=', $datedebut)
          ->whereDate('echeance','<=', $datefin)
          ->get()->count();

         //liste opp renouvellement effectués OK
        $renouv_eff = Contrats::where([
              ['numpolice', 'LIKE', "%RN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at','>=', $datedebut)
              ->whereDate('created_at','<=', $datefin)
              ->select('idopportunite')
              ->get();
        $renouv_eff_array= $renouv_eff->toArray();


         //nbre renouvellement effectués OK
        $nbre_rn_eff = Contrats::where([
              ['numpolice', 'LIKE', "%RN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at','>=', $datedebut)
              ->whereDate('created_at','<=', $datefin)
           ->count();

 

      $renouv_eff_av = NoteOpportunites::whereIn('id', function($query) {
        $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['resultat', '=', 'gagne'],
                ['isvisible', '=', '1']])
        ->whereDate('echeance','<', $datefin)
        // ->groupBy('idopportunite',)
        ->select('idopportunite')
        ->get()->toArray();
        // dd($renouv_eff_av);



        $nbre_rn_rattrap = NoteOpportunites::whereIn('idopportunite',$renouv_eff_av)->where([
                ['resultat', '=', 'gagne'],
                ['isvisible', '=', '1']])
        ->whereDate('created_at','>=', $datedebut)
        ->whereDate('created_at','<=', $datefin)
        ->get()->count();



        //rn attendu non dans rn effectue
        $nbre_rn_non_eff = NoteOpportunites::whereNotIn('idopportunite',$renouv_eff_array)
          ->where([
                  ['resultat', '=', 'gagne'],
                  ['isvisible', '=', '1']])
          ->whereDate('echeance','>=', $datedebut)
          ->whereDate('echeance','<=', $datefin)
          ->get()->count();




       // ->get()->toArray();
       // dd($renouv_effa);

      return view('stats_renouvellement',compact('nbre_rn_attendu','nbre_rn_eff','nbre_rn_rattrap','nbre_rn_non_eff','datedebut','datefin'));

    }

    

    


    public function find_available_agent_mass (request $request){

      $agents_dispo = AgentBackoffices::with('Affectations')
          ->where([
                  // ['privilege', '!=', 'niveau1'],
                  ['isactive', '=', '1']
                ])
           // ->orWhereNull('privilege')
          ->get()->toArray();

       // dd($agents_dispo);

      return view('available_agents_mass',compact('agents_dispo'));

    }


  public function attrib_opportunite (request $request){

    

    $idopportunite = $request->numopp;
    $idagentbackoffice = $request->id_agent;
    $dateaffect = $request->dateaffect;


  


    $findifexist = AffectationOpportunites::where([
                                  'idopportunite'=>$idopportunite,
                              ])->get();

    if ($findifexist->count() >=1) {
      // code...
   
             try {
                $newInsert = AffectationOpportunites::where([
                                  'idopportunite'=>$idopportunite,
                              ])->update(['status'=>0,
                            ]);
                 // return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }
         }

      $newInsert = AffectationOpportunites::create([
                          'idopportunite'=>$idopportunite,
                          'idagentbackoffice'=>$idagentbackoffice,
                          'date_affect'=>$dateaffect,
                          'donebyuser'=>Session::get('agentbackofficeid'),
                          'status'=>1,
                      ]);

            if(!$newInsert->id){
                return 'Error';
            }else {
                return 'inserted';
            }


  }


  public function attrib_opportunite_mass (request $request){


    $liste_opp = $request->arraylist;
    $idagentbackoffice = $request->id_agent;
    $dateaffect = $request->dateaffect;


    foreach ($liste_opp as $liste_opp_el) {
      // code...
      // $toInsert[] = [
      //       'idopportunite'=>$liste_opp_el,
      //       'idagentbackoffice'=>$idagentbackoffice,
      //       'donebyuser' => Session::get('agentbackofficeid'),
      //       'created_at'=>date('Y-m-d H:i:s'),
      //       'updated_at'=>date('Y-m-d H:i:s')
      //   ];


    $findifexist = AffectationOpportunites::where([
                              'idopportunite'=>$liste_opp_el,
                          ])->get();

    if ($findifexist->count() >=1) {
         try {
            $newInsert = AffectationOpportunites::where([
                              'idopportunite'=>$liste_opp_el,
                          ])->update(['status'=>0,
                        ]);
             // return'inserted';
              }
            catch (\Illuminate\Database\QueryException $ex) {
                 // Do whatever you need if the query failed to execute
                 // dd($ex);
                   return'error';
              }
        }

      $newInsert = AffectationOpportunites::create([
                          'idopportunite'=>$liste_opp_el,
                          'idagentbackoffice'=>$idagentbackoffice,
                          'date_affect'=>$dateaffect,
                          'donebyuser'=>Session::get('agentbackofficeid'),
                          'status'=>1,
                      ]);

            if(!$newInsert->id){
                return 'Error';
            }


    }

    return 'inserted';

     // dd($toInsert);
    // EnAnswer::insert($answers);
     // $newInsert = AffectationOpportunites::insert($toInsert);

     // if($newInsert) {
     //  // the query succeed
     //  return 'inserted';
     //  } else {
     //      // the query failed
     //     return 'Error';
     //  }

     



      // $newInsert = AffectationOpportunites::create([
      //                     'idopportunite'=>$idopportunite,
      //                     'idagentbackoffice'=>$idagentbackoffice,
      //                     'donebyuser'=>Session::get('agentbackofficeid'),
      //                 ]);

      //       if(!$newInsert->id){
      //           return 'Error';
      //       }else {
      //           return 'inserted';
      //       }


  }


  public function q_mass (request $request){



    $liste_opp = $request->arraylist;
    $idagentbackoffice = $request->id_agent;

    foreach ($liste_opp as $liste_opp_el) {
      // code...
      


      //   $dataopp = $request->numopp;
      // $id_agent = $request->id_agent;



      $arraydataopp = explode('|', $liste_opp_el);

      // dd($arraydataopp);
      $idopportunite = $arraydataopp[0];
      $dateecheance  = $arraydataopp[1];
      $daterelance  =  $arraydataopp[2];
      $heurerelance_received= $arraydataopp[3];




       // dd($daterelance);

      $createheure_relance = $daterelance .' '.$heurerelance_received;

      // dd($createheure_relance);

      $heurerelance = date("Y-m-d H:i:s", strtotime($createheure_relance));
      $daterelance = date("Y-m-d H:i:s", strtotime($daterelance));
        //dd($heurerelance);

       if ($heurerelance_received == ''|| empty($heurerelance_received) || $heurerelance_received =null ) {
        // code...
        $heurerelance = date("Y-m-d H:i:s", strtotime('1980-01-01 00:00:00'));
      }

// date('Y-m-d H:i:s')

      $observation=  $request->observation;

      $sante=  $request->sante ?? 0;
      $voyage=  $request->voyage ?? 0;
      $autre=  $request->autre ?? 0;
      $flotteauto=  $request->flotteauto ?? 0;
      $inthabitation=  $request->habitation ?? 0;

      $primenet=  $request->primenet ?? 0;
       $primettc=  $request->primettc ?? 0;
      $assureur_actuel=  $request->assureur ?? 'non defini';
      $periode_soucription=  $request->periodesousc ?? 0;

      $resultatentretien= $request->resultatentretien;


      $idagentbackoffice = $request->id_agent;


     
      //dd($heurerelance);

      $toInsert[] = [
           "idopportunite"=> $idopportunite,
           "idagentbackoffice"=>  $idagentbackoffice,
           "inthabitation"=> $inthabitation,
           "intflotteauto"=>$flotteauto,
           "intsante"=>$sante,
           "intflotteauto"=>$flotteauto,
           "intsante"=>$sante,
           "intvoyage"=>  $voyage,
           "intautre"=>  $autre,
           "daterelance"=>$daterelance,
           "heure_relance"=>$heurerelance,
           "echeance"=>  $dateecheance,
           "observation"=>  'reaffectation',
           "resultat"=>  'poursuivre',
           "assureur_actuel"=>  $assureur_actuel,
           "periode_soucription"=>  $periode_soucription,
           "primettc"=>  $primettc,
           "primenet"=>  $primenet,
        ];
      }

      $newInsert = NoteOpportunites::insert($toInsert);

     if($newInsert) {
      // the query succeed
      return 'inserted';
      } else {
          // the query failed
         return 'Error';
      }

      // $newInsert = NoteOpportunites::create([
      //                     "idopportunite"=> $idopportunite,
      //                      "idagentbackoffice"=>  $idagentbackoffice,
      //                      "inthabitation"=> $inthabitation,
      //                      "intflotteauto"=>$flotteauto,
      //                      "intsante"=>$sante,
      //                      "intflotteauto"=>$flotteauto,
      //                      "intsante"=>$sante,
      //                      "intvoyage"=>  $voyage,
      //                      "intautre"=>  $autre,
      //                      "daterelance"=>$daterelance,
      //                      "heure_relance"=>$heurerelance,
      //                      "echeance"=>  $dateecheance,
      //                      "observation"=>  'reaffectation',
      //                      "resultat"=>  'poursuivre',
      //                      "assureur_actuel"=>  $assureur_actuel,
      //                      "periode_soucription"=>  $periode_soucription,
      //                      "primettc"=>  $primettc,
      //                      "primenet"=>  $primenet,
      //               ]);

      //     if(!$newInsert->id){
      //         return 'Error';
      //         //$typeError[]=3;
      //     }else {
             
      //         return 'inserted';
      //         //return response()->json(['message' => 'successfull'], 200);
      //     }







    }



    public function create_car_brand (request $request){

       return view('create_brand');
    }


    public function create_car_model (request $request){


       $carlist = Cars::select('brand')->groupBy('brand')->get()->toArray();
       $carlist2 = CarBrands::all()->toArray();
      
       return view('create_model',compact('carlist','carlist2'));
    }

  
    public function create_vehicule (request $request){

      $carlist = Cars::select('brand')->groupBy('brand')->get()->toArray();
       $carlist2 = CarBrands::all()->toArray();
      $car_type_list = Cars::select('type')->groupBy('type')->get()->toArray();
      return view('create_vehicule',compact('carlist','carlist2','car_type_list'));
    }  


    public function edit_car ($idcar,$cardate){


      $cardetails= Cars::with('carsvalues')
      ->where('id','=',$idcar)
      ->get()->toArray();

      // dd($cardetails);




      $cardetails = Cars::with(['carsvalues'=> function ( $query) use ($cardate)  {
          $query->where('date', 'like', $cardate);
      }])
      ->where('id','like',$idcar)
      ->get()->toArray();


       // dd($cardetails);

      return view('edit_vehicule',compact('cardetails',));
    } 


    public function liste_vehicule (request $request){

       // $listevehicule= Cars::with('CarsValues')->limit(10)->get()->toArray();
       $listevehicule= CarsValues::with('Carfamily')->get()->toArray();

       

        // dd($listevehicule);
       return view('liste_vehicule',compact('listevehicule'));
    }   




    public function create_cbrand (request $request){


         $marque = $request->marque;
        $newInsert = CarBrands::create([
                        'libelle'=>$marque,
                        'isvisible'=>1,
                    ]);

          if(!$newInsert->id){
              return 'Error';
          }else {
              return 'inserted';
        }

    }

    public function create_cmodel (request $request){


         $marque = $request->marque;
           $carmodel = $request->carmodel;
        $newInsert = CarModels::create([
                        'libelle'=>$carmodel,
                         'marque'=>$marque,
                        'isvisible'=>1,
                    ]);

          if(!$newInsert->id){
              return 'Error';
          }else {
              return 'inserted';
        }
      
    }


    public function save_new_cars (request $request){


          $marque = $request->marque;
          $carmodel = $request->model;
          $type = $request->typevehicule;
          $nombreplace = $request->nombreplace;
          $annsortie = $request->annsortie;

          $valeurneuve = $request->valeurneuve;
          $carcode = str_replace(' ', '', $marque.$carmodel);



          $newInsert = Cars::create([
                         'car_code'=>$carcode,
                         'type'=>$type,
                         'brand'=>$carmodel,
                         'model'=>$carmodel,
                         'places'=>$nombreplace,
                         'power'=>$marque,
                         'isvisible'=>1,
                    ]);
          // if(!$newInsert->id){
          //     return 'Error';
          // }else {
          //     return 'inserted';


          $newInsertCv = CarsValues::create([
                         'date'=>$annsortie,
                         'amount'=>$valeurneuve,
                         'car_code'=>$carcode,
                         
                    ]);
          if(!$newInsertCv->id){
              return 'Error';
          }else {
              return 'inserted';
        }
      
    }


    public function update_cars (request $request){

            


 // $request->annsortie
 // $request->valeurneuve

          //           $newInsert = Cars::create([
          //                'car_code'=>$carcode,
          //                'type'=>$type,
          //                'brand'=>$carmodel,
          //                'model'=>$carmodel,
          //                'places'=>$nombreplace,
          //                'power'=>$marque,
          //                'isvisible'=>1,
          //           ]);
          // // if(!$newInsert->id){
          // //     return 'Error';
          // // }else {
          // //     return 'inserted';


          // $newInsertCv = CarsValues::create([
          //                'date'=>$annsortie,
          //                'amount'=>$valeurneuve,
          //                'car_code'=>$carcode,
          //                ]);

        try {
                $newInsert = Cars::where([
                                  'id'=> $request->carid,
                              ])->update(
                                [
                                 // 'car_code'=>$carcode,
                                 'type'=> $request->typevehicule,
                                 'brand'=>$request->marque,
                                 'model'=>$request->model,
                                 'places'=> $request->nombreplace,
                                 'power'=>$request->puissance,
                                 // 'isvisible'=>1,
                            ]);
                 // return'inserted';
                  }
        catch (\Illuminate\Database\QueryException $ex) {
             // Do whatever you need if the query failed to execute
             // dd($ex);
            }



          try {
                $newInsert = CarsValues::where([
                                  'car_code'=>$request->car_code,
                                   'date'=>$request->annsortie,
                              ])->update(
                                [
                                  'date'=>$request->annsortie,
                                  'amount'=>$request->valeurneuve,
                                  // 'car_code'=>$request->car_code
                            ]);
                  return'inserted';
                  }
        catch (\Illuminate\Database\QueryException $ex) {
             // Do whatever you need if the query failed to execute
             // dd($ex);
            }



    }


}

