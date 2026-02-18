<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProspectionClient;
use App\Models\Prospectors;
use App\Models\Administrators;
use App\Models\AgentBackoffices;
use App\Models\AffectationOpportunites;
use App\Models\NoteOpportunites;
use App\Models\PrivilegesAgentBo;
use App\Models\Privileges;
use Illuminate\Support\Facades\Hash;
use App\Models\Contrats;
use App\Models\Assureur;
use Carbon\Carbon;
use Session;
use Storage;
use DB;


class UsersController extends Controller
{
    //

    public function createuser (request $request){

       $lastname = $request->lastname;
       $firstname = $request->firstname;
       $telephone = $request->telephone;
       $isactiv =  $request->isactiv;

       if($isactiv =='on'){ 
          $isactiv =1 ;
        } else { 
          $isactiv = 0;
        }

       $password = Hash::make($request->password);


       $newInsert = Prospectors::create([
                        'lastname'=>$lastname,
                        'firstname'=>$firstname,
                        'phonenumber'=>$telephone,
                        'password'=>$password,
                        'isactive'=>$isactiv??0,
                    ]);

          if(!$newInsert->id){
              return 'Error';
          }else {
              return 'inserted';
        }



    }

    public function create_online_operator (request $request){

       $lastname  = $request->lastname;
       $firstname = $request->firstname;
       $telephone = $request->telephone;
       $privilege = $request->privilege;
       $isactiv =  $request->isactiv;


       // dd($privilege);


       $login = $request->login;
       $password = Hash::make($request->adminpwd);
       $newInsert = AgentBackoffices::create([
                        'lastname'=>$lastname,
                        'firstname'=>$firstname,
                        'PhoneNumber'=>$telephone,
                        'login'=>$login,
                        'privilege'=>$privilege,
                        'password'=>$password,
                        'isactive'=>1,
                        'donebyuser'=>1,
                    ]);

          if(!$newInsert->id){
              return 'Error';
          }else {
              return 'inserted';
        }
    }




    public function edit_online_operator ( $idop){

      
      $ListePrivileges = Privileges::all();

       $findAgent = AgentBackoffices::where([
                  ['id', '=', $idop],
                  ])->first()->toArray();



         $agentbackofficeid= $idop;
          $findprivileges = PrivilegesAgentBo::where([
                  ['id_user', '=', $agentbackofficeid],
                  ['statut', '=', 1],
                  ])->select('id_priv')->get()->toArray();


          $user_list_priv= array();
          foreach ($findprivileges as $findprivileges_el) {
            // code...
            $user_list_priv[]= $findprivileges_el['id_priv'];
          }


      // dd($findAgent);
      return view('edit_operateur_enligne',compact('findAgent','ListePrivileges','user_list_priv'));
    }


    public function edit_terrain_operator ( $idop){


       $findAgent = Prospectors::where([
                  ['id', '=', $idop],
                  ])->first()->toArray();


   
      return view('edit_operateur_terrain',compact('findAgent'));
    }



    public function liste_agent_enligne (Request $request){

    $listecommerciaux = AgentBackoffices::all()->toArray();
    // dd($listeprospection);
    return view('liste_commerciaux', compact('listecommerciaux'));

   }

   public function liste_agent_terrain (Request $request){

    $listeagenterrain = Prospectors::all()->toArray();
    // dd($listeprospection);
    return view('liste_agent_terrain', compact('listeagenterrain'));

   }


   public function liste_assureur (Request $request){

    $liste_assureur = Assureur::all()->toArray();
    return view('liste_assureur', compact('liste_assureur'));

   }


   



   public function create_agent_enligne(request $request){

      return view('create_operateur_enligne');
    }

   public function create_assureur(request $request){

      return view('create_assureur');
    }



   public function loginadmin ( request $request ){

        $lastname = $request->adminusername;
        $password = $request->adminpwd;

        // dd($password);

        $findAdministrator = AgentBackoffices::where([
                  ['login', '=', $lastname],
                  ['isactive', '=', 1],
                  ])->first();

        // dd($findAdministrator);
        if ($findAdministrator) {
          // code...
       
        $verif = Hash::check($password, $findAdministrator->password);
        // dd($verif);
        if ($verif) {


          //mettre a jour le statut logout a false  

            try {
                $newInsert = AgentBackoffices::where([
                                  'login'=>$lastname,
                              ])->update(['logout'=>false,
                                ]);
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                       return'error';
                }
          $arrayconversion =$findAdministrator->toArray();
          $agentbackofficeid= $arrayconversion['id'];
          $findprivileges = PrivilegesAgentBo::where([
                  ['id_user', '=', $agentbackofficeid],
                  ['statut', '=', 1],
                  ])->select('id_priv')->get()->toArray();


          $privarray= array();
          foreach ($findprivileges as $findprivileges_el) {
            // code...
            $privarray[]= $findprivileges_el['id_priv'];
          }


          Session::put('userprivilege_list',$privarray);
         
           

          $foundlogin= $arrayconversion['login'];
          $userpriv= $arrayconversion['privilege'];
          $userlastname= $arrayconversion['lastname'];
          $firstname= $arrayconversion['firstname'];
          $PhoneNumber= $arrayconversion['PhoneNumber'];
          $profileImg= $arrayconversion['profile_picture'];
          // $foundrole= $finduser[0]['role'];
          Session::put('agentbackofficeid',$agentbackofficeid);
          Session::put('userlogin',$foundlogin);
          Session::put('userfirstname',$firstname);
          Session::put('userlastname',$userlastname);
          Session::put('userprivilege',$userpriv);
          Session::put('PhoneNumber',$PhoneNumber);
          Session::put('profileImg',$profileImg);


          //rediriger en fonction du privilege



             if  (in_array(13, $privarray)) 
             //opportunite_admin
              return 'opportunite_admin';
      

             if(in_array(12, $privarray)) 
             //opportunite_admin
              return 'liste_contrat_byagent';
           


            if(in_array(10, $privarray)) 
             //
            return 'opportunite_agent';


           if(in_array(16, $privarray)) 
             //
            return 'retrouver_opportunite';


          if(in_array(17, $privarray)) 
             //
            return 'qualification_agent_terrain';
         

          // if ($userpriv !='niveau1' ) {
          //   // code...
          //    return 'existsub';
          // }else
          //  return 'exist';
         
       }else
        return 'notexist';
      }else
       return 'notexist';


   }

    public function logout(request $request){
     $request->session()->flush();
      return redirect('/login');
   }


   public function checksession(request $request){

      if(Session::has('agentbackofficeid')){
       return 'yes';
      }
      else return 'no';

   }

   public function updateprofile (request $request){



   $firstname =  $request->firstname;
   $lastname =      $request->lastname;
   $phonenumber =    $request->phonenumber;
   $login =    $request->login;



    $dir="test/";
         $imgattesation = $request->file('profile_picture');
         $url_profile_picture ='';
      

      
        if ($request->hasFile('profile_picture')) {
                $imageAttestationName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $imgattesation->getClientOriginalExtension();
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->put($dir.$imageAttestationName, file_get_contents($imgattesation));
                $url_profile_picture = '/storage/test/'.$imageAttestationName;
        }else{
             // return response()->json(['message' => trans('/storage/test/'.'def.png')], 200);
            $typeError[]=1;
            // return response()->json(['message' => 'failed to upload attestation'], 400);
        } 
       // return response()->json(['message' => trans('/storage/test/'.$imageAttestationName)], 200);



      
       try {
                $newInsert = AgentBackoffices::where([
                                  'id'=>Session::get('agentbackofficeid'),
                              ])->update(['firstname'=>$firstname,
                                'PhoneNumber'=>$phonenumber,
                                'login'=>$login,
                                'lastname'=>$lastname,
                                'profile_picture'=>$url_profile_picture,
                                ]);
                  Session::put('userlogin',$login);
                  Session::put('userfirstname',$firstname);
                  Session::put('userlastname',$lastname);
                  Session::put('PhoneNumber',$phonenumber);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                       return'error';
                }


   }


   public function updatepassword (request $request){

       $oldpwd =  $request->oldpasswordInput;
       $newpwd =      $request->newpasswordInput;
       $confirmpwd =    $request->confirmpasswordInput;


       $findAdministrator = AgentBackoffices::where([
                  ['login', '=', Session::get('userlogin')],
                  ['isactive', '=', 1],
                  ])->first();



       if ($findAdministrator) {
         // code...
          $verif = Hash::check($oldpwd, $findAdministrator->password);
          // dd($verif);
          if ($verif) {

             $password = Hash::make($newpwd);

              try {
                // $newInsert = AgentBackoffices::where(
                //   ['login', '=', Session::get('userlogin')])
                //   ->update(['password'=>$password,
                //   ]);

                   $newInsert = AgentBackoffices::where([
                                 'login'=>Session::get('userlogin'),
                              ])->update(['password'=>$password,
                                ]);

                  return'password updated';

                  }
                catch (\Illuminate\Database\QueryException $ex) {
                       return $ex;
                }


          }else
          return 'wrong password';


       }



   }


   public function updateuserbasics(request $request){


    $lastname =  $request->lastname;
    $firstname =  $request->firstname;
    $phonenumber =  $request->phonenumber;
    $login =  $request->login;
    $isactiv =  $request->isactiv;


    $selecteduser =  $request->selecteduser;

    if($isactiv =='on' || $isactiv =='1'){ 
          $isactiv =1 ;
        } else { 
          $isactiv = 0;

          //deconnecter l'utilateur si on desactive son compte 

           try {
                $newInsert = AgentBackoffices::where([
                                 'id'=>$selecteduser,
                              ])->update(['logout'=>true,
                                ]);
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                       return'error';
                }



        }
    
    // $password =  $request->password;
    $privilege =  $request->privilege;
    $password = Hash::make($request->password);

    

   if ($request->password == ''|| $request->password ==null) {
     // code...

      try {
                $newInsert = AgentBackoffices::where([
                                  'id'=>$selecteduser,
                              ])->update([
                                'firstname'=>$firstname,
                                'lastname'=>$lastname,
                                'PhoneNumber'=>$phonenumber,
                                'login'=>$login,
                                'isactive'=>$isactiv??0,
                                'privilege'=>$privilege,
                                
                                ]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {

                    return $ex;
                       return'error';
                }

   }else{

     $password = Hash::make($request->password);

      try {
                $newInsert = AgentBackoffices::where([
                                 'id'=>$selecteduser,
                              ])->update(['logout'=>true,
                                ]);
                  }
                catch (\Illuminate\Database\QueryException $ex) {
                       return'error';
                }

      try {
                $newInsert = AgentBackoffices::where([
                                  'id'=>$selecteduser,
                              ])->update([
                                'firstname'=>$firstname,
                                'lastname'=>$lastname,
                                'PhoneNumber'=>$phonenumber,
                                'login'=>$login,
                                'password'=>$password,
                                'isactive'=>$isactiv??0,
                                'privilege'=>$privilege,
                                ]);
                  return'pwdedited';
                  }
                catch (\Illuminate\Database\QueryException $ex) {

                  // dd($ex);
                       return'error';
                }
              }


   }


   public function updateuserpriv (request $request){


      // dd($request->privilege_user);

      $user_id=  $request->user_id ;

     // dd($user_id);
      $delete=PrivilegesAgentBo::where('id_user','=',$user_id)->delete(); 

      $selectedproduct = array();

                foreach ($request->privilege_user as $privilege_el) {
                    // code...
                    if($privilege_el != ''){
                        $selectedproduct[] = [
                           "id_user"=> $user_id,
                           "id_priv"=> $privilege_el,
                           "statut"=> 1,
                           "created_at" => \Carbon\Carbon::now()->toDateTimeString(),
                           "updated_at" =>\Carbon\Carbon::now()->toDateTimeString()
                        ];
                    }
                }
                 

    $PrivInsert = PrivilegesAgentBo::insert($selectedproduct);
    if ($PrivInsert) {
      return 'succes';
    }


   }


   public function updateuserterrain(request $request){


    $lastname =  $request->lastname;
    $firstname =  $request->firstname;
    $phonenumber =  $request->phonenumber;
    $isactiv =  $request->isactiv;

  

    if($isactiv =='on'){ 
          $isactiv =1 ;
        }

     if($isactiv =='off'){ 
          $isactiv = 0;
        }

    
    // $password =  $request->password;
    $password = Hash::make($request->password);
    $selecteduser =  $request->selecteduser;

   if ($request->password == ''|| $request->password ==null) {
     // code...
      // dd($isactiv);
      try {
                $newInsert = Prospectors::where([
                                  'id'=>$selecteduser,
                              ])->update([
                                'firstname'=>$firstname,
                                'lastname'=>$lastname,
                                'phonenumber'=>$phonenumber,
                                'isactive'=>$isactiv??0,
                                
                                ]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {

                   // dd($ex);
                       return'error';
                }

   }else{
     
     $password = Hash::make($request->password);

      try {
                $newInsert = Prospectors::where([
                                  'id'=>$selecteduser,
                              ])->update([
                                'firstname'=>$firstname,
                                'lastname'=>$lastname,
                                'phonenumber'=>$phonenumber,
                                'password'=>$password,
                                'isactive'=>$isactiv??0,
                                ]);
                  return'inserted';
                  }
                catch (\Illuminate\Database\QueryException $ex) {

                   //dd($ex);
                       return'error';
                }
              }


   }

   


   public function updatepwd(request $request){

   } 



   public function affectationbyagent(request $request){


    $affectation_par_agent = NoteOpportunites::with('AgentBackoffice')
          ->where([['resultat', '=', 'gagne']])
          ->groupBy('idagentbackoffice')
          ->selectRaw('idagentbackoffice, count(*) as nbre_opport_gagne, sum(primenet) as suma, sum(primettc) as sumb')
          
          // ->orderBy('idagentbackoffice', 'DESC')
          ->get()->toArray();

          // dd($affectation_par_agent);

   }


   public function bordereaux_contrat_condense (request $request){

    // bordereaux_contrat_condense

    $datedebut = date('Y-m-d'); //null;
    $datefin = null;



    // $statopp = NoteOpportunites::whereDate('created_at', '=', $datejour)
    //       ->where(function ($query) {
    //         $query->where('observation', 'NOT LIKE', "%reaff%")
    //               ->orWhereNull('observation');
    //     })

 // $query->where('observation', 'NOT LIKE', "%reaff%")
 //                  ->orWhereNull('observation');
          $contrat_condens = NoteOpportunites::with('AgentBackoffice.Affectations')
          ->select('idagentbackoffice')
          ->whereDate('created_at', '=', $datedebut)
          ->where([
            ['isvisible', '=', 1],
            // ['observation', 'NOT LIKE', "%reaff%"]
          ])
           ->where(function ($query) {
            $query->where('observation', 'NOT LIKE', "%reaff%")
                  ->orWhereNull('observation');
        })
          ->addSelect(DB::raw('count(distinct idopportunite) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as nbre_opport_gagne'))
         // ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as nbre_opport_gagne'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as sumprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as sumprimettc'))
           ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%RN%") then 1 else 0 end) as nombre_contrat_rn'))
          ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%AN%") then 1 else 0 end) as nombre_contrat_an'))
          
          ->groupBy('idagentbackoffice')
          ->get()->toArray();


        //  dd($contrat_condens);

    return view('bordereaux_contrat_condense', compact('contrat_condens','datedebut','datefin'));
   }




   public function bordereaux_opp_agent_terrain (request $request){

    // bordereaux_contrat_condense

    $datedebut = Date('Y-m-d') ;
    $datefin = null;

          $listeprospection = ProspectionClient::with('AgentTerrain','commentaires')
          ->select('realiserpar')
          ->addSelect(DB::raw('count(*) as opportunite_remontes'))
          ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" then 1 else 0 end ) as nbrecartegrise'))
          ->addSelect(DB::raw('sum(case when url_attestationassurance_terrain != "" then 1 else 0 end ) as nbreattestation'))
         //->addSelect(DB::raw('sum(case when count(distinct telephone) = 1 then 1 else 0 end ) as nbredoublons'))

          ->addSelect(DB::raw('count(telephone) - count(DISTINCT telephone) as nbredoublons'))

          // case when count(distinct color) = 1 then 'yes' else 'no' end as blackOnly,
          ->where('realiserpar', '!=', null)
          ->whereDate('created_at', '=', $datedebut)
          ->groupBy('realiserpar')
          ->get()->toArray();


    return view('bordereaux_agents_terrain', compact('listeprospection','datedebut','datefin'));
   }

   public function filter_bordereau_ag_terrain (request $request){


    $datedebut = $request->datedebut;
        $datefin = $request->datefin;

          $listeprospection = ProspectionClient::with('AgentTerrain','commentaires')
          ->select('realiserpar')
          ->addSelect(DB::raw('count(*) as opportunite_remontes'))
          ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" then 1 else 0 end ) as nbrecartegrise'))
          ->addSelect(DB::raw('sum(case when url_attestationassurance_terrain != "" then 1 else 0 end ) as nbreattestation'))
         //->addSelect(DB::raw('sum(case when count(distinct telephone) = 1 then 1 else 0 end ) as nbredoublons'))

          ->addSelect(DB::raw('count(telephone) - count(DISTINCT telephone) as nbredoublons'))

          // case when count(distinct color) = 1 then 'yes' else 'no' end as blackOnly,
          ->where('realiserpar', '!=', null)
          ->whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
          ->groupBy('realiserpar')
          ->get()->toArray();

          return view('bordereaux_agents_terrain', compact('listeprospection','datedebut','datefin'));

   }

   public function qualification_agent_terrain (request $request){



    $datedebut = Date('Y-m-d') ;// null;
    $datefin = null;

          $listeprospection = ProspectionClient::with('AgentTerrain','commentaires')
          ->select('realiserpar')
          ->addSelect(DB::raw('COUNT(DISTINCT DATE(created_at)) as days'))
          ->addSelect(DB::raw('count(*) as opportunite_remontes'))
          ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" then 1 else 0 end ) as nbrecartegrise'))
          ->addSelect(DB::raw('sum(case when url_attestationassurance_terrain != "" then 1 else 0 end ) as nbreattestation'))

         ->addSelect(DB::raw('sum(case when statut_discours = "OK" then 1 else 0 end ) as nbrediscoursok'))
         ->addSelect(DB::raw('sum(case when statut_discours = "NOK" then 1 else 0 end ) as nbrediscoursnok'))
         ->addSelect(DB::raw('sum(case when statut_carte_grise = "NOK" then 1 else 0 end ) as nbredcgnok'))
         ->addSelect(DB::raw('sum(case when statut_carte_grise = "OK" then 1 else 0 end ) as nbredcgok'))
         ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" AND statut_carte_grise IS NULL then 1 else 0 end ) as nbredcgnoflag')) 
         //->addSelect(DB::raw('sum(case when count(distinct telephone) = 1 then 1 else 0 end ) as nbredoublons'))

         ->addSelect(DB::raw('count(telephone) - count(DISTINCT telephone) as nbredoublons'))

          // case when count(distinct color) = 1 then 'yes' else 'no' end as blackOnly,
          ->where([
            ['realiserpar', '!=', null],
          ])
          ->whereDate('created_at', '=', $datedebut)
          ->groupBy('realiserpar')
          ->get()->toArray();

          


          //opp perdue agent terrain
             $listeprospectionperdu = NoteOpportunites::whereIn('id', function($query) {
             $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
              })->where([
                     ['resultat', '=', 'perdu']   
                      ])
              ->select('idopportunite')
              ->get()->toArray();


             $listeprospection_perdu_agterrain = ProspectionClient::whereIn('id',$listeprospectionperdu)
             ->select('realiserpar')
             ->where('realiserpar', '!=',null)
             ->whereDate('created_at', '=', $datedebut)
             ->addSelect(DB::raw('count(*) as opportunite_perdu'))
             ->groupBy('realiserpar')
             ->get()->toArray();


            //opp horcicle agent terrain
           $listeprospectionhorcile = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
            })->where([
                   ['resultat', '=', 'horscible']   
                    ])
            ->select('idopportunite')
            ->get()->toArray();


           $listeprospection_horcible_agterrain = ProspectionClient::whereIn('id',$listeprospectionhorcile)
           ->select('realiserpar')
           ->where('realiserpar', '!=',null)
           ->whereDate('created_at', '=', $datedebut)
           ->addSelect(DB::raw('count(*) as opportunite_horcible'))
           ->groupBy('realiserpar')
           ->get()->toArray();




    return view('qualif_agent_terrain', compact('listeprospection','datedebut','datefin','listeprospection_perdu_agterrain','listeprospection_horcible_agterrain'));
   }


   public function filter_qualif_ag_terrain (request $request){


    $datedebut = $request->datedebut;
    $datefin = $request->datefin;

          $listeprospection = ProspectionClient::with('AgentTerrain','commentaires')
          ->select('realiserpar')
          ->addSelect(DB::raw('COUNT(DISTINCT DATE(created_at)) as days'))
          ->addSelect(DB::raw('count(*) as opportunite_remontes'))
          ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" then 1 else 0 end ) as nbrecartegrise'))
          ->addSelect(DB::raw('sum(case when url_attestationassurance_terrain != "" then 1 else 0 end ) as nbreattestation'))

         ->addSelect(DB::raw('sum(case when statut_discours = "OK" then 1 else 0 end ) as nbrediscoursok'))
         ->addSelect(DB::raw('sum(case when statut_discours = "NOK" then 1 else 0 end ) as nbrediscoursnok'))
         ->addSelect(DB::raw('sum(case when statut_carte_grise = "NOK" then 1 else 0 end ) as nbredcgnok'))
         ->addSelect(DB::raw('sum(case when statut_carte_grise = "OK" then 1 else 0 end ) as nbredcgok'))
         ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" AND statut_carte_grise IS NULL then 1 else 0 end ) as nbredcgnoflag'))
         //->addSelect(DB::raw('sum(case when count(distinct telephone) = 1 then 1 else 0 end ) as nbredoublons'))

         ->addSelect(DB::raw('count(telephone) - count(DISTINCT telephone) as nbredoublons'))

          // case when count(distinct color) = 1 then 'yes' else 'no' end as blackOnly,
          ->where([
            ['realiserpar', '!=', null],
          ])
         ->whereDate('created_at', '>=', $datedebut)
         ->whereDate('created_at', '<=', $datefin)
          ->groupBy('realiserpar')
          ->get()->toArray();

          // dd($listeprospection);

          //opp perdue agent terrain
             $listeprospectionperdu = NoteOpportunites::whereIn('id', function($query) {
             $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
              })->where([
                     ['resultat', '=', 'perdu']   
                      ])
              ->select('idopportunite')
              ->get()->toArray();


             $listeprospection_perdu_agterrain = ProspectionClient::whereIn('id',$listeprospectionperdu)
             ->select('realiserpar')
             ->where('realiserpar', '!=',null)
             ->whereDate('created_at', '>=', $datedebut)
             ->whereDate('created_at', '<=', $datefin)
             ->addSelect(DB::raw('count(*) as opportunite_perdu'))
             ->groupBy('realiserpar')
             ->get()->toArray();

           //
             //dd($listeprospection_perdu_agterrain);


            //opp horcicle agent terrain
           $listeprospectionhorcile = NoteOpportunites::whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
            })->where([
                   ['resultat', '=', 'horscible']   
                    ])
            ->select('idopportunite')
            ->get()->toArray();


           $listeprospection_horcible_agterrain = ProspectionClient::whereIn('id',$listeprospectionhorcile)
           ->select('realiserpar')
           ->where('realiserpar', '!=',null)
           ->whereDate('created_at', '>=', $datedebut)
           ->whereDate('created_at', '<=', $datefin)
           ->addSelect(DB::raw('count(*) as opportunite_horcible'))
           ->groupBy('realiserpar')
           ->get()->toArray();

    return view('qualif_agent_terrain', compact('listeprospection','datedebut','datefin','listeprospection_perdu_agterrain','listeprospection_horcible_agterrain'));


   }


   public function details_remontes_agent ($idop){

        $datedebut = null;
        $datefin = null;
        $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->where([
                  ['realiserpar', '=', $idop],
                  ])
            ->get()->toArray();

            // dd($listeprospection);
            
    return view('detail_remontee_agent_terrain', compact('listeprospection','datedebut','datefin'));
   }



   public function details_remontes_agent_date ($idop,$datedebut ,$datefin){

        // $datedebut = null;
        // $datefin = null;
        $listeprospection = ProspectionClient::with('AgentTerrain','affectation')->where([
                  ['realiserpar', '=', $idop],
                  ])->whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
            ->get()->toArray();

            // dd($listeprospection);
            
    return view('detail_remontee_agent_terrain', compact('listeprospection','datedebut','datefin'));
   }


   


   public function bordereaux_contrat_condense_detail ( $idop){

    // bordereaux_contrat_condense

    $datedebut = null;
    $datefin = null;

    $contrat_condens = NoteOpportunites::with('AgentBackoffice','Opportunite')
          ->where([
            ['resultat', '=', 'gagne'],
            ['idagentbackoffice', '=', $idop],
            ['isvisible', '=', 1]
          ]);


    return view('bordereaux_contrat_condense_detail', compact('contrat_condens','datedebut','datefin'));
   }


   public function bordereaux_contrat_condense_detail_date ( $idop, $datedebut ,$datefin){

    // bordereaux_contrat_condense

  

    $contrat_condens = NoteOpportunites::with('AgentBackoffice','Opportunite')
          ->where([
            ['isvisible', '=', 1],
            ['resultat', '=', 'gagne'],
            ['idagentbackoffice', '=', $idop]
          ]) ->whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
          
          ->get()->toArray();

          // dd($contrat_condens);

        

         $foundamin = AgentBackoffices::where([
                  ['id', '=', $idop],
                  ])->first()->toArray();

         // dd($foundamin);

    return view('bordereaux_contrat_condense_detail', compact('foundamin','contrat_condens','datedebut','datefin'));
   }


   public function details_operations_traitees_agent ($idop, $datedebut,$datefin){



 
    
        $listeopportunite_tratee = NoteOpportunites::with('AgentBackoffice','Opportunite')->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
            })
          ->where([
            ['isvisible', '=', 1],
            ['idagentbackoffice', '=', $idop],
            // ['observation', 'not like', '%reaff%'], //pour retirer les reaffeactation
          ])
          ->where(function ($query) {
            $query->where('observation', 'NOT LIKE', "%reaff%")
                  ->orWhereNull('observation');
        })
          ->whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
          ->get()->toArray();

          // dd($listeopportunite_tratee);

      return view('bordereaux_detail_operateur', compact('listeopportunite_tratee','datedebut','datefin'));

   }

   

   public function filter_contrat_condenses (request $request){


    
    $periodecontrat = $request->periodecontrat;
    $datedebut = $request->datedebut;
        $datefin = $request->datefin;

        
        
          if ($periodecontrat !='tous') {
            // code...
          
          $contrat_condens = NoteOpportunites::with('AgentBackoffice.Affectations')
          ->select('idagentbackoffice')
          ->whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
          ->where([
            ['isvisible', '=', 1],
            ['periode_soucription', '=', $periodecontrat],
          ])
          ->addSelect(DB::raw('count(distinct idopportunite) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as nbre_opport_gagne'))
           ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%RN%") then 1 else 0 end) as nombre_contrat_rn'))
          ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%AN%") then 1 else 0 end) as nombre_contrat_an'))
         // ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as nbre_opport_gagne'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as sumprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as sumprimettc'))
          
          ->groupBy('idagentbackoffice')
          ->get()->toArray();
        }else{
          $contrat_condens = NoteOpportunites::with('AgentBackoffice.Affectations')
          ->select('idagentbackoffice')
          ->whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
          ->where([
            ['isvisible', '=', 1],
          ])
          ->addSelect(DB::raw('count(distinct idopportunite) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as nbre_opport_gagne'))
           ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%RN%") then 1 else 0 end) as nombre_contrat_rn'))
          ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%AN%") then 1 else 0 end) as nombre_contrat_an'))
         // ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as nbre_opport_gagne'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as sumprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as sumprimettc'))
          
          ->groupBy('idagentbackoffice')
          ->get()->toArray();
        }

    return view('bordereaux_contrat_condense', compact('contrat_condens','datedebut','datefin','periodecontrat'));
   }




   public function bordereaux_rapport_operateur (request $request){

     
    $datedebut = date('Y-m-d');
    $datefin = null;



    // $nombre_contrat_rn = Contrats::with('commentaire.AgentBackoffice')->where([
    //           ['numpolice', 'LIKE', "%RN%"],
    //            ['isvisible', '=', 1],
    //         ])->whereDate('created_at', '=', $datedebut)
    //        ->get()->toArray();
    //       dd($nombre_contrat_rn);

            // $nombre_contrat_an = Contrats::with('commentaire.AgentBackoffice')->where([
            //   ['numpolice', 'LIKE', "%AN%"],
            //    ['isvisible', '=', 1],
            // ])->whereDate('created_at', '=', $datejour)
            // ->count();
    
  // $listeopportunite_tratee = NoteOpportunites::with('AgentBackoffice','Opportunite')->whereIn('id', function($query) {
  //          $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
  //           })

    // $contrat_condens = NoteOpportunites::with(['AgentBackoffice.Affectations' => function ($query) use ($datedebut) {
    //     $query->whereDate('created_at', '=', $datedebut);
    // }])

     // ->where(function ($query) {
     //        $query->where('observation', 'NOT LIKE', "%reaff%")
     //              ->orWhereNull('observation');
     //    })

    

     $contrat_condens = NoteOpportunites::with(['AgentBackoffice.Affectations' => function ($query) use ($datedebut) {
        $query->whereDate('created_at', '=', $datedebut);
    },'Opportunite'])->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
            })
          ->select('idagentbackoffice')
          ->whereDate('created_at', '=', $datedebut)
          // ->orWhereNull('observation')

          ->addSelect(DB::raw('count(distinct (case when observation NOT LIKE "%reaff%" OR observation IS NULL AND isvisible="1" then idopportunite end)) as totaltraites'))
          ->addSelect(DB::raw('count(distinct (case when observation LIKE "%reaff%" then idopportunite end)) as totalreaff'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" or resultat = "perdu_rn" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" or resultat = "reporte_rn" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat LIKE "%pour%" AND (observation NOT LIKE "%reaff%" OR observation IS NULL) then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "rdvsouscription" or resultat = "rdvsouscription_rn" then 1 else 0 end) as totalrdvsous'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" or resultat = "horscible_rn" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%RN%") then 1 else 0 end) as nombre_contrat_rn'))
          ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%AN%") then 1 else 0 end) as nombre_contrat_an'))
          ->groupBy('idagentbackoffice')
          ->get()->toArray();

             // dd($contrat_condens);


    return view('bordereau_rapport_operateur', compact('contrat_condens','datedebut','datefin'));
   }


   public function filter_rapport_operateur (request $request ){


    $datedebut = $request->datedebut;
    $datefin = $request->datefin;

     $contrat_condens = NoteOpportunites::with(['AgentBackoffice.Affectations' => function ($query) use ($datedebut,$datefin) {
        $query->whereDate('created_at', '=', $datedebut)
        ->whereDate('created_at', '<=', $datefin);
    },'Opportunite'])->whereIn('id', function($query) {
           $query->from('note_opportunites')->groupBy('idopportunite')->selectRaw('MAX(id)');
            })

    // $contrat_condens = NoteOpportunites::with(['AgentBackoffice.Affectations' => function ($query) use ($datedebut, $datefin) {
    //     $query->whereDate('created_at', '>=', $datedebut)
    //     ->whereDate('created_at', '<=', $datefin);
    // }])

          ->select('idagentbackoffice')
          ->whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
          // ->addSelect(DB::raw('count(distinct idopportunite) as totaltraites'))
           ->addSelect(DB::raw('count(distinct (case when observation NOT LIKE "%reaff%" OR observation IS NULL AND isvisible="1" then idopportunite end)) as totaltraites'))
          ->addSelect(DB::raw('count(distinct (case when observation LIKE "%reaff%" then idopportunite end)) as totalreaff'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" or resultat = "perdu_rn" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" or resultat = "reporte_rn" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat LIKE "%pour%" AND (observation NOT LIKE "%reaff%" OR observation IS NULL) then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "rdvsouscription" or resultat = "rdvsouscription_rn" then 1 else 0 end) as totalrdvsous'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" or resultat = "horscible_rn" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
           ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%RN%") then 1 else 0 end) as nombre_contrat_rn'))
          ->addSelect(DB::raw('sum(case when id IN (SELECT commentaire FROM contrats WHERE numpolice LIKE "%AN%") then 1 else 0 end) as nombre_contrat_an'))
          ->groupBy('idagentbackoffice')
          ->get()->toArray();


          // dd($contrat_condens);

    return view('bordereau_rapport_operateur', compact('contrat_condens','datedebut','datefin'));

   }


   public function statjournalier (request $request){

    $datedebut =null;
    $datefin = null;
     $datejour = date('Y-m-d');
   

    $contrat_condens = NoteOpportunites::whereDate('created_at', '=', $datejour)
          ->addSelect(DB::raw('count(*) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat = "poursuivre" then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))

          ->get()->toArray();

      //    yesterday;


           $lastWeeksameDay=date('Y-m-d',strtotime("-1 days"));
           $contrat_condensLWSD = NoteOpportunites::whereDate('created_at', '=', $lastWeeksameDay)
          ->addSelect(DB::raw('count(*) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat = "poursuivre" then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))

          ->get()->toArray();

    return view('stats_journalier', compact('contrat_condens','contrat_condensLWSD','lastWeeksameDay','datedebut','datefin'));

   }



   public function stat_diagram(request $request){

    $datedebut =null;
    $datefin = null;
    $datejour = date('Y-m-d');

    $Yesterday=date('Y-m-d',strtotime("-1 days"));


    //  dd($Yesterday);


    //Oppotunite remontées

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

     $nombre_opp_remont = ProspectionClient::with('AgentTerrain','affectation')->doesntHave('commentaires')->whereNotIn('telephone', $filter_Array)
    ->where([
        ['idagentbackoffice', '=', null],
        ['isvisible', '=', 1],
    ])->whereDate('created_at','=',$Yesterday)
    ->count();


    //caculs sur les opportunitées
    $statopp = NoteOpportunites::whereDate('created_at', '=', $datejour)
          ->where(function ($query) {
            $query->where('observation', 'NOT LIKE', "%reaff%")
                  ->orWhereNull('observation');
        })
          ->addSelect(DB::raw('count(*) as totaltraites')) 
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat = "poursuivre" then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          ->addSelect(DB::raw('sum(case when resultat = "rdvsouscription" then 1 else 0 end) as totalrdvsouscription'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))
          ->get()->toArray();


     $statopp_antecedent = NoteOpportunites::whereDate('created_at', '=', $Yesterday)
          ->addSelect(DB::raw('count(*) as totaltraites'))
           ->where(function ($query) {
            $query->where('observation', 'NOT LIKE', "%reaff%")
                  ->orWhereNull('observation');
        })
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat = "poursuivre" then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))
          ->get()->toArray();



    //performances conseillées

          $stat_conseilles = NoteOpportunites::with('AgentBackoffice.Affectations')
          ->select('idagentbackoffice')
           ->where(function ($query) {
            $query->where('observation', 'NOT LIKE', "%reaff%")
                  ->orWhereNull('observation');
        })
           ->whereDate('created_at', '=', $datejour)
          ->where('isvisible', '=', 1)
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as sumprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as sumprimettc'))
          ->groupBy('idagentbackoffice')
          ->orderBy('sumprimettc', 'DESC')->limit(10)
          ->get()->toArray();

        //totalopp par mois

          $currentYear= date('Y');
          $totalbymonth = NoteOpportunites::where('isvisible', '=', 1)
         // ->select(DB::raw('MONTH(created_at) AS month'))
          ->select(DB::raw('EXTRACT(MONTH FROM created_at) AS month'))
          ->whereYear('created_at', '=', $currentYear)
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          // ->groupBy(DB::raw('MONTH(created_at)'))
          ->groupBy(DB::raw('month'))
          ->get()->toArray();


       //totalopp annuel

          $currentYear= date('Y');
          $totalbyYear = NoteOpportunites::where('isvisible', '=', 1)
          ->whereYear('created_at', '=', $currentYear)
          ->addSelect(DB::raw('count(*) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->groupBy(DB::raw('YEAR(created_at)'))
          ->get()->toArray();


        //contrats AN et RN

            $nombre_contrat_rn = Contrats::where([
              ['numpolice', 'LIKE', "%RN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at', '=', $datejour)
           ->count();

            $nombre_contrat_an = Contrats::where([
              ['numpolice', 'LIKE', "%AN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at', '=', $datejour)
            ->count();

        //carte grise et attestation
           $carte_attest = ProspectionClient::with('AgentTerrain','commentaires')
          // ->addSelect(DB::raw('count(*) as opportunite_remontes'))
          ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" then 1 else 0 end ) as nbrecartegrise'))
          ->addSelect(DB::raw('sum(case when url_attestationassurance_terrain != "" then 1 else 0 end ) as nbreattestation'))
          ->whereDate('created_at', '=', $datejour)
          ->get()->toArray();




            $nombre_contrat_rnYest = Contrats::where([
              ['numpolice', 'LIKE', "%RN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at', '=', $Yesterday)
           ->count();

            $nombre_contrat_anYest = Contrats::where([
              ['numpolice', 'LIKE', "%AN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at', '=', $Yesterday)
            ->count();

        //carte grise et attestation
           $carte_attestYest = ProspectionClient::with('AgentTerrain','commentaires')
          // ->addSelect(DB::raw('count(*) as opportunite_remontes'))
          ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" then 1 else 0 end ) as nbrecartegrise'))
          ->addSelect(DB::raw('sum(case when url_attestationassurance_terrain != "" then 1 else 0 end ) as nbreattestation'))
          ->whereDate('created_at', '=', $Yesterday)
          ->get()->toArray();


     return view('stat_diagram',compact('statopp','statopp_antecedent','nombre_opp_remont','stat_conseilles','totalbymonth','totalbyYear','nombre_contrat_an','nombre_contrat_rn','carte_attestYest','nombre_contrat_anYest','nombre_contrat_rnYest','carte_attest','datedebut','datefin'));
   }



   public function stat_diagram_cumul(request $request){

    $datedebut =null;
    $datefin = null;
    $datejour = date('Y-m-d');

    $Yesterday=date('Y-m-d',strtotime("-1 days"));


    //  dd($Yesterday);


    //Oppotunite remontées

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

     $nombre_opp_remont = ProspectionClient::with('AgentTerrain','affectation')->doesntHave('commentaires')->whereNotIn('telephone', $filter_Array)
    ->where([
        ['idagentbackoffice', '=', null],
        ['isvisible', '=', 1],
    ])->whereDate('created_at','=',$Yesterday)
    ->count();


    //caculs sur les opportunitées
    $statopp = NoteOpportunites::whereDate('created_at', '=', $datejour)
          ->where(function ($query) {
            $query->where('observation', 'NOT LIKE', "%reaff%")
                  ->orWhereNull('observation');
        })
          ->addSelect(DB::raw('count(*) as totaltraites')) 
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat = "poursuivre" then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          ->addSelect(DB::raw('sum(case when resultat = "rdvsouscription" then 1 else 0 end) as totalrdvsouscription'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))
          ->get()->toArray();


     $statopp_antecedent = NoteOpportunites::whereDate('created_at', '=', $Yesterday)
          ->addSelect(DB::raw('count(*) as totaltraites'))
           ->where(function ($query) {
            $query->where('observation', 'NOT LIKE', "%reaff%")
                  ->orWhereNull('observation');
        })
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat = "poursuivre" then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))
          ->get()->toArray();



    //performances conseillées

          $stat_conseilles = NoteOpportunites::with('AgentBackoffice.Affectations')
          ->select('idagentbackoffice')
           ->where(function ($query) {
            $query->where('observation', 'NOT LIKE', "%reaff%")
                  ->orWhereNull('observation');
        })
           ->whereDate('created_at', '=', $datejour)
          ->where('isvisible', '=', 1)
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as sumprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as sumprimettc'))
          ->groupBy('idagentbackoffice')
          ->orderBy('sumprimettc', 'DESC')->limit(10)
          ->get()->toArray();

        //totalopp par mois

          $currentYear= date('Y');
          $totalbymonth = NoteOpportunites::where('isvisible', '=', 1)
         // ->select(DB::raw('MONTH(created_at) AS month'))
          ->select(DB::raw('EXTRACT(MONTH FROM created_at) AS month'))
          ->whereYear('created_at', '=', $currentYear)
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          // ->groupBy(DB::raw('MONTH(created_at)'))
          ->groupBy(DB::raw('month'))
          ->get()->toArray();


       //totalopp annuel

          $currentYear= date('Y');
          $totalbyYear = NoteOpportunites::where('isvisible', '=', 1)
          ->whereYear('created_at', '=', $currentYear)
          ->addSelect(DB::raw('count(*) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->groupBy(DB::raw('YEAR(created_at)'))
          ->get()->toArray();


        //contrats AN et RN

            $nombre_contrat_rn = Contrats::where([
              ['numpolice', 'LIKE', "%RN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at', '=', $datejour)
           ->count();

            $nombre_contrat_an = Contrats::where([
              ['numpolice', 'LIKE', "%AN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at', '=', $datejour)
            ->count();

        //carte grise et attestation
           $carte_attest = ProspectionClient::with('AgentTerrain','commentaires')
          // ->addSelect(DB::raw('count(*) as opportunite_remontes'))
          ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" then 1 else 0 end ) as nbrecartegrise'))
          ->addSelect(DB::raw('sum(case when url_attestationassurance_terrain != "" then 1 else 0 end ) as nbreattestation'))
          ->whereDate('created_at', '=', $datejour)
          ->get()->toArray();




            $nombre_contrat_rnYest = Contrats::where([
              ['numpolice', 'LIKE', "%RN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at', '=', $Yesterday)
           ->count();

            $nombre_contrat_anYest = Contrats::where([
              ['numpolice', 'LIKE', "%AN%"],
               ['isvisible', '=', 1],
            ])->whereDate('created_at', '=', $Yesterday)
            ->count();

        //carte grise et attestation
           $carte_attestYest = ProspectionClient::with('AgentTerrain','commentaires')
          // ->addSelect(DB::raw('count(*) as opportunite_remontes'))
          ->addSelect(DB::raw('sum(case when urlcarte_grise_terrain != "" then 1 else 0 end ) as nbrecartegrise'))
          ->addSelect(DB::raw('sum(case when url_attestationassurance_terrain != "" then 1 else 0 end ) as nbreattestation'))
          ->whereDate('created_at', '=', $Yesterday)
          ->get()->toArray();


     return view('stat_diagram',compact('statopp','statopp_antecedent','nombre_opp_remont','stat_conseilles','totalbymonth','totalbyYear','nombre_contrat_an','nombre_contrat_rn','carte_attestYest','nombre_contrat_anYest','nombre_contrat_rnYest','carte_attest','datedebut','datefin'));
   }


   public function filter_stat (request $request){

    $datedebut = $request->datedebut;
    $datefin = $request->datefin;


    $datedebutPw = $request->datedebut_sortie;
    $datefinPw = $request->datefin_sortie;

    // dd($datedebutPw .' '.$datefinPw );

    $contrat_condens = NoteOpportunites::whereDate('created_at', '>=', $datedebut)
          ->whereDate('created_at', '<=', $datefin)
           ->where('isvisible', '=', 1)
          // ->addSelect(DB::raw('count(*) as totaltraites'))
          ->addSelect(DB::raw('count(distinct idopportunite) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat = "poursuivre" then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          // ->addSelect(DB::raw('sum(primenet) as totalprimenet'))
          // ->addSelect(DB::raw('sum(primettc) as totalprimettc'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))

          ->get()->toArray();



          //previous week momo
          // $lastWeeksameDay=date('Y-m-d',strtotime("-7 days"));
          // $datedebutPw = date('Y-m-d', strtotime($datedebut . ' -7 days')); 
          // $datefinPw = date('Y-m-d', strtotime($datefin . ' -7 days')); 



          $contrat_condensLWSD = NoteOpportunites::whereDate('created_at', '>=', $datedebutPw)
          ->whereDate('created_at', '<=', $datefinPw)
          ->where('isvisible', '=', 1)
          // ->addSelect(DB::raw('count(*) as totaltraites'))
          ->addSelect(DB::raw('count(distinct idopportunite) as totaltraites'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then 1 else 0 end) as totalgagne'))
          ->addSelect(DB::raw('sum(case when resultat = "perdu" then 1 else 0 end) as totalperdue'))
          ->addSelect(DB::raw('sum(case when resultat = "reporte" then 1 else 0 end) as totalreporte'))
          ->addSelect(DB::raw('sum(case when resultat = "poursuivre" then 1 else 0 end) as totalpoursuivre'))
          ->addSelect(DB::raw('sum(case when resultat = "horscible" then 1 else 0 end) as totalhorscible'))
          ->addSelect(DB::raw('sum(case when resultat = "Choisir..." then 1 else 0 end) as totalnondefis'))
          // ->addSelect(DB::raw('sum(primenet) as totalprimenet'))
          // ->addSelect(DB::raw('sum(primettc) as totalprimettc'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primenet end ) as totalprimenet'))
          ->addSelect(DB::raw('sum(case when resultat = "gagne" then primettc end ) as totalprimettc'))

          ->get()->toArray();




    return view('stats_journalier', compact('contrat_condens','contrat_condensLWSD','datedebut','datefin','datedebutPw','datefinPw'));


   }


   public function check_datatable_btn (request $request){

      return 20;
   }


   public function checkmultistep (request $request) {


      return view('checkmultistep');
   }
   


}

