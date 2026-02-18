<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProspectionClientController;
use App\Http\Controllers\UsersController; 
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\GoogleCloudVisionyController;
use Illuminate\Support\Benchmark;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

 if(Session::has('agentbackofficeid')){


   $privs = Session::get('userprivilege_list');
  // dd($privs);


    if  (in_array(13, $privs)) 
     return redirect('/opportunite_admin');

    if(in_array(12, $privs)) 
     return redirect('/liste_contrat_byagent');

    if(in_array(10, $privs)) 
    return redirect('/opportunite_agent');

    // if(Session::has('agentbackofficeid')){
    //   $userpriv =   Session::get('userprivilege');
    //   if ($userpriv != 'niveau1') {
    //       // code...
    //      return redirect('/opportunite_agent');
    //   }else
    //      return redirect('/opportunite_admin');
    }else
    return view('login');
    
});


// Route::get('login', function () {
//     return view('login');
// });


Route::get('dashboard', function () {
    return view('dashboard');
});

Route::get('createuserform', function () {
    return view('createuser');
});





Route::get('login',[AdminsController::class, 'login']);
Route::post('loginadmin',[UsersController::class, 'loginadmin']);
Route::get('logout',[UsersController::class, 'logout']);
Route::get('checksession',[UsersController::class, 'checksession']);


Route::get('liste_agent_enligne',[UsersController::class, 'liste_agent_enligne']);
Route::get('liste_agent_terrain',[UsersController::class, 'liste_agent_terrain']);
Route::get('liste_assureur',[UsersController::class, 'liste_assureur']);


Route::post('detecttext',[GoogleCloudVisionyController::class, 'detecttext']);
Route::get('detecttext_form',[GoogleCloudVisionyController::class, 'detecttext_form']);
Route::get('detecttextinapp',[GoogleCloudVisionyController::class, 'detecttextinapp']);
Route::get('formulaire_cotation',[GoogleCloudVisionyController::class, 'formulaire_cotation']);
Route::get('formulaire_cotation_sc',[GoogleCloudVisionyController::class, 'formulaire_cotation_sc']);
Route::get('lecteur_carte_grise',[GoogleCloudVisionyController::class, 'lecteur_carte_grise']);

Route::post('create_cotation_frcg',[GoogleCloudVisionyController::class, 'create_cotation_frcg']);




Route::get('ajout_vehicule ',[GoogleCloudVisionyController::class, 'formulaire_ajout_vehicule']);
Route::post('find_carmodel',[GoogleCloudVisionyController::class, 'find_carmodel']);
Route::post('find_new_carmodel',[GoogleCloudVisionyController::class, 'find_new_carmodel']);

//ajout_valeur_vehicule_form.blade



Route::get('affectationbyagent',[UsersController::class, 'affectationbyagent']);

Route::group(['middleware' => ['usersession','logoutUsers']], function () {

        Route::get('monprofile', function () {
            return view('profile');
        });

         // Benchmark::dd(fn() =>
        
        Route::get('listeprosprection',[ProspectionClientController::class, 'listeprosprection']);
        Route::get('opportunite_supprimees',[ProspectionClientController::class, 'opportunite_supprimees']);
        
        // ,20);


        Route::get('create_car_brand',[AdminsController::class, 'create_car_brand']);
        Route::get('create_car_model',[AdminsController::class, 'create_car_model']);
        Route::get('create_vehicule',[AdminsController::class, 'create_vehicule']);
        Route::get('edit_car/{idcar}/{cardate}',[AdminsController::class, 'edit_car']);

        
        Route::get('vehicule_list',[AdminsController::class, 'liste_vehicule']);


        Route::post('create_cbrand',[AdminsController::class, 'create_cbrand']);
        Route::post('create_cmodel',[AdminsController::class, 'create_cmodel']);
        Route::post('save_new_cars',[AdminsController::class, 'save_new_cars']);
        Route::post('update_cars',[AdminsController::class, 'update_cars']);

        
        
        

        

        



        Route::get('cg_non_verif',[ProspectionClientController::class, 'cg_non_verif']);

        Route::get('retrouver_opportunite',[ProspectionClientController::class, 'retrouver_opportunite']);
        Route::get('recap_stat_opp',[ProspectionClientController::class, 'recap_stat_opp']);

        
        Route::post('filter_recap_stat_opp',[ProspectionClientController::class, 'filter_recap_stat_opp']);
        Route::post('findoppbyname',[ProspectionClientController::class, 'findoppbyname']);
        Route::post('findoppbytel',[ProspectionClientController::class, 'findoppbytel']);
        Route::post('findoppbyimmatricul',[ProspectionClientController::class, 'findoppbyimmatricul']);

        




        Route::get('listeprosprection_doublon',[ProspectionClientController::class, 'listeprosprection_doublon']);

        


        Route::get('liste_prosprection_created_online',[ProspectionClientController::class, 'listeprosprectioncreatedonline']);
        Route::get('liste_renouvellement',[ProspectionClientController::class, 'liste_renouvellement']);
        Route::get('liste_contrat',[ProspectionClientController::class, 'liste_contrat']);
        Route::get('bordereaux_contrat_condense',[UsersController::class, 'bordereaux_contrat_condense']);

        Route::get('bordereaux_opp_agent_terrain',[UsersController::class, 'bordereaux_opp_agent_terrain']);
        Route::get('qualification_agent_terrain',[UsersController::class, 'qualification_agent_terrain']);
        
        Route::post('filter_qualif_ag_terrain',[UsersController::class, 'filter_qualif_ag_terrain']);
        

        Route::get('details_contrats_byagent/{idop}',[UsersController::class, 'bordereaux_contrat_condense_detail']);
        Route::get('details_contrats_byagent/{idop}/{datedebut}/{datefin}',[UsersController::class, 'bordereaux_contrat_condense_detail_date']);


           Route::get('details_operations_traitees_agent/{idop}/{datedebut}/{datefin}',[UsersController::class, 'details_operations_traitees_agent']);


        Route::get('details_remontes_agent/{idop}',[UsersController::class, 'details_remontes_agent']);
         Route::get('details_remontes_agent/{idop}/{datedebut}/{datefin}',[UsersController::class, 'details_remontes_agent_date']);
        Route::get('bordereaux_rapport_operateur',[UsersController::class, 'bordereaux_rapport_operateur']);


        Route::get('stat_du_jour',[UsersController::class, 'statjournalier']);
        Route::get('stat_diagram',[UsersController::class, 'stat_diagram']);
        Route::get('stat_diagram_cumul',[UsersController::class, 'stat_diagram_cumul']);

        Route::get('check_cg_assurance',[ProspectionClientController::class, 'check_cg_assurance']);


        

        
        


        Route::get('testocr',[AdminsController::class, 'testOcr']);


        Route::get('liste_contrat_byagent',[ProspectionClientController::class, 'liste_contrat_byagent']);
        Route::get('liste_contrat_byagent_admin',[ProspectionClientController::class, 'liste_contrat_byagent_admin']);



        Route::post('filter_contrat_byagent_admin',[ProspectionClientController::class, 'filter_contrat_byagent_admin']);
        Route::post('filter_contrat_bytel_admin',[ProspectionClientController::class, 'filter_contrat_bytel_admin']);
        Route::post('filter_contrat_byclientname_admin',[ProspectionClientController::class, 'filter_contrat_byclientname_admin']);
        Route::post('filter_contrat_byplaque_admin',[ProspectionClientController::class, 'filter_contrat_byplaque_admin']);

        Route::post('filter_contrat_echeance_admin',[ProspectionClientController::class, 'filter_contrat_echeance_admin']);
        Route::post('filter_contrat_relance_admin',[ProspectionClientController::class, 'filter_contrat_relance_admin']);

        

        
        

        
        Route::post('liste_contrat_byagent_bydate',[ProspectionClientController::class, 'liste_contrat_byagent_bydate']);
        Route::post('filter_liste_contrat',[ProspectionClientController::class, 'filter_liste_contrat']);
        Route::post('filter_contrat_condenses',[UsersController::class, 'filter_contrat_condenses']);
        Route::post('filter_bordereau_rapport_operateur',[UsersController::class, 'filter_rapport_operateur']);

        Route::post('filter_bordereau_ag_terrain',[UsersController::class, 'filter_bordereau_ag_terrain']);

        
        Route::post('filter_stat',[UsersController::class, 'filter_stat']);
        Route::post('filter_stat_renouvellemnt',[AdminsController::class, 'filter_stat_renouvellemnt']);
        

        


        Route::get('liste_prospection_byagent',[ProspectionClientController::class, 'liste_prospection_byagent']);
         Route::post('filter_liste_prospection_byagent',[ProspectionClientController::class, 'filter_liste_prospection_byagent']);

        Route::get('liste_prospection_byagent_relance',[ProspectionClientController::class, 'liste_prospection_byagent_relance']);


        Route::post('liste_prospection_byagent_relance_searchtel',[ProspectionClientController::class, 'liste_prospection_byagent_relance_searchtel']);



        Route::post('liste_prospection_byagent_relance_searchname',[ProspectionClientController::class, 'liste_prospection_byagent_relance_searchname']);


        
        

        Route::get('liste_prospection_byagent_relance_admin',[ProspectionClientController::class, 'liste_prospection_byagent_relance_admin']);

        

        Route::get('opportunite_admin',[ProspectionClientController::class, 'opportunite_admin']);
        Route::post('filter_opp_tel_admin',[ProspectionClientController::class, 'filter_opp_tel_admin']);

        Route::post('filter_opp_tel_agent',[ProspectionClientController::class, 'filter_opp_tel_agent']);
        Route::post('filter_opp_name_admin',[ProspectionClientController::class, 'filter_opp_name_admin']);

         Route::post('filter_opp_name_agent',[ProspectionClientController::class, 'filter_opp_name_agent']);


        Route::post('filter_opp_echeance_admin',[ProspectionClientController::class, 'filter_opp_echeance_admin']);
        Route::post('filter_opp_relance_admin',[ProspectionClientController::class, 'filter_opp_relance_admin']);


        Route::post('filter_opp_echeance_agent',[ProspectionClientController::class, 'filter_opp_echeance_agent']);
        Route::post('filter_opp_relance_agent',[ProspectionClientController::class, 'filter_opp_relance_agent']);

         Route::post('filter_opp_agent_relance_admin',[ProspectionClientController::class, 'filter_opp_agent_relance_admin']);


         Route::post('filter_opp_agent_echeance_admin',[ProspectionClientController::class, 'filter_opp_agent_echeance_admin']);


         

          Route::get('opportunite_agent',[ProspectionClientController::class, 'opportunite_agent']);


        Route::post('filter_relance_admin',[ProspectionClientController::class, 'filter_relance_admin']);
        Route::post('filter_relance_tel_admin',[ProspectionClientController::class, 'filter_relance_tel_admin']);
        Route::post('filter_relance_name_admin',[ProspectionClientController::class, 'filter_relance_name_admin']);
        Route::post('filter_relance_echeance_admin',[ProspectionClientController::class, 'filter_relance_echeance_admin']);
        Route::post('filter_relance_relance_admin',[ProspectionClientController::class, 'filter_relance_relance_admin']);


        Route::post('filter_relance_agent',[ProspectionClientController::class, 'filter_relance_agent']);
        Route::post('filter_relance_tel_agent',[ProspectionClientController::class, 'filter_relance_tel_agent']);
        Route::post('filter_relance_name_agent',[ProspectionClientController::class, 'filter_relance_name_agent']);
        Route::post('filter_relance_echeance_agent',[ProspectionClientController::class, 'filter_relance_echeance_agent']);
        Route::post('filter_relance_relance_agent',[ProspectionClientController::class, 'filter_relance_relance_agent']);

        

        Route::post('filter_affectation_byagent',[ProspectionClientController::class, 'filter_affectation_byagent']);

        Route::post('filter_affectation_byclientname',[ProspectionClientController::class, 'filter_affectation_byclientname']);

        Route::post('filter_affectation_bytel',[ProspectionClientController::class, 'filter_affectation_bytel']);
        Route::post('filter_affectation_bydate',[ProspectionClientController::class, 'filter_affectation_bydate']);


        


        Route::get('liste_prospection_byagent_ferme',[ProspectionClientController::class, 'liste_prospection_byagent_ferme']);

        Route::get('liste_prospection_ferme',[ProspectionClientController::class, 'liste_prospection_ferme']);
        Route::post('filter_prospection_ferme',[ProspectionClientController::class, 'filter_prospection_ferme']);
        Route::post('filter_prospection_ferme_tel',[ProspectionClientController::class, 'filter_prospection_ferme_tel']);



        Route::post('filter_prospection_ferme_nom',[ProspectionClientController::class, 'filter_prospection_ferme_nom']);

        


        Route::post('filter_bordereau_byagent',[ProspectionClientController::class, 'filter_bordereau_byagent']);


        Route::post('filter_opportunite_created_online',[ProspectionClientController::class, 'filter_opportunite_created_online']);



        Route::post('listeprosprectionbytel',[ProspectionClientController::class, 'listeprosprectionbytel']);

        Route::post('listeprosprectionbyname',[ProspectionClientController::class, 'listeprosprectionbyname']);
         Route::post('listeprosprectionbycanal',[ProspectionClientController::class, 'listeprosprectionbycanal']);

        
        Route::post('listeprosprectionbynamedoublon',[ProspectionClientController::class, 'listeprosprectionbynamedoublon']);

        

        Route::post('listeprosprectionbyteldoublon',[ProspectionClientController::class, 'listeprosprectionbyteldoublon']);
        

        Route::post('listeprosprectionbytel_agent',[ProspectionClientController::class, 'listeprosprectionbytel_agent']);

        Route::post('listeprosprectionbydate',[ProspectionClientController::class, 'listeprosprectionbydate']);

        Route::post('listeprosprection_doublonbydate',[ProspectionClientController::class, 'listeprosprection_doublonbydate']);

        

        Route::post('listeprospectionbyagentrelancebydate',[ProspectionClientController::class, 'listeprospectionbyagentrelancebydate']);



        Route::post('update_opportunite',[ProspectionClientController::class, 'update_opportunite']);
        Route::post('removeopp',[ProspectionClientController::class, 'removeopp']);
        Route::post('removeoppcommentaire',[ProspectionClientController::class, 'removeoppcommentaire']);
        Route::post('removecontrat',[ProspectionClientController::class, 'removecontrat']);




        Route::get('liste_nvelle_opp_gagnee',[ProspectionClientController::class, 'liste_nvelle_opp_gagnee']);
        Route::get('liste_prospection_groupee',[ProspectionClientController::class, 'liste_prospection_groupee']);

        Route::get('liste_reaffectation_datee_admin',[ProspectionClientController::class, 'reaffectation_datee_admin']);
        Route::get('liste_reaffectation_datee_byagent',[ProspectionClientController::class, 'reaffectation_datee_byagent']);

        Route::post('filter_reaffectation_bydate',[ProspectionClientController::class, 'filter_reaffectation_bydate']);

        Route::post('filter_reaffectation_bydate_agent',[ProspectionClientController::class, 'filter_reaffectation_bydate_agent']);
        
        Route::get('notification_asap',[ProspectionClientController::class, 'notification_asap']);
        Route::get('notification_asapnbre',[ProspectionClientController::class, 'notification_asapnbre']);



        
        Route::get('prospection_full_details/{idopp}',[ProspectionClientController::class, 'prospection_full_details']);
        Route::get('enregister_propection',[ProspectionClientController::class, 'enregister_propection']);

       // Benchmark::dd(fn() =>

        Route::get('enregister_note_propection/{idopp}',[ProspectionClientController::class, 'enregister_note_propection']);



         Route::post('create_client_frcg',[ProspectionClientController::class, 'create_client_frcg']);


        


        //, 20);



        Route::get('importopportunites/',[ProspectionClientController::class, 'importopportunites']);

        Route::post('uploadfile',[ProspectionClientController::class, 'uploadfile']);
        Route::post('createuser',[UsersController::class, 'createuser']);
        Route::post('updateprofile',[UsersController::class, 'updateprofile']);
        Route::post('updatepassword',[UsersController::class, 'updatepassword']);

        
        Route::post('updateuserbasics',[UsersController::class, 'updateuserbasics']);
        Route::post('updateuserpriv',[UsersController::class, 'updateuserpriv']);
        Route::post('updateuserterrain',[UsersController::class, 'updateuserterrain']);




        
        Route::post('create_online_operator',[UsersController::class, 'create_online_operator']);
        Route::get('edit_online_operator/{idop}',[UsersController::class, 'edit_online_operator']);
        Route::get('edit_terrain_operator/{idop}',[UsersController::class, 'edit_terrain_operator']);
        
        Route::post('addProspectOnline',[ProspectionClientController::class, 'addProspectOnline']);

        //Administration


        Route::get('createcanal',[AdminsController::class, 'createcanal']);
        Route::get('liste_canaux',[AdminsController::class, 'liste_canaux']);
        Route::get('edit_canal/{idcanal}',[AdminsController::class, 'edit_canal']);
        Route::get('find_available_agent',[AdminsController::class, 'find_available_agent']);
        Route::post('find_histo_rn',[AdminsController::class, 'find_histo_rn']);
        Route::get('find_available_agent_mass',[AdminsController::class, 'find_available_agent_mass']);

        Route::get('stat_renouvellement',[AdminsController::class, 'stat_renouvellement']);
        Route::any('stat_compagnie',[AdminsController::class, 'stat_compagnie']);



        Route::post('attrib_opportunite',[AdminsController::class, 'attrib_opportunite']);
        Route::post('attrib_opportunite_mass',[AdminsController::class, 'attrib_opportunite_mass']);
        Route::post('reaff_newnote_mass',[AdminsController::class, 'reaff_newnote_mass']);
        Route::post('reaff_newnote_mass_rn',[AdminsController::class, 'reaff_newnote_mass_rn']);

        
        
        Route::post('reaff_newnote',[AdminsController::class, 'reaff_newnote']);
        Route::post('reaff_newnote_rn',[AdminsController::class, 'reaff_newnote_rn']);
        

        Route::post('calcul_cotation',[GoogleCloudVisionyController::class, 'calcul_cotation']);


        Route::any('ReadTextFromCard',[GoogleCloudVisionyController::class, 'OpenAiReadText']);



        Route::get('create_assureur',[UsersController::class, 'create_assureur']);
        Route::get('create_agent_enligne',[UsersController::class, 'create_agent_enligne']);
        Route::post('registercanal',[AdminsController::class, 'registercanal']);
        Route::post('registerassureur',[AdminsController::class, 'registerassureur']);
        Route::post('registernote',[AdminsController::class, 'registernote']);
        Route::post('updatenote',[AdminsController::class, 'updatenote']);

        
         Route::get('check_datatable_btn',[UsersController::class, 'check_datatable_btn']);


        Route::get('multistep',[GoogleCloudVisionyController::class, 'checkmultistep']);



    });











