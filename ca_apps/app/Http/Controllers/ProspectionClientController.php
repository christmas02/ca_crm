<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\ProspectionClient;
use App\Models\Prospectors;
use App\Models\NoteOpportunites;
use App\Models\AffectationOpportunites;
use App\Models\AgentBackoffices;
use App\Models\Contrats;
use App\Models\Canals;
use App\Models\Assureur;
use App\Models\PrivilegesAgentBo;
use Illuminate\Support\Facades\Hash;
use Excel;
use App\Imports\ProspectionClientImport;
use Carbon\Carbon;
use Storage;
use Session;
use DateTime;
use DB;
use Illuminate\Support\Benchmark;


class ProspectionClientController extends Controller
{
    //

    public function addProspect(Request $request)
    {


        //return ' bonjour';

        $typeError = array();
        $nom = request()->nom;
        $prenoms = request()->prenoms;
        $Telephone = request()->Telephone;
        $Echeance = request()->Echeance;
        $lieuprospection = request()->lieuprospection;
        $observation = request()->observation;
        $urlcarte_grise = request()->carte_grise;
        $url_attestationassurance = request()->attestation;
        $realiserpar = request()->realiserpar;
        $canal =  request()->canal;

        $Telephone =str_replace(' ', '', $Telephone);

         $dir="test/";
         $imgattesation = $request->file('attestation');
         $imgcartegrise = $request->file('carte_grise');
         $url_attestationassurance ='';
         $urlcarte_grise='';

         // dd(request());

      
        if ($request->has('attestation')) {
                $imageAttestationName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgattesation->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageAttestationName, file_get_contents($imgattesation));
                $url_attestationassurance = '/storage/test/'.$imageAttestationName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            $typeError[]=1;
            // return response()->json(['message' => 'failed to upload attestation'], 400);
        } 
       // return response()->json(['message' => trans('/storage/test/'.$imageAttestationName)], 200);



        if ($request->has('carte_grise')) {
                $imageCartegriseName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgcartegrise->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageCartegriseName, file_get_contents($imgcartegrise));
                $urlcarte_grise = '/storage/test/'.$imageCartegriseName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            // return response()->json(['message' => 'failed to upload carte grise'], 400);
            $typeError[]=2;
        } 
       // return response()->json(['message' => trans('/storage/test/'.$imageCartegriseName)], 200);






        $newInsert = ProspectionClient::create([
                          "nom"=> $nom,
                           "prenoms"=>  $prenoms,
                           "canal"=>  $canal,
                           "telephone"=> $Telephone,
                           "echeance"=>   $Echeance,
                           "lieuprospection"=>$lieuprospection,
                           "observation"=>  $observation,
                           "urlcarte_grise_terrain"=>  $urlcarte_grise,
                           "url_attestationassurance_terrain"=>$url_attestationassurance,
                           "realiserpar"=>  $realiserpar,
                    ]);

          if(!$newInsert->id){
              return 'Error';
              $typeError[]=3;
          }else {
              // return  response()->json('successfull', 200);
              return response()->json(['message' => 'successfull'], 200);
          }
        // return response()->json('notinserted', 200);
        
        // return 'bonjour';
        // $image = new ProspectionClient;

        // $image->title = $request->title;
        
        //     if ($request->hasFile('image')) {
            
        //     $path = $request->file('image')->store('prospection_clients');
        //     $image->url = $path;
        //    }
        // $image->save();
        // return new ImageResource($image);
   }



   public function addProspectOnline(Request $request)
    {


        //return ' bonjour';

        $typeError = array();



        $nom = request()->nom;
        $prenoms = request()->prenoms;
        $Telephone = request()->Telephone;
        $Echeance = request()->Echeance;
        $lieuprospection = request()->lieuprospection;
        $observation = request()->observation;
        $urlcarte_grise = request()->Imgcartegrise;
        $url_attestationassurance = request()->Imgattesation;
        $realiserpar = request()->realiserpar;
        $realiserparAgent = Session::get('agentbackofficeid');
        $isasap = request()->isasap;
        $canal = request()->canal;
        $statut = request()->resultatentretien;
        $plaqueimma = request()->plaqueimma;
        
        $Telephone =str_replace(' ', '', $Telephone);  







        //verifier que le num nexiste pas en base 

        $nombre_occ = ProspectionClient::where('telephone', 'LIKE', '%'.$Telephone.'%')
         ->orWhere('telephone2','LIKE', '%'.$Telephone.'%')
         ->orWhere('telephone','LIKE', '%'.$Telephone.'%')
         ->orWhere('telephone2','LIKE', '%'.$Telephone.'%')
         ->count();



        $privarray=  Session::get('userprivilege_list');


        //end  verification 


         if ($nombre_occ <=0 || in_array(28, $privarray)) {
             // code...
        

         $dir="test/";
         $imgattesation = $request->file('Imgattesation');
         $imgcartegrise = $request->file('Imgcartegrise');
         $url_attestationassurance ='';
         $urlcarte_grise='';

      
        if ($request->hasFile('Imgattesation')) {
                $imageAttestationName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgattesation->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageAttestationName, file_get_contents($imgattesation));
                $url_attestationassurance = '/storage/test/'.$imageAttestationName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            $typeError[]=1;
            // return response()->json(['message' => 'failed to upload attestation'], 400);
        } 
       // return response()->json(['message' => trans('/storage/test/'.$imageAttestationName)], 200);



        if ($request->hasFile('Imgcartegrise')) {
                $imageCartegriseName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgcartegrise->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageCartegriseName, file_get_contents($imgcartegrise));
                $urlcarte_grise = '/storage/test/'.$imageCartegriseName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            // return response()->json(['message' => 'failed to upload carte grise'], 400);
            $typeError[]=2;
        } 
       // return response()->json(['message' => trans('/storage/test/'.$imageCartegriseName)], 200);





        $newInsert = ProspectionClient::create([
                          "nom"=> $nom,
                           "prenoms"=>  $prenoms,
                           "isasap"=>  $isasap,
                           "canal"=>  $canal,
                           "statut"=>  $statut,
                           "telephone"=> $Telephone,
                           "echeance"=>   $Echeance,
                           "lieuprospection"=>$lieuprospection,
                           "observation"=>  $observation,
                           "plaque_immatriculation"=>  $plaqueimma,
                           "urlcarte_grise"=>  $urlcarte_grise,
                           "url_attestationassurance"=>$url_attestationassurance,
                           "realiserpar"=>  $realiserpar,
                           "idagentbackoffice"=>  $realiserparAgent,
                           
                    ]);

          if(!$newInsert->id){
              return 'Error';
              $typeError[]=3;
          }else {
              // return  response()->json('successfull', 200);
              return response()->json(['message' => 'successfull'], 200);
          }

        }
        else
            return response()->json(['message' => 'numero exist deja'], 201);
   }


   public function loginprospect (Request $request){

        $prospectNumber = $request->prospectNumber;
        $prospectPwd = $request->prospectProspectPwd;

        $findPropector = Prospectors::where([
                  ['phonenumber', '=', $prospectNumber],
                  ['isactive', '=', 1],
                  ])->get();

        // dd($findPropector->password);

        if ($findPropector->count() ==1) {
            // code...

            $arraysProspectors = $findPropector->toArray();
            // dd($arraysProspectors);
            $verif = Hash::check($prospectPwd, $arraysProspectors[0]['password']);

            if ($verif) {
              // $foundlogin= $findPropector[0]['login'];
              // // $foundrole= $finduser[0]['role'];
              // Session::put('userlogin',$foundlogin);
              // // Session::put('userrole',$foundrole);
              // return $arraysProspectors;

             return $findPropector;
             //return response()->json($arraysProspectors, 200);
             
           }else
             return response()->json('not exist', 204);
        }else
        return response()->json('not exist', 204);
        

   }




   public function listeprosprection (Request $request){

    $Yesterday=date('d.m.Y',strtotime("-1 days"));
   
    $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();

    $filter_Array = [];

    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
       
    }
    
     $filter_Array = array_filter($filter_Array);

  // Benchmark::dd(fn() =>
     $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->doesntHave('commentaires')->whereNotIn('telephone', $filter_Array)
    ->where([
        ['idagentbackoffice', '=', null],
        ['isvisible', '=', 1],
    ])//->whereDate('created_at','=',$Yesterday)
    ->orderBy('created_at','DESC')
    ->get()->toArray();
    // , 20);

    return view('liste_prospection', compact('listeprospection'));

   }


   



    public function opportunite_supprimees (Request $request){

     $listeprospection = ProspectionClient::with('AgentTerrain','affectation')
    ->where([
        ['isvisible', '=', 0],
    ])
    ->orderBy('created_at','DESC')
    ->get()->toArray();


    return view('liste_prospection_suppr', compact('listeprospection'));

   }


   public function retrouver_opportunite (Request $request){

     $listeprospection= [];

     return view('retrouve_opp',compact('listeprospection'));
   }


   public function recap_stat_opp (Request $request){


        $currentdate= date('Y-m-d');
        // $listeprospection = NoteOpportunites::with('Opportunite')->whereIn('id', function($query) {
        // $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        // })->where([
        //          ['resultat', '=', 'gagne'],
        //          ['created_at', '=', $currentdate],
        //         ])->orderBy('heure_relance', 'ASC')
        //         ->get()->toArray();


         $listeprospection = NoteOpportunites::with('Opportunite.affectation','AgentBackoffice','Affectations')->whereIn('id', function($query) {
        $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                  ['resultat', '=', 'gagne'],
                  ['isvisible', '=', 1],
                 ])->whereDate('created_at', '=', $currentdate)
                   ->orderBy('heure_relance', 'ASC')
                ->get()->toArray();



        //dd($listeprospection);

    // $currentdate= date('Y-m-d');
    // $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->where([
    //               ['resultat', '=', 'gagne'],
    //               ['created_at', '=', $currentdate],
    //              ])->orderBy('heure_relance', 'ASC')
    //              ->get()->toArray();


    // dd($listeprospection);

     return view('recap_statut_opp',compact('listeprospection','currentdate'));
   }



   public function filter_recap_stat_opp (Request $request){

    $datedebut = $request->datedebut;
    $datefin  = $request->datefin;
    $statutdemande  = $request->statutdemande;


     // dd($statutdemande);
    

    // $currentdate= date('Y-m-d');
    // $listeprospection = NoteOpportunites::with('Opportunite.affectation','AgentBackoffice','Affectations')
    //       ->where([
    //               ['resultat', '=', $statutdemande],
    //               ['isvisible', '=', 1],
    //              ])->whereDate('created_at', '>=', $datedebut)
    //                ->whereDate('created_at', '<=', $datefin)
    //                ->orderBy('heure_relance', 'ASC')->limit(10)
    //                ->get()->toArray();
    $listeprospection;
    if ($statutdemande != 'rdvsouscription') {
        // code...
    
        $listeprospection = NoteOpportunites::with('Opportunite.affectation','AgentBackoffice','Affectations')->whereIn('id', function($query) {
        $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                  ['resultat', 'LIKE', '%'.$statutdemande.'%'],
                  ['isvisible', '=', 1],
                 ])->whereDate('created_at', '>=', $datedebut)
                   ->whereDate('created_at', '<=', $datefin)
                   ->orderBy('heure_relance', 'ASC')
                ->get()->toArray();

    }else {

         $listeprospection = NoteOpportunites::with('Opportunite.affectation','AgentBackoffice','Affectations')->whereIn('id', function($query) {
        $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                  ['resultat', 'LIKE', '%'.$statutdemande.'%'],
                  ['isvisible', '=', 1],
                 ])->whereDate('daterelance', '>=', $datedebut)
                   ->whereDate('daterelance', '<=', $datefin)
                   ->orderBy('heure_relance', 'ASC')
                ->get()->toArray();

    }
 // "id" => 73929
 //    "idopportunite" => 27742
  // dd($listeprospection);

     return view('recap_statut_opp',compact('listeprospection','datedebut','datefin','statutdemande'));
   }



   


   public function cg_non_verif (Request $request){

    $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();

    $filter_Array = [];

    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
       
    }
    
     $filter_Array = array_filter($filter_Array);
    //  $listeprospection = ProspectionClient::with('AgentTerrain','affectation.AgentBackoffice')->whereNotIn('telephone', $filter_Array)
    // ->where([
    //     ['isvisible', '=', 1],
    // ])
    // ->whereNull('statut_carte_grise')
    // ->get()->toArray();



$listeprospection = ProspectionClient::with(['affectation' => function ($query) {
        $query->where([
            ['status', '=', '1'],
            // ['resultat', '!=', 'horscible'], 
            // ['isvisible', '=', 1],
        ]);
    },'AgentTerrain','affectation.AgentBackoffice'])
    // ->whereIn('id', function($query) {
    //            $query->from('contrats')->select('commentaire');;
    ->whereNotIn('telephone', $filter_Array)
    ->where([
        ['isvisible', '=', 1],
        ['urlcarte_grise_terrain', '!=', ''],
    ])
    ->whereNull('statut_carte_grise')
    ->whereNotNull('urlcarte_grise_terrain')
    ->whereNotNull('realiserpar')//->limit(1000)
    ->orderBy('created_at', 'DESC')
    ->get()->toArray();

   

    return view('liste_cg_non_verif', compact('listeprospection'));

   }


   public function listeprosprection_doublon (Request $request){


    // $duplicates = DB::table('users')
    // ->select('name','location', DB::raw('COUNT(*) as `count`'))
    // ->groupBy('name', 'location')
    // ->havingRaw('COUNT(*) > 1')
    // ->get();


    // $listeprospection = ProspectionClient::with('AgentTerrain','affectation')
    // //->where('idagentbackoffice', '=', null)
    // ->select('nom', 'prenoms','telephone', 'echeance', 'observation', 'realiserpar', DB::raw('COUNT(*) as `count`'))
    // ->groupBy('nom', 'prenoms','telephone', 'echeance', 'observation', 'realiserpar')
    // ->having('count', '>', 1)
    // ->orderBy('telephone', 'DESC')
    // ->get()->toArray();


    $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();

    $filter_Array = [];

    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
       
    }
    

    // dd($doublontel);


    $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->whereIn('telephone', $doublontel)
    ->where([
        ['isvisible', '=', 1],
    ])
     ->orderBy('telephone', 'asc')
    ->get()->toArray();

    //dd($listeprospection);

    return view('liste_prospection_doublon', compact('listeprospection'));


   }


   public function listeprosprectioncreatedonline (Request $request){



    // $listecommerciaux = AgentBackoffices::all()->toArray();

    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

    $listeprospection = ProspectionClient::with('AgentTerrain','AgentEnligne')
    ->where('idagentbackoffice', '!=', null)->limit(500)
    ->get()->toArray();
    //  dd($listeprospection);

  

    return view('liste_prospection_created_online', compact('listeprospection','listecommerciaux'));

   }


   


    public function listeprosprectionbytel (Request $request){


    // filtre doublon
    $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();

    $filter_Array = [];

    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
       
    }
    
     $filter_Array = array_filter($filter_Array);

    //fin filtre doublon


    $tel=  $request->telfiltre;
    $telclean=  str_replace(' ', '', $request->telfiltre);
    // $listeprospection_filtered = ProspectionClient::with('AgentTerrain','affectation')
    //  ->whereNotIn('telephone', $filter_Array)

    //  ->get();




    //  $listeprospection = $listeprospection_filtered
    //  ->where('telephone', 'LIKE', '%'.$telclean.'%')
    //  ->orWhere('telephone2','LIKE', '%'.$telclean.'%')
    //  ->orWhere('telephone','LIKE', '%'.$tel.'%')
    //  ->orWhere('telephone2','LIKE', '%'.$tel.'%')
    //  ->get()->toArray();



    //   //opportunite relance
    // $liste_relances_filter = ProspectionClient::with('AgentTerrain','affectation')->whereNotIn('telephone', $filter_Array)->select('id')->whereIn('idopportunite', function($query) use ($telclean) {
    //                  $query->from('prospection_clients')
    //                  ->where([
    //                         ['isvisible', '=', 1],
    //                         ['telephone', 'LIKE', '%'.$telclean.'%']
    //                 ])->orWhere('telephone','LIKE', '%'.$telclean.'%')
    //                  ->orWhere('telephone2','LIKE', '%'.$telclean.'%')
    //                  ->orWhere('telephone2','LIKE', '%'.$telclean.'%')
    //                  ->select('id',);
    //                })
    // ->get()->toArray();



     $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->whereNotIn('telephone', $filter_Array)->where(function ($query)use ($telclean,$tel) {
                $query->where('telephone', 'LIKE', '%'.$telclean.'%')
                     ->orWhere('telephone2','LIKE', '%'.$telclean.'%')
                     ->orWhere('telephone','LIKE', '%'.$tel.'%')
                     ->orWhere('telephone2','LIKE', '%'.$tel.'%'); 
                 })
             ->get()->toArray();

    
    // dd($listeprospection);






    return view('liste_prospection_byagent_tel', compact('listeprospection', 'tel'));

   }

   public function listeprosprectionbyname (Request $request){

    $namefilter=  $request->namefilter;

    $listeprospection = ProspectionClient::with('AgentTerrain','affectation')
     ->where('nom', 'LIKE', '%'.$namefilter.'%')
     ->orWhere('prenoms','LIKE', '%'.$namefilter.'%')
     ->get()->toArray();


    return view('liste_prospection', compact('listeprospection', 'namefilter'));

   }

   public function listeprosprectionbycanal (Request $request){

    $canalfilter=  $request->canal;

    $listeprospection = ProspectionClient::with('AgentTerrain','affectation')
     ->where('canal', 'LIKE', '%'.$canalfilter.'%')
     ->get()->toArray();


    return view('liste_prospection', compact('listeprospection', 'canalfilter'));

   }

   


   public function findoppbyname (Request $request){

    $namefilter=  $request->namefilter;

    $listeprospection = ProspectionClient::with(['AgentTerrain','affectation.AgentBackoffice','commentaires' => function ($query)  {
            $query->latest();
         }])
     ->where([
        ['nom', 'LIKE', '%'.$namefilter.'%'],
        ['isvisible', '=', '1'],
    ])
     ->orWhere([
        ['prenoms','LIKE', '%'.$namefilter.'%'],
        ['isvisible', '=', '1'],
    ])
     ->OrWhere([
        [DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%"],
        ['isvisible', '=', '1'],
    ])
     ->get()->toArray();


    //  $listeprospection = AffectationOpportunites::with(['Opportunites' => function ($query) use ($tel) {
    //     $query->where([
    //         ['telephone',  'LIKE', '%'.$tel.'%'],
    //         // ['isvisible', '=', 1],
    //     ])->orWhere([
    //         ['telephone2',  'LIKE', '%'.$tel.'%'],
    //         // ['isvisible', '=', 1]
    //     ]);
    // },'commentaire.AgentBackoffice'])->get()->toArray();

     // dd($listeprospection);


    return view('retrouve_opp', compact('listeprospection', 'namefilter'));

   }


   public function findoppbytel (Request $request){

    $tel = $request->telfiltre;
    // terence

    $telclean=  str_replace(' ', '', $request->telfiltre);
    $listeprospection = ProspectionClient::with(['AgentTerrain','affectation.AgentBackoffice','commentaires' => function ($query)  {
        $query->latest();
         }])
     ->where([
        ['telephone', 'LIKE', '%'.$telclean.'%'],
        ['isvisible', '=', '1'],
    ])
     ->orWhere([
        ['telephone2','LIKE', '%'.$telclean.'%'],
         ['isvisible', '=', '1'],
    ])
     ->orWhere([
        ['telephone','LIKE', '%'.$tel.'%'],
         ['isvisible', '=', '1'],
    ])
     ->orWhere([
        ['telephone2','LIKE', '%'.$tel.'%'],
         ['isvisible', '=', '1'],   
    ])
     ->get()->toArray();

    return view('retrouve_opp', compact('listeprospection', 'tel'));

   }


    public function findoppbyimmatricul (Request $request){

    
    $plaquefilter = $request->plaquefilter;
    $listeprospection = ProspectionClient::with(['AgentTerrain','affectation.AgentBackoffice','commentaires' => function ($query)  {
            $query->latest();
         }])
     ->where([
        ['plaque_immatriculation', 'LIKE', '%'.$plaquefilter.'%'],
    ])
     ->get()->toArray();
    return view('retrouve_opp', compact('listeprospection', 'plaquefilter','plaquefilter'));

   }
   
   

   

   public function listeprosprectionbyteldoublon (Request $request){

    $tel=  $request->telfiltre;

    $telclean=  str_replace(' ', '', $request->telfiltre);

    //dd($tel);

    $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();

    $filter_Array = [];

    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
       
    }
    
     $filter_Array = array_filter($filter_Array);
     $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->whereIn('telephone', $filter_Array)
    ->where([
        ['isvisible', '=', 1],
        ['telephone', '=', $telclean],
    ])
    ->get()->toArray();


    


     return view('liste_prospection_doublon', compact('listeprospection'));

   }


   public function listeprosprectionbynamedoublon (Request $request){

    $namefilter=  $request->namefilter;


    //dd($tel);

    $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();

    $filter_Array = [];

    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
       
    }
    
     $filter_Array = array_filter($filter_Array);
     $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->whereIn('telephone', $filter_Array)
    ->where([
        ['isvisible', '=', 1],
        ['nom', 'LIKE', '%'.$namefilter.'%'],
    ])
    ->orWhere([
        ['isvisible', '=', 1],
        ['prenoms', 'LIKE', '%'.$namefilter.'%'],
    ])

    ->get()->toArray();


    


     return view('liste_prospection_doublon', compact('listeprospection'));

   }




   public function listeprosprectionbytel_agent (Request $request){

     $tel=  $request->telfiltre;

    $telclear=  str_replace(' ', '', $request->telfiltre);
    $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->whereNotIn('id', function($query) {
               $query->from('note_opportunites')
               ->where( [
                  ['resultat', '==', 'perdu'],
                  ['resultat', '==', 'horscible'],  
           ])->select('idopportunite');
            })
     ->where([
        ['telephone', 'LIKE', '%'.$telclear.'%'],
        // ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    ])->orWhere('telephone2','LIKE', '%'.$telclear.'%')
     ->orWhere('telephone','LIKE', '%'.$tel.'%')
     ->orWhere('telephone2','LIKE', '%'.$tel.'%')
     ->get()->toArray();
    //   dd($listeprospection);

    return view('liste_prospection_byagent_tel', compact('listeprospection', 'tel'));

   }

   public function liste_prospection_byagent_relance_searchtel(request $request){


    $tel=  $request->telfiltre;

    $telclear=  str_replace(' ', '', $request->telfiltre);

     $listeprospection = ProspectionClient::with('commentaires')->whereIn('id', function($query) {
               $query->from('note_opportunites')->where('idagentbackoffice', '=', Session::get('agentbackofficeid'))->select('idopportunite');
            })
     ->where([
        ['telephone', 'LIKE', '%'.$telclear.'%'],
    ])->orWhere('telephone2','LIKE', '%'.$telclear.'%')
     ->orWhere('telephone','LIKE', '%'.$tel.'%')
     ->orWhere('telephone2','LIKE', '%'.$tel.'%')
     ->get()->toArray();

    // $listeprospection = ProspectionClient::with('commentaires')->whereIn('id', function($query) {
    //            $query->from('note_opportunites')->where('idagentbackoffice', '=', Session::get('agentbackofficeid'))->select('idopportunite');
    //         })
    //  ->where([
    //     ['telephone', 'LIKE', '%'.$telclear.'%'],
    // ])->orWhere('telephone2','LIKE', '%'.$telclear.'%')
    //  ->orWhere('telephone','LIKE', '%'.$tel.'%')
    //  ->orWhere('telephone2','LIKE', '%'.$tel.'%')
    //  ->get()->toArray();

      // dd($listeprospection);



// $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('idopportunite', function($query) {
//                $query->from('note_opportunites')->where('idagentbackoffice', '=', Session::get('agentbackofficeid'))->select('idopportunite');
//             })->get()->toArray();




//     $listeprospection = NoteOpportunites::with('Opportunite')->whereIn('id', function($query) {
//        $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
//     })->where([
//             ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
//             ['daterelance', '<=', $currentdate],
//             ['resultat', '!=', 'perdu']   
//             ])->orderBy('heure_relance', 'ASC')
//             ->get()->toArray();

     return view('liste_prospection_byagent_relance_searchtel', compact('listeprospection', 'tel'));


   }




    public function liste_prospection_byagent_relance_searchname(request $request){


    $namefilter=  $request->namefilter;


    $listeprospection = ProspectionClient::with('commentaires',)->whereIn('id', function($query) {
               $query->from('note_opportunites')->where('idagentbackoffice', '=', Session::get('agentbackofficeid'))->select('idopportunite');
            })
     ->where([
        ['nom', 'LIKE', '%'.$namefilter.'%'],
        // ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    ])->orWhere('prenoms','LIKE', '%'.$namefilter.'%')
     ->get()->toArray();

     // dd($listeprospection);

     return view('liste_prospection_byagent_relance_searchtel', compact('listeprospection', 'namefilter'));


   }


   public function listeprosprectionbydate (Request $request){

     //$dateecheance=  $request->datefiltre;


    // filtre doublon
    $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();

    $filter_Array = [];

    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
       
    }
    
     $filter_Array = array_filter($filter_Array);

    //fin filtre doublon

     $selectfiltre=  $request->selectfiltre;
     $datefiltredeb=  $request->datefiltredeb;
     $datefiltrefin=  $request->datefiltrefin;

     $finalfiltre ='';

     //dd($datefiltredeb);


    if ($selectfiltre =='date_ech') {
             // code...
         $finalfiltre =  'echeance';
        
        }

    if ( $selectfiltre =='date_rel' ) {
             // code...
         $finalfiltre =  'daterelance';
        
        }
   

   // whereNotIn('telephone', $filter_Array)
    $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->doesntHave('commentaires')
     ->whereDate($finalfiltre, '>=', $datefiltredeb)
     ->whereDate($finalfiltre, '<=', $datefiltrefin)
     ->where('isvisible', '=', 1)
     ->whereNotIn('telephone', $filter_Array)
     ->get()->toArray();

    return view('liste_prospection', compact('listeprospection'));

   }

   public function listeprosprection_doublonbydate (Request $request){

     //$dateecheance=  $request->datefiltre;

     $selectfiltre=  $request->selectfiltre;
     $datefiltredeb=  $request->datefiltredeb;
     $datefiltrefin=  $request->datefiltrefin;

     $finalfiltre ='';

     //dd($datefiltredeb);


    if ($selectfiltre =='date_ech') {
             // code...
         $finalfiltre =  'echeance';
        
        }

    if ( $selectfiltre =='date_rel' ) {
             // code...
         $finalfiltre =  'daterelance';
        
        }
   
    $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();

    $filter_Array = [];

    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
       
    }
    
     $filter_Array = array_filter($filter_Array);
     $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->whereIn('telephone', $filter_Array)
    ->where([
        ['isvisible', '=', 1],
    ])
     ->whereDate($finalfiltre, '>=', $datefiltredeb)
     ->whereDate($finalfiltre, '<=', $datefiltrefin)
    ->get()->toArray();



    return view('liste_prospection_doublon', compact('listeprospection'));

   }

   


   
// listeprosprectionbydate

   public function liste_prospection_byagent (Request $request){

     $currentdate = date('Y-m-d');
     //a reecrire de sorte a prendre uniquement sans commentaire

     $listeprospection = AffectationOpportunites::with('Opportunites','commentaire')
     ->where(function($query) {
             return $query
                    ->where([
                         ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                         ['status', '=', 1],
                        ])
                    ->WhereNull('date_affect');
            })
     ->orwhere(
           function($query)use ($currentdate) {
             return $query
                    ->where([
                         ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                         ['status', '=', 1],
                        ])
                     ->whereDate('date_affect', '<=', $currentdate);
            }) ->get()->toArray();

     // dd($listeprospection);

     //les reaffectations du jours : commentaire reaff et createdat aujourdhui


    //   $listeraffectation = NoteOpportunites::with('Opportunite')->whereIn('id', function($query) {
    //    $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    // })->where([
    //         ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    //         ['observation', 'like', '%reaff%'],
    //         ['resultat', '!=', 'perdu'],
    //         ['resultat', '!=', 'horscible'],
    //         ['resultat', '!=', 'gagne'], 
    //         ]) ->whereDate('created_at', '=', $currentdate)
    // ->orderBy('heure_relance', 'ASC')
    //         ->get()->toArray();

            // dd($listeraffectation);
     //fin de reaffectations du jour 


      $listeprospectioncreated = ProspectionClient::with('AgentTerrain','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
        ['isvisible','=',1]
    ])
      ->get()->toArray();


    // dd($listeprospectioncreated);
     

    return view('liste_prospection_byagent', compact('listeprospection','listeprospectioncreated'));

   }

   public function filter_liste_prospection_byagent (Request $request){


     $selectfiltre=  $request->selectfiltre;
     $datefiltredeb=  $request->datefiltredeb;
     $datefiltrefin=  $request->datefiltrefin;
     
     $finalfiltre= 'echeance';

     if ($request->selectfiltre == 'date_ech') {
         $finalfiltre =  'echeance';
        }

     if ($request->selectfiltre == 'date_rel') {
         $finalfiltre =  'daterelance';
        }









    //  $listeprospection = AffectationOpportunites::with('Opportunites','commentaire')
    //  ->where([
    //          ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    //          ['status', '=', 1]
    //         ])
    //  ->whereDate($finalfiltre, '>=', $datefiltredeb)
    // ->whereDate($finalfiltre, '<=', $datefiltrefin)
    //  ->get()->toArray();


      $listeprospection = AffectationOpportunites::with('Opportunites','commentaire')->whereIn('idopportunite', function($query) use ($datefiltredeb, $datefiltrefin,$finalfiltre) {
               $query->from('prospection_clients')->where([
               // ['idagentbackoffice', '=', $selectedagent],
            ]) ->whereDate($finalfiltre, '>=', $datefiltredeb)
               ->whereDate($finalfiltre, '<=', $datefiltrefin)
               ->select('id');
            })->where([
             ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
             ['status', '=', 1]
            ])->get()->toArray();


     ///dd($listeprospection);

      $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
                 ['id', '=', Session::get('agentbackofficeid')],
                 ['isvisible', '=', 1]
            ])
      ->whereDate($finalfiltre, '>=', $datefiltredeb)
      ->whereDate($finalfiltre, '<=', $datefiltrefin)
      ->get()->toArray();




     return view('liste_prospection_byagent', compact('listeprospection','listeprospectioncreated'));
   }



   public function liste_prospection_byagent_relance (Request $request){

   

    $currentdate = date('Y-m-d').' 00:00:00';
    // $listeprospection = NoteOpportunites::with('Opportunite')
    //  ->where([
    //     ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    //     ['daterelance', '<=', $currentdate]   
    //     ])
    //     ->orderBy('id', 'desc')->get()
    //     ->groupBy('idopportunite')
    //     ->toArray();



    // $listeprospection = NoteOpportunites::with('Opportunite')->select(DB::raw('t.*'))
    //         ->from(DB::raw('(SELECT * FROM note_opportunites ORDER BY id DESC) t'))
    //         ->where([
    //         ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    //         ['daterelance', '<=', $currentdate]   
    //         ])
    //         ->groupBy('t.idopportunite')
    //         ->get();



    $listeprospection = NoteOpportunites::with('Opportunite')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['daterelance', '<=', $currentdate],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'], 
            ])->orderBy('heure_relance', 'ASC')->limit(500)
            ->get()->toArray();


     // dd($listeprospection);




    return view('liste_prospection_byagent_relance', compact('listeprospection'));

   }


   public function liste_prospection_byagent_relance_admin (Request $request){


    $currentdate = date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();

    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();



    // $listeprospection = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
    //  ->where([
    //          //['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    //          ['status', '=', 1]
    //         ])
    //  ->get()->toArray();


    //  dd($listeprospection);




    $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['daterelance', '<=', $currentdate],
             ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();



     // dd($listeprospection);

    return view('liste_prospection_byagent_relance_admin', compact('listeprospection','listecommerciaux'));

   }


   public function opportunite_admin (Request $request){

    //pour forcer la redirection si agent debutant
    // $userpriv =   Session::get('userprivilege');
    // if ($userpriv != 'niveau1') {
    //       // code...
    //      return redirect('/opportunite_agent');
    // }

    $currentdate = date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    //opportunite relance
    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })
    ->whereRaw("COALESCE(date_affect, daterelance) <= ?", [$currentdate])
    ->where([
            // ['daterelance', '<=', $currentdate],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'horscible_rn'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();



    $liste_relances_array = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['daterelance', '<=', $currentdate],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'horscible_rn'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])
    ->orderBy('heure_relance', 'ASC')->limit(2000)
    ->select('id')
    ->get()->toArray();




    //opportunite relance
    //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ])->whereDate('date_affect', '=', $currentdate)
            ->whereNotIn('id', $liste_relances_array)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites

    $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
             //['idagentbackoffice', '=', Session::get('agentbackofficeid')],
             ['status', '=', 1]
            ])

     ->latest()->take(500)
     ->get()->toArray();

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '!=', null],
        ['isvisible', '=', 1]
        ])->limit(500)
      ->get()->toArray();

    //nouvelle opportunites



    return view('liste_opportunite_admin', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux'));

   }

                   
   public function filter_opp_agent_echeance_admin (request $request){


    $currentdate = date('Y-m-d').' 00:00:00';
    $dateecheance=date('Y-m-d').' 00:00:00';
    $datefin=$request->datefin;
    $datedebut=$request->datedebut;
    $selectedagent = $request->selectagent;
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

    $filtre = 'ECHEANCE';


    if ($selectedagent =='tous') {
        // code...
        //opportunite relance
    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->whereDate('echeance','>=', $datedebut)
    ->whereDate('echeance','<=', $datefin)
    ->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();

    //opportunite relance
    //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],   
            ])->whereDate('date_affect', '=', $currentdate)
            ->whereDate('echeance','>=', $datedebut)
            ->whereDate('echeance','<=', $datefin)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites

    // $listeprospection = ProspectionClient::with(['AgentTerrain','affectation.AgentBackoffice','commentaires' => function ($query) use ($datedebut,)  {
    //         $query->latest();
    //      }])
    //  ->where([
    //     ['nom', 'LIKE', '%'.$namefilter.'%'],
    //     ['isvisible', '=', '1'],
    // ])
    //  ->orWhere([
    //     ['prenoms','LIKE', '%'.$namefilter.'%'],
    //     ['isvisible', '=', '1'],
    // ])
    //  ->OrWhere([
    //     [DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%"],
    //     ['isvisible', '=', '1'],
    // ])
    //  ->get()->toArray();


      $nouvelle_opp = AffectationOpportunites::with(['commentaire','AgentBackoffice','Opportunites' => function ($query) use ($datedebut,$datefin) {
             $query->from('prospection_clients')->whereDate('echeance', '>=', $datedebut)
               ->whereDate('echeance', '<=', $datefin);
         }])


    // $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
             
             ['status', '=', 1]
            ])

     ->latest()->take(500)
     ->get()->toArray();


     $doublontel = ProspectionClient::select('telephone')
    ->groupBy('telephone',)
    ->havingRaw('COUNT(*) > 1')
    ->get()->toArray();
    $filter_Array = [];
    foreach ($doublontel as $elem ) {
        // code...
        $filter_Array []= $elem['telephone'];
    }
     $filter_Array = array_filter($filter_Array);

    //  $nombre_opp_remont = ProspectionClient::with('AgentTerrain','affectation')->doesntHave('commentaires')->whereNotIn('telephone', $filter_Array)
    // ->where([
    //     ['idagentbackoffice', '=', null],
    //     ['isvisible', '=', 1],
    // ])->whereDate('created_at','=',$Yesterday)
    // ->count();

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
     ->whereNotIn('telephone', $filter_Array)
      ->where([
        
        ['isvisible', '=', 1]
        ])
      ->whereDate('echeance','>=', $datedebut)
      ->whereDate('echeance','<=', $datefin)
      ->limit(500)
      ->get()->toArray();

    //nouvelle opportunites
      return view('liste_opportunite_admin', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','selectedagent','filtre','datedebut','datefin'));
    }else {
          //opportunite relance

    $foundagent = AgentBackoffices::where('id',$selectedagent)->get()->toArray();

    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', $selectedagent],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->whereDate('echeance','>=', $datedebut)
    ->whereDate('echeance','<=', $datefin)
    ->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();

    // dd($liste_relances);
    //opportunite relance
    //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', $selectedagent],
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->whereDate('date_affect', '=', $currentdate)
            ->whereDate('echeance','>=', $datedebut)
            ->whereDate('echeance','<=', $datefin)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites

    // $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
    //  ->where([
    //          ['idagentbackoffice', '=', $selectedagent],
    //          ['status', '=', 1]
    //         ])

      $nouvelle_opp = AffectationOpportunites::with(['commentaire','AgentBackoffice','Opportunites' => function ($query) use ($datedebut,$datefin,$selectedagent) {
             $query->from('prospection_clients')
               ->whereDate('echeance', '>=', $datedebut)
               ->whereDate('echeance', '<=', $datefin)
               ->where('idagentbackoffice', '=', $selectedagent);
         }])
     ->where([
             ['status', '=', 1]
            ])

     ->latest()->take(500)
     ->get()->toArray();

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '=', $selectedagent],
        ['isvisible', '=', 1]
        ])
      ->whereDate('echeance','>=', $datedebut)
      ->whereDate('echeance','<=', $datefin)
      ->limit(500)
      ->get()->toArray();

    //nouvelle opportunites
      return view('liste_opportunite_admin', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','foundagent','datedebut','datefin','filtre'));
    }
    

   }


   public function filter_opp_echeance_admin (request $request){


    $currentdate = date('Y-m-d').' 00:00:00';
    $dateecheance=date('Y-m-d').' 00:00:00';
    $datefin=$request->datefin;
    $datedebut=$request->datedebut;
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();



    //opportunite relance
    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['resultat', '!=', 'perdu_rn'],
             ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->whereDate('echeance','>=', $datedebut)
    ->whereDate('echeance','<=', $datefin)
    ->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();

    //opportunite relance
    //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ])->whereDate('date_affect', '=', $currentdate)
            ->whereDate('echeance','>=', $datedebut)
            ->whereDate('echeance','<=', $datefin)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites
// 42685
     $nouvelle_opp_filter = AffectationOpportunites::whereIn('idopportunite' , function($query) use ($datedebut,$datefin) {
             $query->from('prospection_clients')->where([
            ['isvisible', '=', 1]
        ])->whereDate('echeance','>=', $datedebut)
         ->whereDate('echeance','<=', $datefin)->select('id');
    })->select('id',)
     ->get()->toArray();


      // dd($nouvelle_opp_filter);

     $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->whereIn('id',$nouvelle_opp_filter)
     ->get()->toArray();


     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '!=', null],
        ['isvisible', '=', 1]
        ])->whereDate('echeance','>=', $datedebut)
        ->whereDate('echeance','<=', $datefin)
      ->limit(500)
      ->get()->toArray();




    //nouvelle opportunites



    return view('liste_opportunite_admin', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux'));

   }


    public function filter_opp_echeance_agent (request $request){


    $currentdate = date('Y-m-d').' 00:00:00';
    $dateecheance=date('Y-m-d').' 00:00:00';
    $datefin=$request->datefin;
    $datedebut=$request->datedebut;
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();



    //opportunite relance
    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible_rn'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->whereDate('echeance','>=', $datedebut)
    ->whereDate('echeance','<=', $datefin)
    ->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();

    //opportunite relance
    //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ])->whereDate('date_affect', '=', $currentdate)
            ->whereDate('echeance','>=', $datedebut)
            ->whereDate('echeance','<=', $datefin)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites
// 42685
     $nouvelle_opp_filter = AffectationOpportunites::whereIn('idopportunite' , function($query) use ($datedebut,$datefin) {
             $query->from('prospection_clients')->where([
            ['isvisible', '=', 1]
        ])->whereDate('echeance','>=', $datedebut)
         ->whereDate('echeance','<=', $datefin)
        //  ->where([
        // ['idagentbackoffice', '=', Session::get('agentbackofficeid')]])
         ->select('id');
    })  ->where([
         ['idagentbackoffice', '=', Session::get('agentbackofficeid')]])
         ->select('id')
     ->select('id',)
     ->get()->toArray();


      // dd($nouvelle_opp_filter);

     $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->whereIn('id',$nouvelle_opp_filter)
     ->get()->toArray();


     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
        ['isvisible', '=', 1]
        ])->whereDate('echeance','>=', $datedebut)
        ->whereDate('echeance','<=', $datefin)
      ->limit(500)
      ->get()->toArray();




    //nouvelle opportunites

      $typefiltre='ECHEANCE';

    return view('liste_opportunite', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','datedebut','datefin','typefiltre'));

   }


   public function opportunite_agent (Request $request){


    $currentdate = date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    //opportunite relance
    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->whereRaw("COALESCE(date_affect, daterelance) <= ?", [$currentdate])
    ->where([
            // ['daterelance', '<=', $currentdate],
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
             ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible_rn'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();



    $liste_relances_array = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['resultat', '!=', 'perdu'],
                ['resultat', '!=', 'perdu_rn'],
                ['resultat', '!=', 'horscible'],
                ['resultat', '!=', 'horscible_rn'], 
                ['resultat', '!=', 'gagne'],  
                ['isvisible', '=', 1],
                ])->whereDate('daterelance', '>=', $currentdate)
        ->orderBy('heure_relance', 'ASC')->limit(2000)
        ->select('id')
        ->get()->toArray();

    //opportunite relance
    //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['resultat', '!=', 'gagne'], 
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
             ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible_rn'],
              ['isvisible', '=', 1],
            ])->whereDate('date_affect', '=', $currentdate)
            ->whereNotIn('id', $liste_relances_array)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites

    $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
             ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
             ['status', '=', 1]
            ])

     ->latest()->take(500)
     ->get()->toArray();

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
        ['isvisible', '=', 1]
        ])->limit(500)
      ->get()->toArray();

    //nouvelle opportunites



    return view('liste_opportunite', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux'));

   }




   // public function filter_opp_echeance_admin (Request $request){


   //  $datedebut = $request->datedebut;
   //  $datefin = $request->datefin; // date('Y-m-d').' 00:00:00';
   //  $listecommerciaux = AgentBackoffices::all()->toArray();


   //  //opportunite relance
   //  $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
   //     $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
   //  })->where([
   //          ['resultat', '!=', 'perdu'],
   //          ['resultat', '!=', 'horscible'],
   //          ['resultat', '!=', 'gagne'],  
   //          ['isvisible', '=', 1],
   //          ])->whereDate('echeance', '<=', $datedebut)
   //           ->whereDate('echeance', '<=', $datefin)
   //  ->orderBy('heure_relance', 'ASC')->limit(2000)
   //  ->get()->toArray();

   //  //opportunite relance
   //  //reaffectations

   //    $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
   //     $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
   //  })->where([
   //          ['observation', 'like', '%reaff%'],
   //          ['resultat', '!=', 'gagne'], 
   //          ])->whereDate('date_affect', '=', $currentdate)
   //          ->whereDate('echeance', '<=', $datedebut)
   //           ->whereDate('echeance', '<=', $datefin)
   //          // ->orWhereDate('date_affect', '=', $currentdate)
   //          ->orderBy('date_affect', 'DESC')
   //          ->get()->toArray();

   //   //reaffectations zeze
 
   //  //nouvelle opportunites

   //  $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
   //   ->where([
            
   //           ['status', '=', 1]
   //          ])

   //   ->latest()->take(500)
   //   ->get()->toArray();

   //   $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
   //    ->where([
   //      ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
   //      ['isvisible', '=', 1]
   //      ])->whereDate('echeance', '<=', $datedebut)
   //      ->whereDate('echeance', '<=', $datefin)
   //    ->limit(500)
   //    ->get()->toArray();

   //  //nouvelle opportunites



   //  return view('liste_opportunite', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux'));

   // }




   public function filter_opp_agent_relance_admin (Request $request){

     $currentdate = date('Y-m-d').' 00:00:00';
    $datedebut = $request->datedebut;
    $datefin = $request->datefin; // date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::where()->orderBy('lastname')->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

    
    $selectedagent = $request->selectagent;
    $filtre ='RELANCE';



    if ($selectedagent == 'tous') {
        // code...
            //opportunite relance
        $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['resultat', '!=', 'perdu_rn'],
                ['resultat', '!=', 'perdu'],
                ['resultat', '!=', 'horscible'],
                ['resultat', '!=', 'gagne'],  
                ['isvisible', '=', 1],
                ])->whereDate('daterelance', '>=', $datedebut)
                 ->whereDate('daterelance', '<=', $datefin)
        ->orderBy('heure_relance', 'ASC')->limit(2000)
        ->get()->toArray();

        //opportunite relance
        //reaffectations

          $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
               
                ['observation', 'like', '%reaff%'],
                ['resultat', '!=', 'gagne'], 
                ])//->whereDate('date_affect', '=', $currentdate)
                ->whereDate('date_affect', '>=', $datedebut)
                ->whereDate('date_affect', '<=', $datefin)
                // ->orWhereDate('date_affect', '=', $currentdate)
                ->orderBy('date_affect', 'DESC')
                ->get()->toArray();

         //reaffectations zeze
     
        //nouvelle opportunites

        $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
         ->where([
                
                 ['status', '=', 1]
                ])

         ->latest()->take(500)
         ->get()->toArray();

         $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
          ->where([
           
            ['isvisible', '=', 1]
            ])
          ->limit(500)
          ->get()->toArray();

        //nouvelle opportunites



        return view('liste_opportunite_admin', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','datedebut','datefin','selectedagent','filtre',));
        }
    else 
        {

        $foundagent = AgentBackoffices::where('id',$selectedagent)->get()->toArray();
            //opportunite relance
        $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['idagentbackoffice', '=', $selectedagent],
                ['resultat', '!=', 'perdu'],
                ['resultat', '!=', 'perdu_rn'],
                ['resultat', '!=', 'horscible'],
                ['resultat', '!=', 'gagne'],  
                ['isvisible', '=', 1],
                ])->whereDate('daterelance', '>=', $datedebut)
                 ->whereDate('daterelance', '<=', $datefin)
        ->orderBy('heure_relance', 'ASC')->limit(2000)
        ->get()->toArray();



        $liste_relances_array = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                
                ['resultat', '!=', 'perdu'],
                ['resultat', '!=', 'perdu_rn'],
                ['resultat', '!=', 'horscible'],
                ['resultat', '!=', 'horscible_rn'], 
                ['resultat', '!=', 'gagne'],  
                ['isvisible', '=', 1],
                ])->whereDate('daterelance', '>=', $datedebut)
                 ->whereDate('daterelance', '<=', $datefin)
        ->orderBy('heure_relance', 'ASC')->limit(2000)
        ->select('id')
        ->get()->toArray();

        //opportunite relance
        //reaffectations

          $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['idagentbackoffice', '=', $selectedagent],
                ['observation', 'like', '%reaff%'],
                ['resultat', '!=', 'gagne'], 
                 ])->whereNotIn('id', $liste_relances_array)
                 //->whereDate('date_affect', '=', $currentdate)
                // ->whereDate('daterelance', '>=', $datedebut)
                // ->whereDate('daterelance', '<=', $datefin)
                ->WhereDate('date_affect', '>=', $datedebut)
                ->WhereDate('date_affect', '<=', $datefin)
                ->orderBy('date_affect', 'DESC')
                ->get()->toArray();

         //reaffectations zeze
     
        //nouvelle opportunites

        $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
         ->where([
                 ['idagentbackoffice', '=', $selectedagent],
                 ['status', '=', 1]

                ])
         ->latest()->take(500)
         ->get()->toArray();

         $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
          ->where([
            ['idagentbackoffice', '=', $selectedagent],
            ['isvisible', '=', 1]
            ])
          ->limit(500)
          ->get()->toArray();

        //nouvelle opportunites



        return view('liste_opportunite_admin', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','foundagent','datedebut','datefin','filtre'));

        }
    
   }


    public function filter_opp_relance_admin (Request $request){



    $currentdate = date('Y-m-d').' 00:00:00';
    $datedebut = $request->datedebut;
    $datefin = $request->datefin; // date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();

    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    //opportunite relance
    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['resultat', '!=', 'perdu'],
             ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->whereDate('daterelance', '>=', $datedebut)
             ->whereDate('daterelance', '<=', $datefin)
    ->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();

    //opportunite relance
    //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'perdu'],
             ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'gagne'], 
             ['isvisible', '=', 1],
            ])
            // ->whereDate('date_affect', '=', $currentdate)
            ->whereDate('date_affect', '>=', $datedebut)
            ->whereDate('date_affect', '<=', $datefin)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites

    $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
            
             ['status', '=', 1]
            ])

     ->latest()->take(500)
     ->get()->toArray();

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
        ['isvisible', '=', 1]
        ])
      ->limit(500)
      ->get()->toArray();

    //nouvelle opportunites



    return view('liste_opportunite', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux'));

   }



    public function filter_opp_relance_agent (Request $request){



    $currentdate = date('Y-m-d').' 00:00:00';
    $datedebut = $request->datedebut;
    $datefin = $request->datefin; // date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    //opportunite relance
    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'perdu_rn'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'horscible_rn'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ])->whereDate('daterelance', '>=', $datedebut)
             ->whereDate('daterelance', '<=', $datefin)
    ->orderBy('heure_relance', 'ASC')->limit(2000)
    ->get()->toArray();



        $liste_relances_array = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                
                ['resultat', '!=', 'perdu'],
                ['resultat', '!=', 'perdu_rn'],
                ['resultat', '!=', 'horscible'],
                ['resultat', '!=', 'horscible_rn'], 
                ['resultat', '!=', 'gagne'],  
                ['isvisible', '=', 1],
                ])->whereDate('daterelance', '>=', $datedebut)
                 ->whereDate('daterelance', '<=', $datefin)
        ->orderBy('heure_relance', 'ASC')->limit(2000)
        ->select('id')
        ->get()->toArray();

    //opportunite relance
    //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ['isvisible', '=', 1],
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ])->whereNotIn('id', $liste_relances_array)
            // ->whereDate('date_affect', '=', $currentdate)
            ->whereDate('date_affect', '>=', $datedebut)
            ->whereDate('date_affect', '<=', $datefin)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites

    $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
            
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
             ['status', '=', 1]
            ])

     ->latest()->take(500)
     ->get()->toArray();

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
        ['isvisible', '=', 1]
        ])
      ->limit(500)
      ->get()->toArray();

    //nouvelle opportunites


      $typefiltre='RELANCE';

    return view('liste_opportunite', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','datedebut','datefin','typefiltre'));

   }


   


   public function filter_opp_tel_admin (Request $request){


  
    $tel=  $request->telfiltre; 

    $telfiltre=  $request->telfiltre; 

  
    $telclean=  str_replace(' ', '', $request->telfiltre);

    $currentdate = date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    //opportunite relance
    $liste_relances_filter = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['daterelance', '<=', $currentdate],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->select('id')->whereIn('idopportunite', function($query) use ($telclean) {
                     $query->from('prospection_clients')
                     ->where([
                            ['isvisible', '=', 1],
                            ['telephone', 'LIKE', '%'.$telclean.'%']
                    ])->orWhere('telephone','LIKE', '%'.$telclean.'%')
                     ->orWhere('telephone2','LIKE', '%'.$telclean.'%')
                     ->orWhere('telephone2','LIKE', '%'.$telclean.'%')
                     ->select('id',);
                   })
    ->get()->toArray();

    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id',$liste_relances_filter) ->get()->toArray();
    

    // dd($liste_relances);


    //opportunite relance
    //reaffectations

      $liste_reaffectations_filter = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ])->whereDate('date_affect', '=', $currentdate)
            // ->orderBy('date_affect', 'DESC')
            ->select('id')->whereIn('idopportunite', function($query) use ($telclean) {
                     $query->from('prospection_clients')
                     ->where([
                            ['isvisible', '=', 1],
                            ['telephone', 'LIKE', '%'.$telclean.'%']
                    ])->orWhere('telephone2','LIKE', '%'.$telclean.'%')
                     
                     ->select('id',);
                   })
            ->get()->toArray();



    $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id',$liste_reaffectations_filter)->get()->toArray();




     //reaffectations zeze
 
    //nouvelle opportunites

    $nouvelle_opp_filter = AffectationOpportunites::whereIn('id' , function($query) use ($telclean) {
             $query->from('prospection_clients')->where([
            ['telephone',  'LIKE', '%'.$telclean.'%'],
            ['isvisible', '=', 1]
        ])->orWhere([
            ['telephone2',  'LIKE', '%'.$telclean.'%'],
             ['isvisible', '=', 1]
        ])->select('id');
    })->select('id',)
     ->get()->toArray();


     $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->whereIn('id',$nouvelle_opp_filter)
     ->get()->toArray();




    //  $nouvelle_opp = AffectationOpportunites::with(['Opportunites' => function ($query) use ($telclean) {
    //     $query->where([
    //         ['telephone',  'LIKE', '%'.$telclean.'%'],
    //         // ['isvisible', '=', 1],
    //     ])->orWhere([
    //         ['telephone2',  'LIKE', '%'.$telclean.'%'],
    //         // ['isvisible', '=', 1]
    //     ]);
    // },'commentaire','AgentBackoffice'])->where([
    //          //['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    //          ['status', '=', 1]
    //         ])->get()->toArray();




     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '!=', null],
        ['isvisible', '=', 1],
        ['telephone', 'LIKE', '%'.$telclean.'%']
        ])->orWhere('telephone2','LIKE', '%'.$telclean.'%')
      ->limit(500)
      ->get()->toArray();


      // dd($listeprospectioncreated);

    //nouvelle opportunites


    return view('liste_opportunite_admin', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','telfiltre'));

   }



public function filter_opp_tel_agent (Request $request){


    // dd($request->telfiltre);
  
    $tel=  $request->telfiltre; 
    $telfiltre=  $request->telfiltre; 

  
    $telclean=  str_replace(' ', '', $request->telfiltre);
    $currentdate = date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    //opportunite relance
    $liste_relances_filter = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->select('id')->whereIn('idopportunite', function($query) use ($telclean,$tel) {
                     $query->from('prospection_clients')
                     ->where([
                            ['isvisible', '=', 1],
                            ['telephone', 'LIKE', '%'.$telclean.'%']
                    ])->orWhere([
                        ['telephone2','LIKE', '%'.$telclean.'%'],
                        ['isvisible', '=', 1],
                    ])
                     ->orWhere([
                        ['telephone','LIKE', '%'.$tel.'%'],
                        ['isvisible', '=', 1],
                    ])
                     ->orWhere([
                        ['telephone2','LIKE', '%'.$tel.'%'],
                        ['isvisible', '=', 1]
                    ])
                     ->select('id',);
                   })
    ->get()->toArray();

     


    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id',$liste_relances_filter) ->get()->toArray();

     // dd($liste_relances);
    

  // ->whereNotIn('id', $liste_relances_array)
    //opportunite relance
    //reaffectations

      $liste_reaffectations_filter = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ])->whereDate('date_affect', '=', $currentdate)
             ->whereNotIn('id', $liste_relances_filter)
            // ->orderBy('date_affect', 'DESC')
            ->select('id')->whereIn('idopportunite', function($query) use ($telclean,$tel) {
                     $query->from('prospection_clients')
                     ->where([
                            ['isvisible', '=', 1],
                            ['telephone', 'LIKE', '%'.$telclean.'%']
                    ])->orWhere([
                        ['telephone2','LIKE', '%'.$telclean.'%'],
                        ['isvisible', '=', 1],
                    ])
                     ->orWhere([
                       [ 'telephone','LIKE', '%'.$tel.'%'],
                       ['isvisible', '=', 1],
                    ])
                     ->orWhere([
                        ['telephone2','LIKE', '%'.$tel.'%'],
                        ['isvisible', '=', 1],
                    ])
                     ->select('id');
                   })
            ->get()->toArray();

    // dd($liste_reaffectations_filter);

    $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id',$liste_reaffectations_filter)->get()->toArray();




     //reaffectations zeze
 
    //nouvelle opportunites

    $nouvelle_opp_filter = AffectationOpportunites::whereIn('idopportunite' , function($query) use ($telclean,$tel) {
             $query->from('prospection_clients')->where([
            ['telephone',  'LIKE', '%'.$telclean.'%'],
            ['isvisible', '=', 1]
        ])->orWhere([
            ['telephone2',  'LIKE', '%'.$telclean.'%'],
            ['isvisible', '=', 1]
        ])->orWhere([
            ['telephone','LIKE', '%'.$tel.'%'],
            ['isvisible', '=', 1]
        ])
        ->orWhere([
           [ 'telephone2','LIKE', '%'.$tel.'%'],
           ['isvisible', '=', 1]
        ])
        ->select('id');
    })->select('id',)
     ->get()->toArray();

     // dd($nouvelle_opp_filter);0546348923


     $nouvelle_opp = AffectationOpportunites::with('Opportunites','AgentBackoffice')->doesntHave('commentaire')
     ->whereIn('id',$nouvelle_opp_filter)
     ->whereNotIn('idopportunite', $liste_relances_filter)
     ->get()->toArray();

     // dd($nouvelle_opp);



     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
        ['isvisible', '=', 1],
        ['telephone', 'LIKE', '%'.$telclean.'%']
        ])->orWhere(
           [ 
            ['telephone2','LIKE', '%'.$telclean.'%'],
            ['isvisible', '=', 1]
        ])
        ->orWhere([
            ['telephone','LIKE', '%'.$tel.'%'],
             ['isvisible', '=', 1]
        ])
         ->orWhere([
            ['telephone2','LIKE', '%'.$tel.'%'],
            ['isvisible', '=', 1]
        ])
         ->whereNotIn('id', $liste_relances_filter)
      ->get()->toArray();


      // dd($listeprospectioncreated);

    //nouvelle opportunites


    return view('liste_opportunite', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','telfiltre'));

   }
   



   public function filter_opp_name_admin(Request $request){

        $namefilter=  $request->namefilter;
    $currentdate = date('Y-m-d').' 00:00:00';


    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

    //opportunite relance
    $liste_relances_filter = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['daterelance', '<=', $currentdate],
             ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->select('id')->whereIn('idopportunite', function($query) use ($namefilter) {
                         $query->from('prospection_clients')
                         ->where([
                            ['nom', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])->OrWhere([
                            ['prenoms', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])
                        ->OrWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")
                         ->select('id',);
                       })
    ->get()->toArray();

    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id',$liste_relances_filter) ->get()->toArray();
    




    //opportunite relance
    //reaffectations

      $liste_reaffectations_filter = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ])->whereDate('date_affect', '=', $currentdate)
            // ->orderBy('date_affect', 'DESC')
           ->select('id')->whereIn('idopportunite', function($query) use ($namefilter) {
                         $query->from('prospection_clients')
                         ->where([
                            ['nom', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])->OrWhere([
                            ['prenoms', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])
                        ->OrWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")
                         ->select('id',);
                       })
            ->get()->toArray();


    $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id',$liste_reaffectations_filter)->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites

    
      $nouvelle_opp_filter = AffectationOpportunites::whereIn('id' , function($query) use ($namefilter) {
             $query->from('prospection_clients')->where([
             ['nom','LIKE', '%'.$namefilter.'%'],
            ['isvisible', '=', 1]
        ])->orWhere([
            ['prenoms','LIKE', '%'.$namefilter.'%'],
            ['isvisible', '=', 1]
        ])->orWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")->select('id');
    })->select('id',)
     ->get()->toArray();


     $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->whereIn('id',$nouvelle_opp_filter)
     ->get()->toArray();





     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '!=', null],
        ['isvisible', '=', 1],
        ['nom','LIKE', '%'.$namefilter.'%'],
        ])
         ->orWhere('prenoms','LIKE', '%'.$namefilter.'%')
         ->orWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")
      ->limit(500)
      ->get()->toArray();

    //nouvelle opportunites

       return view('liste_opportunite_admin', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','namefilter'));

   }


   

   public function filter_opp_name_agent(Request $request){

        $namefilter=  $request->namefilter;
    $currentdate = date('Y-m-d').' 00:00:00';


    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

    //opportunite relance
    $liste_relances_filter = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
             ['daterelance', '<=', $currentdate],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'gagne'],  
            ['isvisible', '=', 1],
            ])->select('id')->whereIn('idopportunite', function($query) use ($namefilter) {
                         $query->from('prospection_clients')
                         ->where([
                            ['nom', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])->OrWhere([
                            ['prenoms', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])
                        ->OrWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")
                         ->select('id',);
                       })
    ->get()->toArray();

    $liste_relances = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id',$liste_relances_filter) ->get()->toArray();
    




    //opportunite relance
    //reaffectations

      $liste_reaffectations_filter = NoteOpportunites::whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
             ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ])->whereDate('date_affect', '=', $currentdate)
            // ->orderBy('date_affect', 'DESC')
           ->select('id')->whereIn('idopportunite', function($query) use ($namefilter) {
                         $query->from('prospection_clients')
                         ->where([
                            ['nom', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])->OrWhere([
                            ['prenoms', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])
                        ->OrWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")
                         ->select('id',);
                       })
            ->get()->toArray();


    $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id',$liste_reaffectations_filter)->get()->toArray();

     //reaffectations zeze
 
    //nouvelle opportunites

    
      $nouvelle_opp_filter = AffectationOpportunites::whereIn('idopportunite' , function($query) use ($namefilter) {
             $query->from('prospection_clients')->where([
             ['nom','LIKE', '%'.$namefilter.'%'],
            ['isvisible', '=', 1]
        ])->orWhere([
            ['prenoms','LIKE', '%'.$namefilter.'%'],
            ['isvisible', '=', 1]
        ])->orWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")->select('id');
    })->select('id',)
      ->where([['idagentbackoffice', '=', Session::get('agentbackofficeid')]])
     ->get()->toArray();


     $nouvelle_opp = AffectationOpportunites::with('Opportunites','AgentBackoffice')->doesntHave('commentaire')
     ->whereIn('id',$nouvelle_opp_filter)
     ->get()->toArray();

    





     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
        ['isvisible', '=', 1],
        ['nom','LIKE', '%'.$namefilter.'%'],
        ])
         ->orWhere('prenoms','LIKE', '%'.$namefilter.'%')
         ->orWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")
      ->limit(2)
      ->get()->toArray();

     // dd($listeprospectioncreated);

    //nouvelle opportunites

       return view('liste_opportunite', compact('liste_relances','liste_reaffectations','nouvelle_opp','listeprospectioncreated','listecommerciaux','namefilter'));

   }





   public function filter_relance_admin (Request $request){

    $selectedagent = $request->selectagent;
    $datedebut = $request->datedebut;
    $datefin = $request->datefin;



    //$currentdate = date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
    $foundagent = AgentBackoffices::where('id',$selectedagent)->get()->toArray();

    $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            // ['daterelance', '<=', $currentdate],
            ['idagentbackoffice', '=', $selectedagent],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],   
            ])
    ->whereDate('daterelance', '>=', $datedebut)
    ->whereDate('daterelance', '<=', $datefin)
    ->get()->toArray();


    if ($selectedagent == 'tous') {
        // code...
        $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                // ['daterelance', '<=', $currentdate],
                // ['idagentbackoffice', '=', $selectedagent],
                ['resultat', '!=', 'perdu'],
                ['resultat', '!=', 'horscible'],   
                ])
        ->whereDate('daterelance', '>=', $datedebut)
        ->whereDate('daterelance', '<=', $datefin)
        ->get()->toArray();
    }



    // dd($listeprospection);

    return view('liste_prospection_byagent_relance_admin', compact('listeprospection','listecommerciaux','datedebut','datefin','foundagent'));

   }




   public function filter_relance_tel_admin (Request $request){

    
    $tel=  $request->telfiltre;
    $telclearn=  str_replace(' ', '', $request->telfiltre);
    $currentdate = date('Y-m-d').' 00:00:00';

    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
    


    $listeprospection = ProspectionClient::with(['commentaires' => function ($query) {
        $currentdate = date('Y-m-d').' 00:00:00';
        $query->where([
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'], 
            ['isvisible', '=', 1],
        ])->whereDate('daterelance', '<=', $currentdate)->latest('id')->first();;
    },'commentaires.AgentBackoffice'])->where([
        ['telephone', 'LIKE', '%'.$telclearn.'%']
        ])->orWhere('telephone','LIKE', '%'.$tel.'%')
        ->orWhere('telephone2','LIKE', '%'.$tel.'%')
    ->orWhere('telephone2','LIKE', '%'.$telclearn.'%')->get()->toArray();


      // dd($listeprospection);
    return view('liste_prospection_byagent_relance_tel_admin', compact('listeprospection','listecommerciaux','tel'));

   }



  public function filter_relance_name_admin (Request $request){

    
    $namefilter=  $request->namefilter;
    $currentdate = date('Y-m-d').' 00:00:00';

    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
    


    $listeprospection = ProspectionClient::with(['commentaires' => function ($query) {
        $currentdate = date('Y-m-d').' 00:00:00';
        $query->where([
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'], 
            ['isvisible', '=', 1],
        ])->whereDate('daterelance', '<=', $currentdate)->latest('id')->first();;
    },'commentaires.AgentBackoffice'])->where([
        ['nom', 'LIKE', '%'.$namefilter.'%']
        ])->orWhere('prenoms','LIKE', '%'.$namefilter.'%')->get()->toArray();


      // dd($listeprospection);
    return view('liste_prospection_byagent_relance_name_admin', compact('listeprospection','listecommerciaux'));

   }




   public function filter_relance_relance_admin (Request $request){

    
    $datedebut = $request->datedebut;
    $datefin = $request->datefin;



    //$currentdate = date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

    $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            // ['daterelance', '<=', $currentdate],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],   
            ])
    ->whereDate('daterelance', '>=', $datedebut)
    ->whereDate('daterelance', '<=', $datefin)
    ->get()->toArray();


    // dd($listeprospection);
    return view('liste_prospection_byagent_relance_echeance_admin', compact('listeprospection','listecommerciaux','datedebut','datefin'));

   }


   public function filter_relance_echeance_admin (Request $request){

    
    $datedebut = $request->datedebut;
    $datefin = $request->datefin;



    //$currentdate = date('Y-m-d').' 00:00:00';
    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

    $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            // ['daterelance', '<=', $currentdate],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'horscible'],   
            ])
    ->whereDate('echeance', '>=', $datedebut)
    ->whereDate('echeance', '<=', $datefin)
    ->get()->toArray();


    // dd($listeprospection);
    return view('liste_prospection_byagent_relance_echeance_admin', compact('listeprospection','listecommerciaux','datedebut','datefin'));

   }





   



   

   public function listeprospectionbyagentrelancebydate (Request $request){

   
   
   $datefiltre_deb=  $request->datefiltre_deb;
   $datefiltre_fin=  $request->datefiltre_fin;
   $finalfiltre =  'echeance';

   $listeprospection ='';



   // dd($request->selectfiltre );

   if ($request->selectfiltre == 'date_ech') {
       // code...
     $finalfiltre =  'echeance';
      $listeprospection = NoteOpportunites::with('Opportunite')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            // ['daterelance', '=', $dateecheance],
            ['resultat', '!=', 'perdu'],   
            ['resultat', '!=', 'horscible'],
            ])
     ->whereDate('echeance', '>=', $datefiltre_deb)
     ->whereDate('echeance', '<=', $datefiltre_fin)
    ->get()->toArray();
    //dd($listeprospection);
   }

   if ($request->selectfiltre == 'date_rel') {
       // code...
     $finalfiltre =  'daterelance';
     $listeprospection = NoteOpportunites::with('Opportunite')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            // ['daterelance', '=', $dateecheance],
            ['resultat', '!=', 'perdu'] ,
            ['resultat', '!=', 'horscible'],  
            ])
     ->whereDate('daterelance', '>=', $datefiltre_deb)
     ->whereDate('daterelance', '<=', $datefiltre_fin)
    ->get()->toArray();

   }



    return view('liste_prospection_byagent_relance', compact('listeprospection','datefiltre_deb','datefiltre_fin','finalfiltre'));
   }

   


   public function liste_prospection_byagent_ferme (request $request){


      $listeprospection = NoteOpportunites::with('Opportunite')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            // ['daterelance', '<=', $currentdate]   
            ])->limit(1000)
    ->get()->toArray();


    // dd($listeprospection);



    return view('liste_prospection_byagent_ferme', compact('listeprospection'));
   }


   public function liste_prospection_ferme (request $request){

    
  //ProspectionClient::with('AgentTerrain','affectation')
      $listeprospection = NoteOpportunites::with('Opportunite','Affectations')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->orderBy('id', 'DESC')->limit(200)
    ->get()->toArray();

    //dd($listeprospection);

    return view('liste_prospection_ferme', compact('listeprospection'));
   }


   

   public function filter_prospection_ferme (request $request){

    $datefiltre_deb=  $request->datefiltre_deb;
    $datefiltre_fin=  $request->datefiltre_fin;
      $listeprospection = NoteOpportunites::with('Opportunite','Affectations')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->limit(200)
    ->get()->toArray();




    return view('liste_prospection_ferme', compact('listeprospection'));
   }


   public function filter_prospection_ferme_tel (request $request){

    $tel =$request->telfiltre;

    $telfiltre=  str_replace(' ', '', $request->telfiltre);

         $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
               $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
            })->where([
                    ['resultat', '!=', 'gagne'],
                    ['resultat', '!=', 'poursuivre'],
                    ['resultat', '!=', 'reporte'],
                    ])
                       ->select('id')->whereIn('idopportunite', function($query) use ($telfiltre) {
                         $query->from('prospection_clients')
                         ->where([
                            ['telephone', '=', $telfiltre],
                             ['isvisible', '=', '1'],
                        ])->OrWhere([
                            ['telephone2', '=', $telfiltre],
                             ['isvisible', '=', '1'],
                        ])
                         ->select('id',);
                       })
                   ->get()->toArray(); //30549


         $listeprospection = NoteOpportunites::with('Opportunite','Affectations')->whereIn('id',$liste_commentaire) ->get()->toArray();

         // dd($listeprospection);


    return view('liste_prospection_ferme', compact('listeprospection','tel'));



   }





public function filter_prospection_ferme_nom (request $request){

    $namefilter =$request->namefilter;

         $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
               $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
            })->where([
                    ['resultat', '!=', 'gagne'],
                    ['resultat', '!=', 'poursuivre'],
                    ['resultat', '!=', 'reporte'],
                    ])
                       ->select('id')->whereIn('idopportunite', function($query) use ($namefilter) {
                         $query->from('prospection_clients')
                         ->where([
                            ['nom', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])->OrWhere([
                            ['prenoms', '=', $namefilter],
                             ['isvisible', '=', '1'],
                        ])
                        ->OrWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")
                         ->select('id',);
                       })
                   ->get()->toArray(); //30549


         $listeprospection = NoteOpportunites::with('Opportunite','Affectations')->whereIn('id',$liste_commentaire) ->get()->toArray();

         // dd($listeprospection);


    return view('liste_prospection_ferme', compact('listeprospection','namefilter'));



   }






   public function liste_prospection_groupee (Request $request){



        // $listeprospection = AgentBackoffices::with(['Affectations.Opportunites','Affectations' => function (Builder $query) {
        //     $query->where('status', '=', '1');
        // }])->get()->toArray();
    // AffectationOpportunites::with

    // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();



    $listeprospection = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
             //['idagentbackoffice', '=', Session::get('agentbackofficeid')],
             ['status', '=', 1]
            ])
    //  ->whereMonth(
    // 'created_at', '=', Carbon::now()->subMonth()->month) 12430 12233
     ->latest()->take(500)
     ->get()->toArray();

     

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where([
        ['idagentbackoffice', '!=', null],
        ['isvisible', '=', 1]
        ])->limit(500)
      ->get()->toArray();

     // dd($listeprospectioncreated);


      





    return view('liste_prospection_groupee', compact('listeprospection','listeprospectioncreated','listecommerciaux'));

   }


   public function reaffectation_datee_admin(Request $request){


      // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
      //les reaffectations du jours : commentaire reaff et createdat aujourdhui

      // $currentdate= DateTime::createFromFormat('Y-m-d', '2024-07-07');
      // $endate= DateTime::createFromFormat('Y-m-d', '2024-07-15');

      $currentdate = date('Y-m-d');
      $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ])->whereDate('date_affect', '=', $currentdate)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();


         // dd($listeprospection);

              // dd($listeraffectation);
     //fin de reaffectations du jour  listeraffectation

    return view('liste_reaffectation_datee', compact('listeprospection','listecommerciaux'));
   }



   public function reaffectation_datee_byagent(Request $request){


      // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
      //les reaffectations du jours : commentaire reaff et createdat aujourdhui

      // $currentdate= DateTime::createFromFormat('Y-m-d', '2024-07-07');
      // $endate= DateTime::createFromFormat('Y-m-d', '2024-07-15');

      $currentdate = date('Y-m-d');
      $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['observation', 'like', '%reaff%'],
            ['resultat', '!=', 'gagne'], 
            ]) ->whereDate('date_affect', '=', $currentdate)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();


            // dd($listeprospection);

              // dd($listeraffectation);
     //fin de reaffectations du jour  listeraffectation

    return view('liste_reaffectation_datee_agent', compact('listeprospection'));
   }



   public function filter_reaffectation_bydate (request $request){

           $debutaffect = $request->debutaffect;
           $finaffect = $request->finaffect;
           $idagent = $request->selectagent;
           $selectedAgent ='Tous';

         
           
         // $listecommerciaux = AgentBackoffices::all()->toArray();
           $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
        
        if ($idagent == 'tous') {
            // code...

             $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
          
                ['observation', 'like', '%reaff%'],
                ['resultat', '!=', 'gagne'], 
                ])->whereDate('date_affect', '>=', $debutaffect)
                  ->whereDate('date_affect', '<=', $finaffect)
                  // ->orWhereDate('date_affect', '>=', $debutaffect)
                  // ->orWhereDate('date_affect', '<=', $finaffect)
                ->orderBy('date_affect', 'DESC')
                ->get()->toArray();

        }else{

         $findadgent = AgentBackoffices::where('id', '=', $idagent)->select('firstname','lastname')->get()->toArray();
         $selectedAgent = $findadgent[0]['lastname'].' '.$findadgent[0]['firstname'];
         $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['idagentbackoffice', '=', $idagent],
                ['observation', 'like', '%reaff%'],
                ['resultat', '!=', 'gagne'], 
                ])->whereDate('date_affect', '>=', $debutaffect)
                  ->whereDate('date_affect', '<=', $finaffect)
                  // ->orWhereDate('date_affect', '>=', $debutaffect)
                  // ->orWhereDate('date_affect', '<=', $finaffect)
                ->orderBy('date_affect', 'DESC')
                ->get()->toArray();

        }


         
         


        


            return view('liste_reaffectation_datee', compact('listeprospection','listecommerciaux','debutaffect','finaffect','selectedAgent'));
   }


   public function filter_reaffectation_bydate_agent (request $request){

           $debutaffect = $request->debutaffect;
           $finaffect = $request->finaffect;
          
           
         // $listecommerciaux = AgentBackoffices::all()->toArray();
           $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
         $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['idagentbackoffice', '=', Session::get('agentbackofficeid') ],
                ['observation', 'like', '%reaff%'],
                ['resultat', '!=', 'gagne'], 
                ])->whereDate('date_affect', '>=', $debutaffect)
                  ->whereDate('date_affect', '<=', $finaffect)
                   // ->orWhereDate('date_affect', '>=', $debutaffect)
                   //  ->orWhereDate('date_affect', '<=', $finaffect)

        ->orderBy('date_affect', 'DESC')
                ->get()->toArray();

            return view('liste_reaffectation_datee_agent', compact('listeprospection','listecommerciaux','debutaffect','finaffect'));
   }



   public function filter_affectation_byagent (Request $request){

    $selectedagent = $request->selectagent;
    $datedebut = $request->datedebut;
    $datefin = $request->datefin;
    $finalAgent='Tous';

     // dd($datefin);

    // $listecommerciaux = AgentBackoffices::all()->toArray();

    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

    if ($selectedagent == 'tous') {
        // code...

        $listeprospection = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
             ['status', '=', 1]
            ])
     ->whereDate('date_affect', '>=', $datedebut)
     ->whereDate('date_affect', '<=', $datefin)
     ->get()->toArray();


      // dd($listeprospection);
     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->whereDate('created_at', '>=', $datedebut)
      ->whereDate('created_at', '<=', $datefin)
      ->get()->toArray();

       // dd($listeprospectioncreated);
    }else{

    $findadgent = AgentBackoffices::where('id', '=', $selectedagent)->select('firstname','lastname')->get()->toArray();
    // dd($findadgent);
         $finalAgent = $findadgent[0]['lastname'].' '.$findadgent[0]['firstname'];
    
    $listeprospection = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
             ['idagentbackoffice', '=', $selectedagent],
             ['status', '=', 1]
            ])
     ->whereDate('date_affect', '>=', $datedebut)
     ->whereDate('date_affect', '<=', $datefin)
     ->get()->toArray();

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where('idagentbackoffice', '=', $selectedagent)
      ->whereDate('created_at', '>=', $datedebut)
      ->whereDate('created_at', '<=', $datefin)
      ->get()->toArray();
    }
     //dd($listeprospection);


       //les reaffectations du jours : commentaire reaff et createdat aujourdhui

      // $currentdate= DateTime::createFromFormat('Y-m-d', '2024-07-07');
      // $endate= DateTime::createFromFormat('Y-m-d', '2024-07-15');
    //   $listeraffectation = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
    //    $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    // })->where([
    //         ['idagentbackoffice', '=', $selectedagent],
    //         ['observation', 'like', '%reaff%'],
    //         // ['resultat', '!=', 'perdu'],
    //         // ['resultat', '!=', 'horscible'],
    //         // ['resultat', '!=', 'gagne'], 
    //         ]) ->whereDate('created_at', '>=', $datedebut)
    //          ->whereDate('created_at', '<=', $datefin)
    // ->orderBy('created_at', 'DESC')
    //         ->get()->toArray();

              // dd($listeraffectation);
     //fin de reaffectations du jour 

    return view('liste_prospection_groupee', compact('listeprospection','listeprospectioncreated','listecommerciaux','datedebut','datefin','finalAgent'));

   }



   public function filter_affectation_byclientname (Request $request){

    $namefilter = $request->namefilter;
   


    // dd($datedebut);

    // $listecommerciaux = AgentBackoffices::all()->toArray();

    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    $listeprospection = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
     ->where([
             ['idagentbackoffice', '=', $selectedagent],
             ['status', '=', 1]
            ])
     ->whereDate('created_at', '>=', $datedebut)
     ->whereDate('created_at', '<=', $datefin)
     ->get()->toArray();

     $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
      ->where('idagentbackoffice', '=', $selectedagent)
      ->whereDate('created_at', '>=', $datedebut)
      ->whereDate('created_at', '<=', $datefin)
      ->get()->toArray();





      //filter_affectation_byclientname





     //dd($listeprospection);

    return view('liste_prospection_groupee', compact('listeprospection','listeprospectioncreated','listecommerciaux'));

   }


//zouzou
    public function filter_affectation_bytel (Request $request){

    $tel = $request->telfiltre;
    $telfiltre=  str_replace(' ', '', $request->telfiltre);


   
    // dd($datedebut);

   // $listecommerciaux = AgentBackoffices::all()->toArray();
    $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    // dd($listecommerciaux);
  //  ->get()->toArray();

     $listeprospection = AffectationOpportunites::has(['Opportunites' => function ($query) use ($telfiltre) {
        $query->where([
            ['telephone',  'LIKE', '%'.$telfiltre.'%'],
            // ['isvisible', '=', 1],
        ])->orWhere([
            ['telephone2',  'LIKE', '%'.$telfiltre.'%'],
            // ['isvisible', '=', 1]
        ]);
    },'commentaire.AgentBackoffice'])->limit(2)->get()->toArray();

     
     //dd($listeprospection);


       $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
     ->where('telephone', 'LIKE', '%'.$telfiltre.'%')
     ->orWhere('telephone2','LIKE', '%'.$telfiltre.'%')
     ->get()->toArray();


    // dd($listeprospection);

    return view('liste_prospection_groupee', compact('listeprospection','listeprospectioncreated','listecommerciaux'));

   }

   

 


   public function enregister_propection (Request $request){

        $liste_canal= Canals::where([
                    ['isactive', '=', 1],
                ])->get();


    return view('create_prospection_form', compact('liste_canal'));
   }



   public function enregister_note_propection  ($idopp){


       
       
    $assureurlist = Assureur::all();


    $findOpportunity = ProspectionClient::with('AgentTerrain','AgentEnligne')->where([
                  ['id', '=', $idopp],
                  ])->first()->toArray();





    //mise a jour des privileges dans les sessiion
   $agentid = Session::get('agentbackofficeid');
   $findprivileges = PrivilegesAgentBo::where([
                  ['id_user', '=', $agentid],
                  ['statut', '=', 1],
                  ])->select('id_priv')->get()->toArray();


          $privarray= array();
          foreach ($findprivileges as $findprivileges_el) {
            // code...
            $privarray[]= $findprivileges_el['id_priv'];
          }
          Session::put('userprivilege_list',$privarray);

   

   // $listecommerciaux = AgentBackoffices::all()->toArray();
          $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    $listeoppeff = ProspectionClient::with('commentaires.AgentBackoffice')->where([
                  ['id', '=', $idopp],
                  ])->first()->toArray();


    //dernier commentaire

    $lastcommentaire = NoteOpportunites::where([
                  ['idopportunite', '=', $idopp],
                   ['isvisible', '=', 1],
                 ])->orderBy('id', 'DESC')
                 ->first();

    $lastcommentaire_reaff = NoteOpportunites::with('reaffectation')->where([
                  ['idopportunite', '=', $idopp],
                   ['isvisible', '=', 1],
                 ])
                ->whereNotNull('reaff_par')
                ->orderBy('id', 'DESC')
                ->first();



    $listecommentaire = NoteOpportunites::with('AgentBackoffice','Affectations.AuteurAffecation','reaffectation')->where([
                  ['idopportunite', '=', $idopp],
                  ['isvisible', '=', 1],
                 ])->orderBy('id', 'DESC')
                 ->get()->toArray();

    // $lastgagne = NoteOpportunites::with('AgentBackoffice','Affectations.AuteurAffecation','reaffectation')->where([
    //               ['idopportunite', '=', $idopp],
    //               ['resultat', '=', 'gagne'],
    //              ])->orderBy('id', 'DESC')
    //              ->get()->toArray();


    $lastgagne = NoteOpportunites::where([
                 ['resultat', '=', 'gagne'],
                ['idopportunite', '=', $idopp],
                ])->orderBy('id', 'DESC')
    ->first();

    if($lastgagne)
      $lastgagne =$lastgagne->toArray();

 

                    
    if ( $lastcommentaire_reaff) {
        // code...
         $lastcommentaire_reaff = $lastcommentaire_reaff->toArray();
    }
    if ($lastcommentaire) {
        // code...
        $lastcommentaire = $lastcommentaire->toArray();
         return view('create_note_prospection_form',compact('findOpportunity','listeoppeff','lastcommentaire','listecommentaire','listecommerciaux','lastcommentaire_reaff','lastgagne','assureurlist'));
    }else
    return view('create_note_prospection_form',compact('findOpportunity','listeoppeff','listecommentaire','listecommerciaux','lastcommentaire_reaff','lastgagne','assureurlist'));

   }


   public function create_client_frcg (request $request){



    $nomclient_cg =  $request->nomclient_cg;
    $num_matricule_cg =  $request->num_matricule_cg;


    $assureurlist = Assureur::all();
    // $findOpportunity = ProspectionClient::with('AgentTerrain','AgentEnligne')->where([
    //               ['id', '=', $idopp],
    //               ])->first()->toArray();





    //mise a jour des privileges dans les sessiion
   $agentid = Session::get('agentbackofficeid');
   $findprivileges = PrivilegesAgentBo::where([
                  ['id_user', '=', $agentid],
                  ['statut', '=', 1],
                  ])->select('id_priv')->get()->toArray();


          $privarray= array();
          foreach ($findprivileges as $findprivileges_el) {
            // code...
            $privarray[]= $findprivileges_el['id_priv'];
          }
          Session::put('userprivilege_list',$privarray);

   

   // $listecommerciaux = AgentBackoffices::all()->toArray();

   $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


    // $listeoppeff = ProspectionClient::with('commentaires.AgentBackoffice')->where([
    //               ['id', '=', $idopp],
    //               ])->first()->toArray();


    //dernier commentaire

    // $lastcommentaire = NoteOpportunites::where([
    //               ['idopportunite', '=', $idopp],
    //                ['isvisible', '=', 1],
    //              ])->orderBy('id', 'DESC')
    //              ->first();

    // $lastcommentaire_reaff = NoteOpportunites::with('reaffectation')->where([
    //               ['idopportunite', '=', $idopp],
    //                ['isvisible', '=', 1],
    //              ])
    //             ->whereNotNull('reaff_par')
    //             ->orderBy('id', 'DESC')
    //             ->first();



    // $listecommentaire = NoteOpportunites::with('AgentBackoffice','Affectations.AuteurAffecation','reaffectation')->where([
    //               ['idopportunite', '=', $idopp],
    //               ['isvisible', '=', 1],
    //              ])->orderBy('id', 'DESC')
    //              ->get()->toArray();

    // $lastgagne = NoteOpportunites::with('AgentBackoffice','Affectations.AuteurAffecation','reaffectation')->where([
    //               ['idopportunite', '=', $idopp],
    //               ['resultat', '=', 'gagne'],
    //              ])->orderBy('id', 'DESC')
    //              ->get()->toArray();


    // $lastgagne = NoteOpportunites::where([
    //              ['resultat', '=', 'gagne'],
    //             ['idopportunite', '=', $idopp],
    //             ])->orderBy('id', 'DESC')
    // ->first();

    // if($lastgagne)
    //   $lastgagne =$lastgagne->toArray();

 

                    
    // if ( $lastcommentaire_reaff) {
    //     // code...
    //      $lastcommentaire_reaff = $lastcommentaire_reaff->toArray();
    // }
    // if ($lastcommentaire) {
    //     // code...
    //     $lastcommentaire = $lastcommentaire->toArray();
    //      return view('create_note_prospection_form',compact('findOpportunity','listeoppeff','lastcommentaire','listecommentaire','listecommerciaux','lastcommentaire_reaff','lastgagne','assureurlist'));
    // }else


    return view('create_client_file_from_cg',compact('listecommerciaux','assureurlist','nomclient_cg','num_matricule_cg'));


   }


    public function prospection_full_details  ($idopp){





        // $findOpportunity = ProspectionClient::with('commentaires.AgentBackoffice')->where([
        //           ['id', '=', $idopp],
        //           ])->first()->toArray();


         $findOpportunity = ProspectionClient::with(['commentaires' => function (Builder $query) {
                $query->where('isvisible', '=', '1');
            },'commentaires.AgentBackoffice'])->where([
                  ['id', '=', $idopp],
                  ])->first()->toArray();


//         $users = User::with(['posts' => function (Builder $query) {
//     $query->where('title', 'like', '%code%');
// }])->get();

         // dd($findOpportunity);

    return view('prospections_full_details',compact('findOpportunity'));

   }


    public function get_canal_list  (Request $request){

        return $liste_canal= Canals::where([
                    ['isactive', '=', 1],
                ])->get();

   }


   public function uploadfile (Request $request){

        Excel::import(new ProspectionClientImport, $request->file);
        return 'data imported';

    }


     public function importopportunites (Request $request){

        return view('importopportunites');

    }



    public function notification_asap (request $request){


         $findOpportunity = ProspectionClient::where([
                  ['isasap', '=', 1],
                  ])->limit(4)
                ->get()->toArray();

        return view('asapnotification', compact("findOpportunity"));
    }



   


     public function notification_asapnbre (request $request){


         $findOpportunity = ProspectionClient::where([
                  ['isasap', '=', 1],
                  ])->limit(4)
                   ->get()->toArray();

        return count($findOpportunity);
    }


    public function liste_renouvellement (request $request) {

        $currentdate = date('Y-m-d').' 00:00:00';
        $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->where([
                  ['resultat', '=', 'gagne'],
                  ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                  ['daterelance', '<=', $currentdate],
                 ])->orderBy('heure_relance', 'ASC')
                 ->get()->toArray();
            
     
         //dd($listeprospection);
         return view('liste_renouvellement', compact("listeprospection"));

    }


    public function liste_contrat (request $request) {


        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

        // $listeprospection = ProspectionClient::with(['AgentTerrain','affectation.AgentBackoffice','commentaires' => function ($query)  {
        //     $query->latest();
        //  }])

        // $listeprospection = Contrats::with(['Opportunite','commentaire.AgentBackoffice')

        // $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')
        // ->where('isvisible',1)
        // ->whereDate('created_at',date('Y-m-d'))
        // ->get()->toArray();



         $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire', function($query)  {
               $query->from('note_opportunites')->where([
            ]) ->where('isvisible',1)
               ->select('id');
            })->where('isvisible', '=', 1)
            ->whereDate('created_at',date('Y-m-d'))
         ->get()->toArray();



            
     
            // dd($listeprospection);
         return view('liste_contrat', compact("listeprospection",'listecommerciaux'));

    }


    

    public function filter_liste_contrat (request $request) {

        $datedebut = $request->datedebut;
        $datefin = $request->datefin;
        $selectedagent = $request->selectagent;
        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

        
         $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire', function($query) use ($datedebut, $datefin,$selectedagent) {
             
               $query->from('note_opportunites')->where([
                ['idagentbackoffice', '=', $selectedagent],
            ]) ->whereDate('created_at', '>=', $datedebut)
               ->whereDate('created_at', '<=', $datefin)
               ->select('id');
            })->where('isvisible', '=', 1)
         ->get()->toArray();


         if ($selectedagent == 'tous') {
             // code...
         $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire', function($query) use ($datedebut, $datefin,$selectedagent) {
             
               $query->from('note_opportunites')->where([
                // ['idagentbackoffice', '=', $selectedagent],
            ]) ->whereDate('created_at', '>=', $datedebut)
               ->whereDate('created_at', '<=', $datefin)
               ->select('id');
            })->where('isvisible', '=', 1)
         ->get()->toArray();

        }
     
            // dd($listeprospection);
         return view('liste_contrat', compact("listeprospection",'listecommerciaux'));

    }

    //yoo
    public function filter_contrat_byagent_admin (request $request) {

        $datedebut = $request->datedebut;
        $datefin = $request->datefin;
        $selectedagent = $request->selectagent;


        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
        $foundagent = AgentBackoffices::where('id',$selectedagent)->get()->toArray();

        
        //  $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire', function($query) use ($datedebut, $datefin,$selectedagent) {
             
        //        $query->from('note_opportunites')->where([
        //         ['idagentbackoffice', '=', $selectedagent],
        //         ['resultat', '!=', 'perdu'],
        //         ['resultat', '!=', 'horscible'],
        //     ]) ->whereDate('echeance', '>=', $datedebut)
        //        ->whereDate('echeance', '<=', $datefin)
        //        ->select('id');
        //     })->get()->toArray();


        //  if ($selectedagent == 'tous') {
        //      // code...
        //  $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire', function($query) use ($datedebut, $datefin,$selectedagent) {
             
        //        $query->from('note_opportunites')->where([
        //         // ['idagentbackoffice', '=', $selectedagent],
        //         ['resultat', '!=', 'perdu'],
        //         ['resultat', '!=', 'horscible'],
        //     ]) ->whereDate('echeance', '>=', $datedebut)
        //        ->whereDate('echeance', '<=', $datefin)
        //        ->select('id');
        //     })->get()->toArray();

        // }



         $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['idagentbackoffice', '=', $selectedagent],
                 ['resultat', '=', 'gagne'],
                ])
               ->whereDate('echeance', '>=', $datedebut)
               ->whereDate('echeance', '<=', $datefin)
               ->select('id')
               ->get()->toArray();

        // dd($liste_commentaire);

        if ($selectedagent == 'tous') {

            $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
            $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
            })->where([
                    // ['idagentbackoffice', '=', $selectedagent],
                   ['resultat', '=', 'gagne'],
                    ])
                   ->whereDate('echeance', '>=', $datedebut)
                   ->whereDate('echeance', '<=', $datefin)
                   ->select('id')
                   ->get()->toArray();

        }




         $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')
        ->whereNotIn('id',function($query) {
               $query->from('contrats')->select('commentaire');
            })
        ->whereIn('id',$liste_commentaire)
        ->where([
            ['isvisible', '=', 1],
            ['resultat', '=', 'gagne'],
          ])->get()->toArray();


         // $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire)->where('numpolice', 'LIKE', "%RN%") ->get()->toArray();

        $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire)->get()->toArray();;

     
            // dd($listeprospection);
         return view('liste_contrat_byagent_admin', compact("listeprospection",'listecommerciaux','datedebut','datefin','selectedagent','foundagent','listeprospection_nc'));

    }


    


    public function filter_contrat_echeance_admin (request $request) {

        $datefiltre_deb = $request->datefiltre_deb;
        $datefiltre_fin = $request->datefiltre_fin;
       

        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
        // $foundagent = AgentBackoffices::where('id',$selectedagent)->get()->toArray();


         $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
               
                 ['resultat', '=', 'gagne'],
                ])
               ->whereDate('echeance', '>=', $datefiltre_deb)
               ->whereDate('echeance', '<=', $datefiltre_fin)
               ->select('id')
               ->get()->toArray();

       
         $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')
        ->whereNotIn('id',function($query) {
               $query->from('contrats')->select('commentaire');
            })
        ->whereIn('id',$liste_commentaire)
        ->where([
            ['isvisible', '=', 1],
            ['resultat', '=', 'gagne'],
          ])->get()->toArray();

        $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire)->get()->toArray();;

         return view('liste_contrat_byagent_admin', compact("listeprospection",'listecommerciaux','listeprospection_nc','datefiltre_deb','datefiltre_fin'));

    }


    public function filter_contrat_relance_admin (request $request) {

        $datefiltrel_deb = $request->datefiltrel_deb;
        $datefiltrel_fin = $request->datefiltrel_fin;
       


        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
        // $foundagent = AgentBackoffices::where('id',$selectedagent)->get()->toArray();


         $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
               
                 ['resultat', '=', 'gagne'],
                ])
               ->whereDate('daterelance', '>=', $datefiltrel_deb)
               ->whereDate('daterelance', '<=', $datefiltrel_fin)
               ->select('id')
               ->get()->toArray();

       
         $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')
        ->whereNotIn('id',function($query) {
               $query->from('contrats')->select('commentaire');
            })
        ->whereIn('id',$liste_commentaire)
        ->where([
            ['isvisible', '=', 1],
            ['resultat', '=', 'gagne'],
          ])->get()->toArray();

        $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire)->get()->toArray();;

         return view('liste_contrat_byagent_admin', compact("listeprospection",'listecommerciaux','listeprospection_nc','datefiltrel_deb','datefiltrel_fin'));

    }


    public function filter_contrat_bytel_admin (request $request) {

        $telfiltre = $request->telfiltre;

        $telclean=  str_replace(' ', '', $request->telfiltre);
        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

        $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['resultat', '=', 'gagne'],
                ])
                   ->select('id')->whereIn('idopportunite', function($query) use ($telclean) {
                     $query->from('prospection_clients')
                     ->where([
                        ['telephone', '=', $telclean],
                    ])->OrWhere([
                        ['telephone2', '=', $telclean],
                    ])
                     ->select('id',);
                   })
               ->get()->toArray(); //30549

               $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire) ->get()->toArray();;


                $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')
        ->whereNotIn('id',function($query) {
               $query->from('contrats')->select('commentaire');
            })
        ->whereIn('id',$liste_commentaire)
        ->where([
            ['isvisible', '=', 1],
            ['resultat', '=', 'gagne'],
          ])->get()->toArray();

     
            // dd($listeprospection);
         return view('liste_contrat_byagent_admin', compact("listeprospection",'listecommerciaux','telfiltre','listeprospection_nc'));

    }



    public function filter_contrat_byclientname_admin (request $request) {

        $namefilter = $request->namefilter;
        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

        $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                 ['resultat', '=', 'gagne'],
                ])
                   ->select('id')->whereIn('idopportunite', function($query) use ($namefilter) {
                     $query->from('prospection_clients')
                     ->where([
                        ['nom', 'LIKE', '%'.$namefilter.'%'],
                    ])->OrWhere([
                        ['prenoms', 'LIKE', '%'.$namefilter.'%'], 
                    ])->OrWhere(DB::raw("CONCAT(`nom`, ' ', `prenoms`)"), 'LIKE', "%".$namefilter."%")
                     ->select('id',);
                   })
               ->get()->toArray(); //30549

        $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire)->get()->toArray();


             $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')
        ->whereNotIn('id',function($query) {
               $query->from('contrats')->select('commentaire');
            })
        ->whereIn('id',$liste_commentaire)
        ->where([
            ['isvisible', '=', 1],
            ['resultat', '=', 'gagne'],
          ])->get()->toArray();
     
            // dd($listeprospection);
         return view('liste_contrat_byagent_admin', compact("listeprospection",'listecommerciaux','namefilter','listeprospection_nc'));

    }



    public function filter_contrat_byplaque_admin (request $request) {

        $plaquefilter = $request->plaquefilter;
        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();

        $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['resultat', '=', 'gagne'],
                ])
                   ->select('id')->whereIn('idopportunite', function($query) use ($plaquefilter) {
                     $query->from('prospection_clients')
                     ->where([
                        ['plaque_immatriculation', '=', $plaquefilter],
                    ])
                     ->select('id',);
                   })
               ->get()->toArray(); //30549


        $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')
        ->whereNotIn('id',function($query) {
               $query->from('contrats')->select('commentaire');
            })
        ->whereIn('id',$liste_commentaire)
        ->where([
            ['isvisible', '=', 1],
            ['resultat', '=', 'gagne'],
          ])->get()->toArray();


         $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire)->get()->toArray();;
     
            // dd($listeprospection);
         return view('liste_contrat_byagent_admin', compact("listeprospection",'listecommerciaux','plaquefilter','listeprospection_nc'));

    }



    


    public function liste_contrat_byagent (request $request) {


         $currentMonth= date('m');
         $currentdate = date('Y-m-d');
         // $listecommerciaux= AgentBackoffices::all()->toArray();

         $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
         //$today = date('Y-m-d');
         $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                ['resultat', '!=', 'perdu'],
                ['isvisible', '=', '1'],
                ['resultat', '!=', 'horscible'],
                ['resultat', '!=', 'gagne'],
                ['resultat', '!=', 'reporte'],   
                ['resultat', '!=', 'poursuivre'],
                ['resultat', '!=', 'rdvsouscription'],
                ])
                // ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') <= relance_sys")
                // ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') > 0")
                // ->whereMonth('created_at', '=', $currentMonth)
                  ->whereDate('created_at', '=', $currentdate)
                ->select('id')
                ->get()->toArray();


        $liste_relances_array = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                // ['daterelance', '<=', $currentdate],
                ['resultat', '!=', 'perdu'],
                ['resultat', '!=', 'perdu_rn'],
                ['resultat', '!=', 'horscible'],
                ['resultat', '!=', 'horscible_rn'],
                ['resultat', '!=', 'gagne'],  
                ['isvisible', '=', 1],
                ])->whereDate('date_affect', '=', $currentdate)
        ->orderBy('heure_relance', 'ASC')->limit(2000)
        ->select('id')
        ->get()->toArray();

       


       //reaffectations

      $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
       $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    })->where([
            ['observation', 'like', '%reaff%'],
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
            ['resultat', '!=', 'perdu'],
            ['resultat', '!=', 'gagne'],
            ['isvisible', '=', '1'],
            ['resultat', '!=', 'horscible'],
            ['resultat', '!=', 'reporte'],   
            ['resultat', '!=', 'poursuivre'],
            ['resultat', '!=', 'rdvsouscription'],
            ])->whereNotIn('id', $liste_relances_array)
            ->whereDate('date_affect', '=', $currentdate)
             // ->whereMonth('date_affect', '=', $currentMonth)
            // ->orWhereDate('date_affect', '=', $currentdate)
            ->orderBy('date_affect', 'DESC')
            ->get()->toArray();



         $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire) ->get()->toArray();


         // dd($listeprospection);


          $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                 ['isvisible', '=', 1],
                 ['resultat', '!=', 'gagne'], 
                 ['resultat', '!=', 'perdu'], 
                 ['resultat', '!=', 'perdu_rn'],
                 ['resultat', '!=', 'horscible'],
                 ['resultat', '!=', 'horscible_rn'],   
                 ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                ])
               
                ->whereDate('created_at', '=', $currentdate)
                // ->whereMonth('created_at', '=', $currentMonth)
                // ->select('id')
                ->get()->toArray();

         return view('liste_contrat_byagent', compact("listeprospection",'listecommerciaux','liste_reaffectations','listeprospection_nc'));

    }


     public function liste_contrat_byagent_bydate (request $request) {


        
       $datedebut=  $request->datefiltre_deb;
       $datefin=  $request->datefiltre_fin;
       $finalfiltre =  'echeance';
       $filtre =  'echeance';

       //dd($request->selectfiltre );

      //dd($datefiltre_deb .' '.$datefiltre_fin);

        if ($request->selectfiltre == 'date_ech') {
             $finalfiltre =  'echeance';
             $filtre ='Echeance';
         }

         if ($request->selectfiltre == 'date_rel') {
              $finalfiltre =  'daterelance';
              $filtre ='Relance';
         }


            // dd ($finalfiltre);

          // $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire', function($query) use ($datefiltre_deb, $datefiltre_fin,$finalfiltre) {
          //      $query->from('note_opportunites')->where([
          //       ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
          //       // ['daterelance', '<=', $currentdate],
          //   ])->whereBetween($finalfiltre, [$datefiltre_deb, $datefiltre_fin])
          //     ->orderBy('heure_relance', 'ASC')->select('id');
          //   })->get()->toArray();

         // return view('liste_contrat_byagent_bydate', compact("listeprospection"));




         $currentMonth= date('m');
         $currentdate = date('Y-m-d');
         // $listecommerciaux= AgentBackoffices::all()->toArray();

         $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
         //$today = date('Y-m-d');

         //commentaires en poursuivre RN
         $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                ['resultat', '!=', 'perdu'],
                ['resultat', '!=', 'perdu_rn'],
                ['isvisible', '=', '1'],
                ['resultat', '!=', 'horscible'],
                ['resultat', '!=', 'horscible_rn'],
                ['resultat', '!=', 'gagne'],
                ['resultat', '!=', 'reporte'],   
                ['resultat', '!=', 'poursuivre'],
                ['resultat', '!=', 'rdvsouscription'],
                ])
                // ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') <= relance_sys")
                // ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') > 0")
                //->whereMonth('created_at', '=', $currentMonth)

                ->whereDate($finalfiltre, '>=', $datedebut)
                ->whereDate($finalfiltre, '<=', $datefin)
                ->select('id')
                ->get()->toArray();

       


       //reaffectations 
                //ancienne version
    //   $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
    //    $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
    // })->where([
    //         ['observation', 'like', '%reaff%'],
    //         ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    //         ['resultat', '!=', 'perdu'],
    //         ['resultat', '!=', 'gagne'],
    //         ['isvisible', '=', '1'],
    //         ['resultat', '!=', 'horscible'],
    //         ['resultat', '!=', 'reporte'],   
    //         ['resultat', '!=', 'poursuivre'],
    //         ['resultat', '!=', 'rdvsouscription'],
    //         ])
    //         ->whereDate('date_affect', '>=', $datedebut)
    //         ->whereDate('date_affect', '<=', $datefin)
    //         //->whereMonth('date_affect', '=', $currentMonth)
    //         //->orWhereDate('date_affect', '=', $currentdate)
    //         ->orderBy('date_affect', 'DESC')
    //         ->get()->toArray();

    //commentaire reaffectation
    $liste_reaffectations = NoteOpportunites::with('Opportunite','AgentBackoffice')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                // ['idagentbackoffice', '=', $selectedagent],
            ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                ['observation', 'like', '%reaff%'],
                ['resultat', '!=', 'gagne'], 
                 ])->whereNotIn('id', $liste_commentaire)
                 //->whereDate('date_affect', '=', $currentdate)
                // ->whereDate('daterelance', '>=', $datedebut)
                // ->whereDate('daterelance', '<=', $datefin)
                ->WhereDate('date_affect', '>=', $datedebut)
                ->WhereDate('date_affect', '<=', $datefin)

                ->orderBy('date_affect', 'DESC')
                ->get()->toArray();


     // dd($liste_reaffectations);


          $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                 ['isvisible', '=', 1],
                 ['resultat', '!=', 'gagne'],   
                 ['resultat', '!=', 'perdu'], 
                 ['resultat', '!=', 'perdu_rn'], 
                 ['resultat', '!=', 'horscible'], 
                 ['resultat', '!=', 'horscible_rn'],     
                 ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
                ])
               ->whereNotIn('idopportunite', $liste_commentaire)
               ->whereDate($finalfiltre, '>=', $datedebut)
               ->whereDate($finalfiltre, '<=', $datefin)
                // ->select('id')
                ->get()->toArray();


        // dd($listeprospection_nc);



         // $nouvelle_opp = AffectationOpportunites::with('Opportunites','commentaire','AgentBackoffice')
         // ->where([
         //         ['idagentbackoffice', '=', $selectedagent],
         //         ['status', '=', 1]
                 
         //        ])
         // ->latest()->take(500)
         // ->get()->toArray();

         // $listeprospectioncreated = ProspectionClient::with('AgentEnligne','affectation','commentaires')
         //  ->where([
         //    ['idagentbackoffice', '=', $selectedagent],
         //    ['isvisible', '=', 1]
         //    ])
         //  ->limit(500)
         //  ->get()->toArray();


         $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire) ->get()->toArray();

          return view('liste_contrat_byagent', compact("listeprospection",'listecommerciaux','liste_reaffectations','listeprospection_nc','datedebut','datefin','filtre'));

    }



    public function liste_contrat_byagent_admin (request $request) {


        // $listecommerciaux= AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
        $currentdate = date('Y-m-d').' 00:00:00';


         $liste_commentaire = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                 ['isvisible', '=', 1],
                 ['resultat', '=', 'gagne'],
                 // ['resultat', '!=', 'poursuivre'],   
                 // ['resultat', '!=', 'rdvsouscription'],  
                 // ['resultat', '!=', 'perdu'],  
                 // ['resultat', '!=', 'horscible'], 
                 // ['resultat', '!=', 'reporte'],   
                // ])->orwhere([
                //  ['isvisible', '=', 1],
                //  ['resultat', '=', 'poursuivre_rn']   
                // ])->orwhere([
                //  ['isvisible', '=', 1],
                //  ['resultat', '=', 'rdvsouscription_rn']   
                // ])->orwhere([
                //  ['isvisible', '=', 1],
                //  ['resultat', '=', 'reporte_rn']   
                ])
                ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') <= relance_sys")
                ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') > 0")
                ->select('id')
                ->get()->toArray();
         // dd($liste_commentaire);

         $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire',$liste_commentaire)->get()->toArray();

         //opportunite gagne mais pas dans les contrat
        // $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')
        // ->whereNotIn('id',function($query) {
        //        $query->from('contrats')->select('commentaire');
        //     })
        // // ->whereIn('id',$liste_commentaire)
        // ->where([
        // //     ['isvisible', '=', 1],
        // //     ['resultat', '=', 'gagne'],
        // // ])->orwhere([
        // //     ['isvisible', '=', 1],
        // //     ['resultat', '=', 'poursuivre_rn']   
        // // ])->orwhere([
        // //  ['isvisible', '=', 1],
        // //  ['resultat', '=', 'rdvsouscription_rn']   
        // // ])->orwhere([
        // //  ['isvisible', '=', 1],
        // //  ['resultat', '=', 'reporte_rn']   
        //  ['resultat', '!=', 'poursuivre'],   
        //  ['resultat', '!=', 'rdvsouscription'],  
        //  ['resultat', '!=', 'perdu'],  
        //  ['resultat', '!=', 'horscible'], 
        //  ['resultat', '!=', 'reporte'],  
        // ])->get()->toArray();





        // $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')->whereIn('id', function($query) {
        //    $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        // })->where([
        //          ['isvisible', '=', 1],
        //          ['resultat', '!=', 'gagne'],   
        //          ['resultat', '!=', 'poursuivre'],   
        //          ['resultat', '!=', 'rdvsouscription'],  
        //          ['resultat', '!=', 'perdu'],  
        //          ['resultat', '!=', 'horscible'], 
        //          ['resultat', '!=', 'reporte'],    
        //         ])
        //         ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') <= relance_sys")
        //         ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') > 0")
        //         // ->select('id')
        //         ->get()->toArray();


          $listeprospection_nc = NoteOpportunites::with('AgentBackoffice','Opportunite')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
        })->where([
                 ['isvisible', '=', 1],
                 ['resultat', '=', 'gagne'],   
                  
                ])
                ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') <= relance_sys")
                ->whereRaw("DATEDIFF(echeance,'".date('Y-m-d')."') > 0")
                // ->select('id')
                ->get()->toArray();

        // dd($listeprospection_nc);

         return view('liste_contrat_byagent_admin', compact("listeprospection",'listecommerciaux','listeprospection_nc'));

    }





    //  public function liste_contrat_byagent_bydate (request $request) {


        
    //    $datefiltre_deb=  $request->datefiltre_deb;
    //    $datefiltre_fin=  $request->datefiltre_fin;
    //    $finalfiltre =  'echeance';

    //   //dd($datefiltre_deb .' '.$datefiltre_fin);

    //     if ($request->selectfiltre == 'date_ech') {
    //          $finalfiltre =  'echeance';
    //      }

    //      if ($request->selectfiltre == 'date_rel') {
    //           $finalfiltre =  'daterelance';
    //      }


    //       $listeprospection = Contrats::with('Opportunite','commentaire.AgentBackoffice')->whereIn('commentaire', function($query) use ($datefiltre_deb, $datefiltre_fin,$finalfiltre) {
    //            $query->from('note_opportunites')->where([
    //             ['idagentbackoffice', '=', Session::get('agentbackofficeid')],
    //             // ['daterelance', '<=', $currentdate],
    //         ])->whereBetween($finalfiltre, [$datefiltre_deb, $datefiltre_fin])
    //           ->orderBy('heure_relance', 'ASC')->select('id');
    //         })->get()->toArray();

    //      return view('liste_contrat_byagent_bydate', compact("listeprospection"));

    // }




    



    public function liste_nvelle_opp_gagnee (request $request) {


        //
        // $listecommerciaux = AgentBackoffices::all()->toArray();

        $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


        //prospection
        $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->where([
                  ['resultat', '=', 'gagne'],
                  ])->get()->toArray();
            
     
          // dd($listeprospection);
         return view('bordereau_nvelle_opp_gagne', compact("listeprospection", "listecommerciaux"));

    }



    public function update_opportunite (request $request){


      $selectedid =  $request->selectedid;

      // dd($selectedid);
      $edit_name  =  $request->edit_name;
      $checkdoublon =  $request->checkdoublon;
      $edit_prenoms=  $request->edit_prenoms;
      $edit_dateecheance=  $request->edit_dateecheance;
      $edit_tel=  $request->edit_tel;
      $edit_tel2=  $request->edit_tel2;
      $edit_lieuprospection=  $request->edit_lieuprospection;
      $edit_observation=  $request->edit_observation;
      $plaqueimma=  $request->edit_immatriculation;

      
      $edit_tel2 =str_replace(' ', '', $edit_tel2);
      $edit_tel  =str_replace(' ', '', $edit_tel);

      $etatdiscours =  $request->etatdiscours;

      //dd($etatdiscours);
      $etatcg =  $request->etatcg;
      $etatattestation =  $request->etatattestation;




//verifier que le num nexiste pas en base 
      $nombre_occ_tel2=0;
      $nombre_occ_tel1=0;

         if ($edit_tel != '')
        $nombre_occ_tel1 = ProspectionClient::where(
           [ 
            ['telephone', 'LIKE', '%'.$edit_tel.'%'],
            ['id', '!=', $selectedid],
            ['isvisible', '=', '1'],
            ['doublon_check', '=', '0']
           ]
        )
         ->orWhere([
            ['telephone2','LIKE', '%'.$edit_tel.'%'],
            ['id', '!=', $selectedid],
            ['isvisible', '=', '1'],
            ['doublon_check', '=', '0']
            ])
           ->count();

        if ($edit_tel2 != '') 
        $nombre_occ_tel2 = ProspectionClient::where([
            ['telephone','LIKE', '%'.$edit_tel2.'%'],
            ['id', '!=', $selectedid],
            ['isvisible', '=', '1'],
            ['doublon_check', '=', '0']
            ])
           ->orWhere([
            ['telephone2','LIKE', '%'.$edit_tel2.'%'],
            ['id', '!=', $selectedid],
            ['isvisible', '=', '1'],
            ['doublon_check', '=', '0']
             
            ])->count();

         // dd($nombre_occ_tel2 +$nombre_occ_tel1);
         //privilege de pouvoir enregistrer les doublons 
         $privarray=  Session::get('userprivilege_list');
         // if ($nombre_occ <=0 || in_array(28, $privarray)) {


          if ($nombre_occ_tel2 + $nombre_occ_tel1 >0  && in_array(28, $privarray)) {
            // code...
             try {
                $newInsert = ProspectionClient::where([
                                  'id'=>$selectedid,
                              ])->update(
                                [
                            'author_doublon_check'=>Session::get('agentbackofficeid'),
                            'date_auth_doublon'=>date('Y-m-d'),
                            'doublon_check'=>1,
                                ]);
                  //return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }
        }

        if ($nombre_occ_tel2 + $nombre_occ_tel1 >0  && !in_array(28, $privarray) && $checkdoublon!=1) {
            // code...
             return response()->json(['message' => 'numero exist deja'], 201);
        }




         $dir="test/";
         $imgattesation = $request->file('Imgattesation');
         $imgcartegrise = $request->file('Imgcartegrise');

       
         $url_attestationassurance ='';
         $urlcarte_grise='';

        //dd($imgcartegrise);
        if ($request->hasFile('Imgattesation')) {
          
                $imageAttestationName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgattesation->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageAttestationName, file_get_contents($imgattesation));
                $url_attestationassurance = '/storage/test/'.$imageAttestationName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            $typeError[]=1;
            // return response()->json(['message' => 'failed to upload attestation'], 400);
        } 
       // return response()->json(['message' => trans('/storage/test/'.$imageAttestationName)], 200);



        if ($request->hasFile('Imgcartegrise')) {

          
                $imageCartegriseName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgcartegrise->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageCartegriseName, file_get_contents($imgcartegrise));
                $urlcarte_grise = '/storage/test/'.$imageCartegriseName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            // return response()->json(['message' => 'failed to upload carte grise'], 400);
            $typeError[]=2;
        } 





        if ($request->hasFile('Imgattesation') && $request->hasFile('Imgcartegrise') ) {

               
             try {
                $newInsert = ProspectionClient::where([
                                  'id'=>$selectedid,
                              ])->update(['nom'=>$edit_name,
                            'prenoms'=>$edit_prenoms,
                            'telephone'=>$edit_tel,
                            'telephone2'=>$edit_tel2,
                            'echeance'=>$edit_dateecheance,
                            'statut_discours'=>$etatdiscours,
                            'statut_carte_grise'=>$etatcg,
                            'statut_attestation'=>$etatattestation,
                            'urlcarte_grise'=>  $urlcarte_grise,
                            'url_attestationassurance'=>$url_attestationassurance,
                            'plaque_immatriculation'=>$plaqueimma,
                            'lieuprospection'=>$edit_lieuprospection,
                            'observation'=>$edit_observation]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }

            }else if($request->hasFile('Imgattesation')) {


                 

                try {
                $newInsert = ProspectionClient::where([
                                  'id'=>$selectedid,
                              ])->update(['nom'=>$edit_name,
                            'prenoms'=>$edit_prenoms,
                            'telephone'=>$edit_tel,
                            'telephone2'=>$edit_tel2,
                            'echeance'=>$edit_dateecheance,
                            'statut_discours'=>$etatdiscours,
                            'statut_carte_grise'=>$etatcg,
                            'statut_attestation'=>$etatattestation,
                             'plaque_immatriculation'=>$plaqueimma,
                            // 'urlcarte_grise'=>  $urlcarte_grise,
                            'url_attestationassurance'=>$url_attestationassurance,
                            // 'urlcarte_grise'=>$urlcarte_grise,
                            'lieuprospection'=>$edit_lieuprospection,
                            'observation'=>$edit_observation]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }



            }else if($request->hasFile('Imgcartegrise')) {

               
                try {
                $newInsert = ProspectionClient::where([
                                  'id'=>$selectedid,
                              ])->update(['nom'=>$edit_name,
                            'prenoms'=>$edit_prenoms,
                            'telephone'=>$edit_tel,
                            'telephone2'=>$edit_tel2,
                            'echeance'=>$edit_dateecheance,
                            'statut_discours'=>$etatdiscours,
                            'statut_carte_grise'=>$etatcg,
                            'statut_attestation'=>$etatattestation,
                            'urlcarte_grise'=>  $urlcarte_grise,
                             'plaque_immatriculation'=>$plaqueimma,
                            // 'urlcarte_grise'=>  $urlcarte_grise,
                            // 'url_attestationassurance'=>$url_attestationassurance,
                            'lieuprospection'=>$edit_lieuprospection,
                            'observation'=>$edit_observation]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }

            }else {

                    // dd('no data');
                try {
                $newInsert = ProspectionClient::where([
                                  'id'=>$selectedid,
                              ])->update(['nom'=>$edit_name,
                            'prenoms'=>$edit_prenoms,
                            'telephone'=>$edit_tel,
                            'telephone2'=>$edit_tel2,
                            'echeance'=>$edit_dateecheance,
                            'statut_discours'=>$etatdiscours,
                            'statut_carte_grise'=>$etatcg,
                            'statut_attestation'=>$etatattestation,
                             'plaque_immatriculation'=>$plaqueimma,
                            //'urlcarte_grise'=>  $urlcarte_grise,
                            //'urlcarte_grise'=>  $urlcarte_grise,
                            //'url_attestationassurance'=>$url_attestationassurance,
                            //'urlcarte_grise'=>$urlcarte_grise,
                            'lieuprospection'=>$edit_lieuprospection,
                            'observation'=>$edit_observation]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }



            }


    }

    public function removeopp (request $request){

        $selectedid =  $request->data_rem;

             try {
                $newInsert = ProspectionClient::where([
                                  'id'=>$selectedid,
                              ])->update(['isvisible'=>0,
                            ]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }

    }


    public function removeoppcommentaire (request $request){

        $selectedid =  $request->data_rem;

             try {
                $newInsert = NoteOpportunites::where([
                                  'id'=>$selectedid,
                              ])->update(['isvisible'=>0,
                            ]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                       return'error';
                  }

    }


    public function removecontrat (request $request){


         $selectedid =  $request->data_rem;


         //retrouver l'opportunite liee au contrat et supprimmer
         $findopp = Contrats::select('commentaire')
            ->where('id',$selectedid)
            ->get()->toArray();


             try {
                $newInsert = Contrats::where([
                                  'id'=>$selectedid,
                              ])->update(['isvisible'=>0,
                            ]);

                 $updatenote = NoteOpportunites::where([
                              'id'=>$findopp[0]['commentaire'],
                          ])->update(['isvisible'=>0,
                        ]);

                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                     // Do whatever you need if the query failed to execute
                     // dd($ex);
                        return'error';
                  }


    }



    public function filter_bordereau_byagent (request $request){

            $datedebut = $request->datedebut;
            $datefin = $request->datefin;
            $selectedagent = $request->selectagent;

            // $listecommerciaux = AgentBackoffices::all()->toArray();

            $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();


            $foundagent = AgentBackoffices::where('id',$selectedagent)->get()->toArray();
            $listeprospection = NoteOpportunites::with('Opportunite','AgentBackoffice')->where([
                  ['resultat', '=', 'gagne'],
                  ['idagentbackoffice', '=', $selectedagent],
                  ])
            // ->whereBetween('created_at',array($datedebut,$datefin))
            ->whereDate('created_at', '>=', $datedebut)
            ->whereDate('created_at', '<=', $datefin)
            ->get()->toArray();

            // dd($foundagent);


            return view('filter_bordereau_byagent', compact("listeprospection",'listecommerciaux','datedebut','datefin','foundagent'));
    }



    public function filter_opportunite_created_online (request $request){

            $datedebut = $request->datedebut;
            $datefin = $request->datefin;
            $selectedagent = $request->selectagent;

            // $listecommerciaux = AgentBackoffices::all()->toArray();

            $listecommerciaux = AgentBackoffices::where('isactive', '1')->orderBy('firstname', 'asc')->get()->toArray();
            $foundagent = AgentBackoffices::where('id',$selectedagent)->get()->toArray();

            $listeprospection = ProspectionClient::with('AgentTerrain','AgentEnligne')->where([
                  ['idagentbackoffice', '=', $selectedagent],
                  ])
            ->whereDate('created_at', '>=', $datedebut)
            ->whereDate('created_at', '<=', $datefin)
            ->get()->toArray();


            // dd($foundagent);
            return view('filter_opportunite_created_online', compact("listeprospection",'listecommerciaux','datedebut','datefin','foundagent'));

    }


    public function check_cg_assurance (request $request){

       $idopportunite =  $request->oppornuite;

       $has_attestation = 'noattestation';
       $has_cartegrise = 'noassurance';

        $opp = ProspectionClient::where('id',$idopportunite)
         ->select('urlcarte_grise_terrain','url_attestationassurance_terrain','urlcarte_grise','url_attestationassurance')
         ->get()->toArray();

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

        return $has_attestation.'*'.$has_cartegrise; 
        
    }

    


    

    



   



   


   


   

   


}

