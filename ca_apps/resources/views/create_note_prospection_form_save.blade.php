 @extends('layouts.master')
    @section('headerCss')
    <!-- Layout config Js -->
    <script src="/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

    @stop   
  

    @section('content')
      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="main-content">
        <div class="page-content">
          <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
              <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                  <h4 class="mb-sm-0">INFORMATION DE BASE</h4>
                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Formulaire</a>
                      </li>
                      <li class="breadcrumb-item active">Enregistrements</li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <!-- end page title -->

                @php
                    $usersprivileges = Session::get('userprivilege_list');
                    $menu_commenter = array(26);
                    $has_cartegrise = 'nocardgrise';
                    $has_assurance  = 'noassurance';

                    $oppid  =$findOpportunity['id'];

                    if ($findOpportunity['urlcarte_grise']==null && $findOpportunity['urlcarte_grise_terrain']==null) {
                        // code...
                        $has_cartegrise = 'nocardgrise';

                    }else
                    $has_cartegrise = 'cardgrise';
                    

                    if ($findOpportunity['url_attestationassurance']==null && $findOpportunity['url_attestationassurance_terrain']==null) {
                        // code...
                        $has_assurance = 'noassurance';

                    }else
                    $has_assurance = 'assurance';
                    
                    
                    

                @endphp

                    <div class="row">
                       
                            @isset($lastcommentaire)

                                 @if ($lastcommentaire['resultat'] == 'gagne')
                                    <div class="alert alert-success text-center display-6" role="alert">
                                        <strong>  OPPORTUNITE: </strong>  <b style="text-transform: uppercase;">{{$lastcommentaire['resultat']}}</b> 
                                    </div>
                                 @endif

                                 @if ($lastcommentaire['resultat'] == 'poursuivre')
                                    <div class="alert alert-dark text-center display-6" role="alert">
                                        <strong>  OPPORTUNITE: </strong>  <b style="text-transform: uppercase;">{{$lastcommentaire['resultat']}}</b> 
                                    </div>
                                 @endif


                                 @if ($lastcommentaire['resultat'] == 'perdu')
                                    <div class="alert alert-danger text-center display-6" role="alert">
                                        <strong>  OPPORTUNITE: </strong>  <b style="text-transform: uppercase;">{{$lastcommentaire['resultat'].'e'}}</b> 
                                    </div>
                                 @endif


                                 @if ($lastcommentaire['resultat'] == 'reporte')
                                    <div class="alert alert-worning text-center display-6" role="alert">
                                        <strong>  OPPORTUNITE: </strong>  <b style="text-transform: uppercase;">{{$lastcommentaire['resultat']}}</b> 
                                    </div>
                                 @endif


                                 @if ($lastcommentaire['resultat'] == 'horscible')
                                    <div class="alert alert-danger text-center display-6" role="alert">
                                        <strong>  OPPORTUNITE: </strong>  <b style="text-transform: uppercase;">{{$lastcommentaire['resultat']}}</b> 
                                    </div>
                                 @endif

                                 @else
                                 
                                 <div class="alert alert-primary text-center display-6" role="alert">
                                        <strong>  OPPORTUNITE: </strong>  <b style="text-transform: uppercase;"> Nouvelle</b> 
                                    </div>

                            @endisset

                        </h4>

                        @if (!empty($findOpportunity['agent_terrain']))
                            {{-- expr --}}
                       
                        <h4 style="text-align: center;font-weight:bold;"><span style="font-weight:lighter;">Remonté par l'Agent Terrain : </span>{{$findOpportunity['agent_terrain']['lastname'].' '.$findOpportunity['agent_terrain']['firstname']}}</h4>

                        @elseif(!empty($findOpportunity['agent_enligne']))

                         <h4 style="text-align: center;font-weight:bold;"><span style="font-weight:lighter;">Remonté par l'Agent Bureau : </span>{{$findOpportunity['agent_enligne']['lastname'].' '.$findOpportunity['agent_enligne']['firstname']}}</h4>

                        @else
                         <h4 style="text-align: center;font-weight:bold;"><span>Remonté par : </span>Non defini</h4>
                        @endif


                        <div class="col-xxl-6"> 
                            <div class="card ribbon-box border shadow-none mb-lg-0">
                                <div class="card-header align-items-center d-flex">
                                    {{-- <h5 class="fs-14 text-end">Information de base</h5> --}}
                                    <div class="flex-shrink-0"></div>
                                </div><!-- end card header -->

                                <div class="card-body">

                                    @isset($lastcommentaire)
                                   

                                            @if ($lastcommentaire['resultat'] == 'gagne')
                                                {{-- expr --}}
                                                <div class="ribbon ribbon-success ribbon-shape">Opportunité Gagnée</div>
                                            @endif

                                             @if ($lastcommentaire['resultat'] == 'poursuivre')
                                                {{-- expr --}}
                                                <div class="ribbon ribbon-dark ribbon-shape">Opportunité poursuivre</div>
                                            @endif


                                            @if ($lastcommentaire['resultat'] == 'perdu')
                                                {{-- expr --}}
                                                <div class="ribbon ribbon-danger ribbon-shape">Opportunité perdue</div>
                                            @endif

                                             @if ($lastcommentaire['resultat'] == 'reporte')
                                                {{-- expr --}}
                                                <div class="ribbon ribbon-warning ribbon-shape">Opportunité reportée</div>
                                            @endif
                                    @else                
                                         <div class="ribbon ribbon-primary ribbon-shape">Opportunité Nouvelle</div>            
                                    @endisset


                                    <div class="live-preview">
                                        <form id="formtoupdate" class="formtoupdate" action="javascript:void(0);">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                     
                                                        <label for="firstNameinput" class="form-label">Nom client</label>
                                                        <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="edit_name" value="{{$findOpportunity['nom']}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="firstNameinput" class="form-label">Prénoms client</label>
                                                        <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="edit_prenoms" value="{{$findOpportunity['prenoms']}}">
                                                    </div>
                                                </div>

                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="firstNameinput" class="form-label">Téléphone</label>
                                                        <input type="text" class="form-control" placeholder="Entrer votre numero de telephone" id="firstNameinput" name="edit_tel" value="{{$findOpportunity['telephone']}}">
                                                    </div>
                                                 </div>

                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="firstNameinput" class="form-label">Téléphone2</label>
                                                        <input type="text" class="form-control" placeholder="Entrer votre numero de telephone" id="firstNameinput" name="edit_tel2" value="{{$findOpportunity['telephone2']}}">
                                                    </div>
                                                 </div>
                                                 


                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Echéance</label>
                                                        <input type="date" name="edit_dateecheance" class="form-control maxlength10" id="exampleInputdate" value="{{\Carbon\Carbon::parse($findOpportunity['echeance'])->format('Y-m-d')}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div>
                                                    <label for="readonlyInput" class="form-label">Lieu Prospection</label>
                                                        <input name="edit_lieuprospection" type="text" class="form-control" id="readonlyInput" value="{{$findOpportunity['lieuprospection']}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div>
                                                    <label for="readonlyInput" class="form-label">Immatriculation </label>
                                                        <input name="edit_immatriculation" type="text" class="form-control" id="readonlyInput" value="{{$findOpportunity['plaque_immatriculation']?? ' ' }}">
                                                    </div>
                                                </div>

                                                 <div class="row">

                                                    <div class=" form-radio-primary mb-3 col-md-6">
                                                         <label style="margin-right: 100px;" for="readonlyInput" class="form-label">Etat du Discours</label>
                                                        {{-- <input class="form-check-input" type="radio" name="etatdiscours" id="formradioRight5" value="OK" >
                                                        <label class="form-check-label" for="formradioRight5">
                                                            Discours OK
                                                        </label> --}}
                                                    </div>
                                                     

                                                     {{-- <div class=" form-radio-primary mb-3 col-md-6">
                                                        <input class="form-check-input" type="radio" name="etatdiscours" id="formradioRight5" value="NOK">
                                                        <label class="form-check-label" for="formradioRight5">
                                                            discours NOK
                                                        </label>
                                                    </div> --}}

                                                    <p class="text-muted">Permet de definir si les informations remontées sont fiables </p>

                                                    <div class="live-preview">
                                                        <div class="hstack gap-2 flex-wrap"> 
                                                            
                                                            <input type="radio" class="btn-check" name="etatdiscours" id="success-outlined-discours" value="OK" @if($findOpportunity['statut_discours']=='OK')checked @endif>
                                                            <label class="btn btn-outline-success" for="success-outlined-discours">Discours OK</label>

                                                            <input type="radio" class="btn-check" name="etatdiscours" id="danger-outlined-discours" value="NOK" @if($findOpportunity['statut_discours']=='NOK')checked @endif>
                                                            <label class="btn btn-outline-danger" for="danger-outlined-discours"> Discours NOK</label>

                                                        </div>
                                                    </div>


                                                 </div>

                                            <div class="col-md-6">
                                                <div class="card card-height-100 ">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Attestation assurance</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mx-auto">


                                                             
                                                            @if ($findOpportunity['url_attestationassurance']!='')
                                                                {{-- expr --}}
                                                                 {{-- <img src="{{$findOpportunity['url_attestationassurance']}}" style="width: 300px;height: 200px; margin: 0 auto;display: block;" alt=""> --}}
                                                                 <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="    margin: 0 auto;display: block;">Afficher l'attestation d'assurance</button>
                                                            
                                                            @elseif($findOpportunity['url_attestationassurance_terrain']!='')
                                                                <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="    margin: 0 auto;display: block;">Afficher l'attestation d'assurance Terrain</button>

                                                            @else
                                                             {{-- <img src="/assets/images/No-Image-Placeholder.png" style="width: 300px;height: 200px; margin: 0 auto;display: block;" alt=""> --}}
                                                              <button disabled type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="    margin: 0 auto;display: block;">Attestation inexistante</button>

                                                            @endif

                                                            <div style="margin-top: 20px;">
                                                                <span class="msg_file" style="color: red;margin-left: 10px;display: none;"> fichier invalide</span>
                                                                <input name="Imgattesation" class="form-control" type="file" >
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card -->
                                            </div>
                                            <!-- end col -->




                                       
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Carte Grise</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="card-wrapper mb-3">

                                                            @php
                                                              //  dd($findOpportunity);
                                                            @endphp

                                                             @if ($findOpportunity['urlcarte_grise']!='')
                                                                {{-- expr --}}
                                                                 {{-- <img src="{{$findOpportunity['urlcarte_grise']}}" style="width: 300px;height: 200px; margin: 0 auto;display: block;" alt=""> --}}
                                                                 <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-cg" style="    margin: 0 auto;display: block;width: 243px;">Afficher la carte grise</button>
                                                            @elseif($findOpportunity['urlcarte_grise_terrain']!='')
                                                            
                                                                <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-cg" style="margin: 0 auto;display: block;width: 243px;">Afficher la carte grise Terrain</button>

                                                            @else
                                                             {{-- <img src="/assets/images/No-Image-Placeholder.png" style="width: 300px;height: 200px; margin: 0 auto;display: block;" alt=""> --}}

                                                              <button disabled type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" style="    margin: 0 auto;display: block;">Carte grise inexistante</button>

                                                            @endif

                                                            <div style="margin-top: 20px;">
                                                                <span class="msg_file" style="color: red;margin-left: 10px;display: none;"> fichier invalide</span>
                                                                <input name="Imgcartegrise" class="form-control" type="file" >
                                                            </div>

                                                        </div>

                                                        {{-- <div class="form-container active">
                                                            <form action="widgets.html" id="card-form-elem" autocomplete="off">
                                                                
                                                                
                                                            </form>
                                                        </div> --}}
                                                    </div>
                                                    <!-- end card-body -->
                                                </div>
                                                <!-- end card -->
                                            </div>

                                             @if ($findOpportunity['urlcarte_grise_terrain'])
                                                <div class="row">
                                                    <div class=" form-radio-primary mb-3 col-md-6">
                                                         <label style="margin-right: 100px;" for="readonlyInput" class="form-label">Etat Carte grise</label>
                                                        
                                                    </div>
                                                     


                                                    <p class="text-muted">Permet de definir si la carte grise remontée est bonne, bien prise et est bien celle de la fiche </p>
                                                    <div class="live-preview">
                                                        <div class="hstack gap-2 flex-wrap"> 
                                                            
                                                            <input type="radio" class="btn-check" name="etatcg" id="success-outlined" value="OK"   @if($findOpportunity['statut_carte_grise']=='OK')checked @endif>
                                                            <label class="btn btn-outline-success" for="success-outlined">Carte Grise OK</label>

                                                            <input type="radio" class="btn-check" name="etatcg" id="danger-outlined" value="NOK"   @if($findOpportunity['statut_carte_grise']=='NOK')checked @endif>
                                                            <label class="btn btn-outline-danger" for="danger-outlined"> Carte Grise NOK</label>

                                                        </div>
                                                    </div>



                                                 </div>
                                                 @endif


                                                 @if ($findOpportunity['url_attestationassurance_terrain'])

                                                 <div class="row">
                                                    <div class=" form-radio-primary mb-3 col-md-6">
                                                         <label style="margin-right: 100px;" for="readonlyInput" class="form-label">Etat Attestation</label>
                                                        
                                                    </div>

                                                    <p class="text-muted">Permet de definir si l'attestation remontée est bonne, bien prise et est bien celle de la fiche</p>

                                                    <div class="live-preview">
                                                        <div class="hstack gap-2 flex-wrap"> 
                                                            
                                                            <input type="radio" class="btn-check" name="etatattestation" id="success-outlined-attestation" value="OK"  @if($findOpportunity['statut_attestation']=='OK')checked @endif>
                                                            <label class="btn btn-outline-success" for="success-outlined-attestation">Attestation OK</label>

                                                            <input type="radio" class="btn-check" name="etatattestation" id="danger-outlined-attestation" value="NOK"  @if($findOpportunity['statut_attestation']=='NOK')checked @endif>
                                                            <label class="btn btn-outline-danger" for="danger-outlined-attestation"> Attestation NOK</label>

                                                        </div>
                                                    </div>

                                                 </div>
                                                 @endif


                                                 <div class="col-md-12"></div>

                                                  <div class="col-md-12">
                                                    <div>
                                                        <label for="exampleFormControlTextarea5" class="form-label">Observation</label>
                                                        <textarea name="edit_observation" class="form-control" id="exampleFormControlTextarea5" rows="3"> {{$findOpportunity['observation']}}</textarea>
                                                    </div>
                                                </div>

                                                <input type="hidden"  name="selectedid" value="{{$findOpportunity['id']}}">

                                                <div class="col-md-12" style="margin-top: 20px">
                                                    <div class="text-center">
                                                         <a href="#" id="updateOppbtn"  style="width: 98%; height: 50px;margin-top: 20px; font-weight: bold;line-height: 35px;"   class="btn btn-success">Mettre à jour les informations</a>
                                                    </div>
                                                </div>


                                                <!--end col-->

                                                <div style="margin-bottom:10px"></div>

                                                <!--end col-->
                                            </div>
                                            <!--end row-->

                                             <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myLargeModalLabel">Attestation Assurance</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- <h6 class="fs-15">Attestation Assurance</h6> --}}
                                                            {{-- <img src="" alt=""> --}}

                                                             @if ($findOpportunity['url_attestationassurance']!='')


                                                             <img src="{{$findOpportunity['url_attestationassurance']}}" style=" margin: 0 auto;display: block;width: -webkit-fill-available;" alt="">

                                                              @elseif($findOpportunity['url_attestationassurance_terrain']!='')

                                                               <img src="{{$findOpportunity['url_attestationassurance_terrain']}}" style=" margin: 0 auto;display: block;width: -webkit-fill-available;" alt="">

                                                              @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                            {{-- <button type="button" class="btn btn-primary ">Save changes</button> --}}
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->


                                            <div class="modal fade bs-example-modal-lg-cg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myLargeModalLabel">Carte Grise</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- <h6 class="fs-15">Attestation Assurance</h6> --}}
                                                            {{-- <img src="" alt=""> --}}


                                                            @if ($findOpportunity['urlcarte_grise']!='')


                                                             <img src="{{$findOpportunity['urlcarte_grise']}}" style=" margin: 0 auto;display: block;width: -webkit-fill-available;" alt="">

                                                            @elseif($findOpportunity['urlcarte_grise_terrain']!='')
                                                                 <img src="{{$findOpportunity['urlcarte_grise_terrain']}}" style=" margin: 0 auto;display: block;width: -webkit-fill-available;" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                            {{-- <button type="button" class="btn btn-primary ">Save changes</button> --}}
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

                                        </form>
                                    </div>
                                    <div class="d-none code-view">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                         <div class="col-xxl-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Ajouter un commentaire</h4>
                            <div class="flex-shrink-0">
                              
                            </div>


                        </div><!-- end card header -->
                        <div class="card-body">
                            
                            <div class="live-preview">
                                <form id="createNote" action="javascript:void(0);">
                                    <div id="message" class="alert alert-danger mb-xl-3" role="alert" style="display:none">
                                                    <strong> Renseigner les champs obligatoire! </strong> !
                                                </div>
                                    <div class="row">

                                        {{-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Nom client</label>
                                                <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="nomclient" value="{{$findOpportunity['nom']}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Prénoms client</label>
                                                <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="prenomclient" value="{{$findOpportunity['prenoms']}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Téléphone</label>
                                                <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="telclient" value="{{$findOpportunity['telephone']}}" >
                                            </div>
                                        </div> --}}
                                        @php
                                        //    dd($lastcommentaire);
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="exampleInputdate" class="form-label"> Echéance</label>
                                                <input type="date" name="dateecheance" class="form-control maxlength10" id="exampleInputdate" @isset($lastcommentaire) value="{{\Carbon\Carbon::parse($lastcommentaire['echeance'])->format('Y-m-d')}}" @endisset>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="exampleInputdate" class="form-label"> Date relance</label>
                                                <input type="date" name="daterelance" class="form-control maxlength10" id="exampleInputdate" @isset($lastcommentaire) value="{{\Carbon\Carbon::parse($lastcommentaire['daterelance'])->format('Y-m-d')}}" @endisset>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="exampleInputtime" class="form-label">Heure relance</label>
                                                <input type="time" name="heurerelance" class="form-control" id="exampleInputtime" @isset($lastcommentaire) value="{{\Carbon\Carbon::parse($lastcommentaire['heure_relance'])->format('H:i')}}" @endisset>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Assureur Actuel</label>
                                                <input type="text" class="form-control" placeholder="assureur" id="firstNameinput" name="assureur" @isset($lastcommentaire) value="{{$lastcommentaire['assureur_actuel']}}" @endisset>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Période souscription (Mois) </label>
                                                <input type="text" class="form-control numberonly" placeholder="1 mois" id="firstNameinput" name="periodesousc" @isset($lastcommentaire) value="{{$lastcommentaire['periode_soucription']}}" @endisset>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Prime Nette</label>
                                                <input type="text" class="form-control numberonly" placeholder="Montant" id="firstNameinput" name="primenet" @isset($lastcommentaire) value="{{$lastcommentaire['primenet']}}"  @endisset>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Prime TTC</label>
                                                <input type="text" class="form-control numberonly" placeholder="Montant" id="firstNameinput" name="primettc" @isset($lastcommentaire) value="{{$lastcommentaire['primettc']}}" @endisset>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div>
                                                <label for="exampleFormControlTextarea5" class="form-label">Retour Client </label>
                                                <textarea class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                                            </div>
                                        </div> --}}
                                        <!--end col-->
                                        <!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="ForminputState" class="form-label">interet du client</label>
                                                <select name="interetclient" id="ForminputState" class="form-select" data-choices data-choices-sorting="true">
                                                    <option selected value="">Choisir...</option>
                                                    <option value="interesse">interessé</option>
                                                    <option value="indecis">indécis</option>
                                                    <option value="pasinteresse">Pas intéressé</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="ForminputState" class="form-label">Resultat</label>
                                                <select name="resultatentretien" id="resultatentretien" class="form-select requiredField" data-choices data-choices-sorting="true">
                                                    <option selected  value="">Choisir...</option>
                                                    <option value="gagne">Gagné</option>
                                                    <option value="poursuivre">Poursuivre</option>
                                                    <option value="reporte">Reporté</option>
                                                    <option value="perdu">Perdu</option>
                                                    <option value="horscible">Hors cible</option>
                                                </select>
                                            </div>
                                        </div>

                                         @if  (in_array(29, Session::get('userprivilege_list'))) 
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="ForminputState" class="form-label">Souscrit par</label>
                                                <select name="souscritpar" id="souscritpar" class="form-select" data-choices data-choices-sorting="true">
                                                    <option selected  value="">Choisir...</option>
                                                    @foreach ($listecommerciaux as $listecommerciaux_el)
                                                    {{-- expr --}}
                                                     <option value="{{$listecommerciaux_el['id']}}">{{strtoupper($listecommerciaux_el['firstname'].' ' .$listecommerciaux_el['lastname'])}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-12">
                                            <p style="text-align: center;font-weight: bold;color: black;"> interressé par </p>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" name="flotteauto" type="checkbox" id="formCheck13" value="0">
                                                <label class="form-check-label" for="formCheck13">
                                                    Flotte Auto
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-secondary mb-3">
                                                <input class="form-check-input" name="habitation" type="checkbox" id="formCheck14" value="0">
                                                <label class="form-check-label" for="formCheck14">
                                                    Habitation
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-secondary mb-3">
                                                <input class="form-check-input" name="sante" type="checkbox" id="formCheck14" value="0">
                                                <label class="form-check-label" for="formCheck14">
                                                    Santé
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" name="voyage" type="checkbox" id="formCheck15" value="0">
                                                <label class="form-check-label" for="formCheck15">
                                                    Voyage
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-warning mb-3">
                                                <input class="form-check-input" name="autre" type="checkbox" id="formCheck16" value="0">
                                                <label class="form-check-label" for="formCheck16">
                                                    Autre
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"></div>
                                        <div class="col-md-12">
                                            <div>
                                                <label for="exampleFormControlTextarea5" class="form-label">Observation</label>
                                                <textarea name="observation" class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                                            </div>
                                        </div>
                                       
                                        @isset($lastcommentaire) 
                                         @if  (in_array(26, $usersprivileges) || $lastcommentaire['resultat'] != 'gagne') 
                                        <div class="col-md-12" style="margin-top: 20px">
                                            <div class="text-center">
                                                <a  style="width: 98%; height: 50px;" id="savenote" class="btn btn-primary">Enregistrer la note</a>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-12" style="margin-top: 20px">
                                            <div class="text-center">
                                                <a href="#" style="width: 98%; height: 50px;"  class="btn btn-light" disabled>Consultation</a>
                                            </div>
                                        </div>

                                        @endif
                                        @else
                                        <div class="col-md-12" style="margin-top: 20px">
                                            <div class="text-center">
                                                <a  style="width: 98%; height: 50px;" id="savenote" class="btn btn-primary">Enregistrer la note</a>
                                            </div>
                                        </div>

                                        @endisset
                                        <!--end col-->
                                        <div style="margin-bottom:10px"></div>
                                        <input type="hidden" name="idopp" value="{{$findOpportunity['id']}}">
                                        <!--end col-->
                                        {{-- <div class="col-lg-12">
                                            <div class="text-end">
                                                <button type="submit" id="savenote" class="btn btn-primary">Enregistrer la note</button>
                                            </div>
                                        </div> --}}
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <div class="d-none code-view">
                            </div>
                        </div>
                    </div>
                </div>
                    </div>


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Actions effectuées</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <p class="text-muted">Resume les operations effectuées sur cette opportunité</p>
                                    <div class="live-preview">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-nowrap align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Ligne</th>
                                                        <th scope="col">Operateur</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Commentaire</th>
                                                        <th scope="col">interet</th>
                                                        <th scope="col">[Ré]affecté par</th>
                                                        <th scope="col">Echeance</th>
                                                        <th scope="col">Date Relance</th>
                                                        <th scope="col">Heure Relance</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    
                                                    @foreach ($listecommentaire as $commmentaire)
                                                        {{-- expr --}}
                                                        <tr>
                                                        <td class="fw-medium">{{$commmentaire['id']}}</td>
                                                        <td>{{$commmentaire['agent_backoffice']['firstname']. ' '.$commmentaire['agent_backoffice']['lastname']}}</td>

                                                        <td>{{\Carbon\Carbon::parse($commmentaire['created_at'])->format('d-m-Y H:i:s')}}</td>
                                                        <td>{{$commmentaire['observation']}}</td>
                                                        <td>
                                                            @if ($commmentaire['interetclient'] =='interesse' )
                                                                {{-- expr --}}
                                                                <span class="badge bg-success">{{$commmentaire['interetclient']}}</span>
                                                            @endif

                                                            @if ($commmentaire['interetclient'] =='indecis' )
                                                               <span class="badge bg-warning">{{$commmentaire['interetclient']}}</span>
                                                            @endif


                                                            @if ($commmentaire['interetclient'] =='pasinteresse' )
                                                                 <span class="badge bg-danger">{{$commmentaire['interetclient']}}</span>
                                                            @endif
                                                           

                                                        </td>
                                                        
                                                        @if (!is_null($commmentaire['reaffectation']))
                                                            {{-- expr --}}
                                                        
                                                        <td> {{$commmentaire['reaffectation']['firstname']. ' '.$commmentaire['reaffectation']['lastname']}}</td>
                                                        @elseif(!is_null($commmentaire['affectations']))
                                                        
                                                         <td> {{$commmentaire['affectations']['auteur_affecation'][0]['firstname']. ' '.$commmentaire['affectations']['auteur_affecation'][0]['lastname']}}</td>

                                                         @else
                                                         <td> - </td>
                                                        @endif
                                                        <td>{{\Carbon\Carbon::parse($commmentaire['echeance'])->format('d-m-Y')}}</td>
                                                        <td>{{\Carbon\Carbon::parse($commmentaire['daterelance'])->format('d-m-Y')}}</td>
                                                        <td>{{\Carbon\Carbon::parse($commmentaire['heure_relance'])->format('H:i:s')}}</td>

                                                        {{-- <td><button id="save_createuserform" class="btn btn-primary" style="margin-right: 40px;" type="button">{{$commmentaire['resultat']}}</button></td> --}}


                                                         <td>
                                                            @if ($commmentaire['resultat'] == 'gagne')
                                                                {{-- expr --}}
                                                                <span style="display:inline-block;width: 66px;" class="badge rounded-pill badge-soft-success">Gagne</span>
                                                            @endif

                                                             @if ($commmentaire['resultat'] == 'poursuivre')
                                                                {{-- expr --}}
                                                                <span style="display:inline-block;width: 66px;" class="badge rounded-pill badge-soft-secondary">Poursuivre</span>
                                                            @endif


                                                            @if ($commmentaire['resultat'] == 'perdu')
                                                                {{-- expr --}}
                                                                <span style="display:inline-block;width: 66px;" class="badge rounded-pill badge-soft-danger">Perdu</span>
                                                            @endif

                                                             @if ($commmentaire['resultat'] == 'reporte')
                                                                {{-- expr --}}
                                                                <span style="display:inline-block;width: 66px;" class="badge rounded-pill badge-soft-dark">Reporte</span>
                                                            @endif
                                                            
                                                        </td>


                                                    </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body text-center p-5">
                                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                                            </lord-icon>
                                            <div class="mt-4">
                                                <h4 class="mb-3">Opération réussie!</h4>
                                                <p class="text-muted mb-4"> Opération effectuée  avec succès </p>
                                                <div class="hstack gap-2 justify-content-center">
                                                    <a id="closemodal" href="javascript:void(0);" class="btn btn-success  fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            


                            <div id="checkdocuments" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-5">
                                                            <lord-icon src="https://cdn.lordicon.com/hrqwmuhr.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                                                            <div class="mt-4">
                                                                <h4 class="mb-3">Oups, quelque chose s'est mal passé!</h4>
                                                                <p style="color:red;font-weight:bold" class=" mb-4"> L'opportunité n'a pas de carte grise ou d'attestation, merci de les charger!</p>
                                                                <div class="hstack gap-2 justify-content-center">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

    @endsection


    @section('footerCss')

    <style>
       
    </style>

            <!-- JAVASCRIPT -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/js/plugins.js"></script>

    <!-- prismjs plugin -->
    <script src="/assets/libs/prismjs/prism.js"></script>
    <script src="/assets/js/app.js"></script>

    <style>
        .form-control{
            border: 1px solid #5b5b5b !important;
        }

        .requiredfield{
            border: 1px solid #ec2626 !important;
        }

        .invalid{
            border: 1.5px solid red !important;
        }

         .not-active {
            pointer-events: none;
            cursor: default;
            background: #909090 !important;
        }
    </style>
     
    <script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>

    <script>
        var has_cartegrise = '';
        var has_assurance = '';
        var oppid  ="<?php echo $oppid; ?>";

     
    $(document).ready(function () {




         $("#updateOppbtn").click(function(e) {

                                    e.preventDefault();
                                    var hasError = false;
                                    var btnclicked = $(this);
                                    var uploadhaserror = false;
                                    var datasT = new FormData();
                                    var hasErrorupload = new Array();

                                    $('.formtoupdate').find('input, textarea, select').each(function() {
                                        if ($(this).is(':input:file')) {
                                            if ($(this).val() !== '') {
                                                hasErrorupload.push(chech_uploadedfile($(this)));
                                                // i++;
                                            }
                                            datasT.append(this.name, $(this)[0].files[0]);
                                        } else if ($(this).is(':radio')) {
                                            if ($(this).is(':checked')) {
                                                datasT.append(this.name, $(this).val());
                                            }
                                        } else if ($(this).is(':checkbox')) {
                                            if ($(this).is(':checked')) {
                                                $(this).val(1);
                                                datasT.append(this.name, $(this).val());
                                            } else
                                                $(this).val(0);
                                        } else {
                                            datasT.append(this.name, $(this).val());
                                        }
                                    });

                                    $('.requiredField').addClass('fieldtrue');
                                    $('.formtoupdate .requiredField').each(function() {
                                        var i = $(this);
                                        i.siblings('.validate').html('');
                                        if (jQuery.trim($(this).val()) === '') {
                                            hasError = true;
                                            $(this).addClass('invalid');
                                            i.siblings('.validate').html((hasError ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
                                        } else if ($(this).hasClass('email')) {
                                            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                                            if (!emailReg.test(jQuery.trim($(this).val()))) {
                                                hasError = true;
                                                $(this).addClass('invalid');
                                                i.siblings('.validate').html((hasError ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
                                            }
                                        }
                                    });

                                    if (!hasError) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'POST',
                                            data: datasT,
                                            contentType: false,
                                            processData: false,
                                            url: '/update_opportunite',
                                            beforeSend: function() {
                                                btnclicked.removeClass('normalstate');
                                                btnclicked.addClass('is-active');
                                            },
                                            success: function(response) {
                                                if (response == 'inserted') {
                                                    // var button = btnclicked;
                                                    // $('.alert-success').css('display','block');
                                                    $('#basicdatamodal').modal('hide');
                                                    $('#successModal').modal('show');
                                                    // $("input[type=text], textarea, input[type=date], input[type=time] ").val("")

                                                    //  setTimeout(function () {
                                                    //     location.href='/liste_prospection_byagent';
                                                    // }, 3500);
                                                   
                                                }
                                            }
                                        });
                                    }
                                })




                                $("#savenote").click(function(e) {

                                    e.preventDefault();

                                  var resultat_entretien = $("#resultatentretien").val();

                               


                                    var hasError = false;
                                    var btnclicked = $(this);
                                    var uploadhaserror = false;
                                    var datasT = new FormData();
                                    var hasErrorupload = new Array();

                                    $('#createNote').find('input, textarea, select').each(function() {
                                        if ($(this).is(':input:file')) {
                                            if ($(this).val() !== '') {
                                                hasErrorupload.push(chech_uploadedfile($(this)));
                                                i++;
                                            }
                                            datasT.append(this.name, $(this)[0].files[0]);
                                        } else if ($(this).is(':radio')) {
                                            if ($(this).is(':checked')) {
                                                datasT.append(this.name, $(this).val());
                                            }
                                        } else if ($(this).is(':checkbox')) {
                                            if ($(this).is(':checked')) {
                                                $(this).val(1);
                                                datasT.append(this.name, $(this).val());
                                            } else
                                                $(this).val(0);
                                        } else {
                                            datasT.append(this.name, $(this).val());
                                        }
                                    });

                                    $('.requiredField').addClass('fieldtrue');
                                    $('#createNote .requiredField').each(function() {
                                        var i = $(this);
                                        i.siblings('.validate').html('');
                                        if (jQuery.trim($(this).val()) === '') {
                                            hasError = true;
                                            $(this).addClass('invalid');

                                            i.siblings('.validate').html((hasError ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
                                        } else if ($(this).hasClass('email')) {
                                            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                                            if (!emailReg.test(jQuery.trim($(this).val()))) {
                                                hasError = true;
                                                $(this).addClass('invalid');
                                                i.siblings('.validate').html((hasError ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
                                            }
                                        }
                                    });
                                    if(hasError) $('#message').css('display','block');

                                    if (!hasError) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'POST',
                                            data: datasT,
                                            contentType: false,
                                            processData: false,
                                            url: '/registernote',
                                            beforeSend: function() {
                                                $('#savenote').addClass('not-active').html('Patienter...'); 
                                            },
                                            success: function(response) {
                                                if (response == 'inserted') {
                                                    // var button = btnclicked;
                                                    // $('.alert-success').css('display','block');
                                                    $('#successModal').modal('show');
                                                    $("#createNote input[type=text], #createNote textarea, #createNote input[type=date], #createNote input[type=time] ").val("")
                                                    


                                                    $('#message').css('display','none');

                                                    //  setTimeout(function () {
                                                    //     location.href='/liste_prospection_byagent';
                                                    // }, 3500);
                                                   
                                                }else {
                                                    $('#checkdocuments').modal('show');
                                                     $('#savenote').removeClass('not-active').html('Enregistrer la note'); 
                                                }
                                            }
                                        });
                                    }

                                  
                                })
                            });


    $("#closemodal").click(function(e) {           
        $('#savenote').removeClass('not-active').html('Enregistrer la note'); 
     });


        // setInterval(function() {
        //         $.ajax({
        //                 type: 'get',
        //                 data: {oppornuite:oppid},
        //                 url: '/check_cg_assurance',
        //                 success: function(response) {
        //                     console.log(response);

        //                     var arrayresp = response.split('*');
        //                     has_cartegrise =arrayresp[1];
        //                     has_assurance =arrayresp[0];
        //                     console.log('has_cartegrise ' +has_cartegrise);
        //                     console.log('has_assurance ' +has_assurance);


        //                 }
        //             });
        //   }, 1000);

     // $("#resultatentretien").on('change',function(e) {

     //   var selected = $(this).val();

     //       if(selected == gagne && has_cartegrise =='nocardgrise'){
     //        $('#savenote').addClass('not-active');
     //       }


     //       if(selected == gagne && has_assurance =='noassurance'){
     //        $('#savenote').addClass('not-active');
     //       }

     // })


$('input[type="file"]').each(function() {
             // get label text
             // var label = $(this).parents('.form-group').find('label').text();
             // label = (label) ? label : 'Upload File';
             // // wrap the file input
             // $(this).wrap('<div class="input-file"></div>');
             // // display label
             // $(this).before('<span class="btn" style="font-size:13px;width:100%">'+label+'</span>');
             // // we will display selected file here
             // $(this).before('<span class="file-selected"></span> <i style="display:none;color:#f46e23;cursor:pointer" class="icofont-bin"></i> ');

             // file input change listener 
             $(this).change(function(e){
                 // Get this file input value
                 var val = $(this).val();

                 //check if erreur 
                // chech_uploadedfile($(this));
                 if (!chech_uploadedfile($(this))) {
                     //$(this).siblings('.btn').removeClass('invalid');
                     $(this).siblings(".msg_file").html(`Fichiers autorisés: </span>  Pdf - Jpeg - Png - Gif | 8MB/fichier`);
                    
                     // $(this).siblings('.file-selected').css('color','green');
                     //fieduploaderror
                    $(this).siblings(".msg_file").css('display','none');
                    $(this).removeClass('fieduploaderror');
                    $('#updateOppbtn').removeClass('not-active');
                 }else{
                    $(this).siblings(".msg_file").css('display','inline');
                    $(this).siblings(".msg_file").html('Fichiers autorisés: Jpeg - Png | 8MB');
                  //  $(this).siblings('.file-selected').css('color','#f46e23');
                    $(this).addClass('fieduploaderror');
                    $('#updateOppbtn').addClass('not-active');

                 }
                   
                 var filename = val.replace(/^.*[\\\/]/, '');
                 // Display the filename
                 $(this).siblings('.file-selected').html(filename);
                 $(this).siblings('.icofont-bin').css('display','inline-block');
                 
             });
         });

         



 function chech_uploadedfile(selfile){
                                var element = selfile;
                                var hasErrorf = false;
                                var iSize = element[0].files[0].size;
                                var iType = element[0].files[0].type;
                                 var ValidImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
                                if($.inArray(iType, ValidImageTypes) < 0){
                                  element.css({'border':'solid 1px #F00'});
                                  hasErrorf = true;
                                }else{
                                  if(iSize > 2100000){
                                    hasErrorf = true;
                                  }
                                }
                                return hasErrorf;
                              }
     </script>   

     @endsection