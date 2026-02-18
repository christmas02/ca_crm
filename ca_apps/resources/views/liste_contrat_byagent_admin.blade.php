 @extends('layouts.master')
    @section('headerCss')

   <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">


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

    @php

        $affbtnexp='non';
        $usersprivileges = Session::get('userprivilege_list');
        // dd($usersprivileges);
        if (in_array(25, $usersprivileges)) {
            // code...
             $affbtnexp ='oui';
        }
    @endphp

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
                                <h4 class="mb-sm-0">Liste des contrats</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Datatables</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                     {{-- <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">Standard Modal</button> --}}

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Contrats</h5>
                                </div>



                                {{-- <div class="col-md-3">
                                        <label for="basiInput" class="form-label">Filtre </label>
                                         <select id="selectfiltre" class="form-select mb-3" aria-label="Default select example">
                                            <option selected>choisir un filtre</option>
                                            <option value="agent">Agent</option>
                                            <option value="tel">Telephone</option>
                                            <option value="clientname">Nom ou prenoms</option>
                                            <option value="date">Date Relance</option>
                                            
                                        </select>
                                    </div>  --}}

                                <div id="filterform" class="row gy-4" style="padding-left: 20px;background: #f2f2f2;margin: 15px;">
                                     <h2>FORMULAIRE DE RECHERCHE</h2>
                                    <div class="col-md-2">
                                        <label for="basiInput" class="form-label">Filtre </label>
                                         <select id="selectfiltre" class="form-select mb-3" aria-label="Default select example" >
                                            <option value="">choisir un filtre</option>
                                            <option selected value="agent">Agent</option>
                                            <option value="tel">Telephone</option>
                                            <option value="clientname">Nom ou prenoms</option>
                                            <option value="date_ech" >Date echéance</option>
                                            <option value="date_rel">Date relance</option>
                                            <option value="plaque">Plaque immatriculation</option>
                                        </select>
                                    </div>



                                    <div class="col-md-10">

                                    <form id="formnamefield" method="POST" action="/filter_contrat_byclientname_admin"  class="col-md-7" style="display:none">
                                            @csrf
                                            <div   style=" display: inline-block;width: 250px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Nom ou Prénoms</label>
                                                    <input id="namefilter" type="text" name="namefilter" class="form-control requiredField" id="basiInput" required placeholder="Nom ou Prenoms">
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                    </form>


                                    <form id="formplaquefield" method="POST" action="/filter_contrat_byplaque_admin"  class="col-md-7" style="display:none">
                                            @csrf
                                            <div   style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Plaque Immatriculation</label>
                                                    <input id="plaquefilter" type="text" name="plaquefilter" class="form-control requiredField" id="basiInput" required placeholder="Ex: 2345 GU 02">
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                    </form>

                                        


                                        <form id="formtelfield" method="POST" action="/filter_contrat_bytel_admin"  class="col-md-7" style="display:none">
                                            @csrf
                                            <div   style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Téléphone</label>
                                                    <input id="telfiltre" type="text" name="telfiltre" class="form-control requiredField " id="basiInput" required placeholder="Ex: 0101020203">
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                        </form>

                                         <form id="formdatefield" method="POST" action="/filter_contrat_echeance_admin"  class="col-md-7" style="display:none">

                                            @csrf
                                        <input id="hiddenselectedfiltre" type="hidden" name="selectfiltre" value="date_ech">
                                            <div  style=" display: inline-block;width: 170px;">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Date debut</label>
                                                        <input id="datefiltre_deb" type="date" name="datefiltre_deb" class="form-control requiredField" id="exampleInputdate" required>
                                                    </div>
                                            </div>
                                            <div  style=" display: inline-block;width: 170px;">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Date fin</label>
                                                        <input id="datefiltre_fin" type="date" name="datefiltre_fin" class="form-control requiredField" id="exampleInputdate" required>
                                                    </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                        </form>

                                        <form id="formdaterelfield" method="POST" action="/filter_contrat_relance_admin"  class="col-md-7" style="display:none">

                                            @csrf
                                        <input id="hiddenselectedfiltre" type="hidden" name="selectfiltre" value="date_ech">
                                            <div  style=" display: inline-block;width: 170px;">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Date debut</label>
                                                        <input id="datefiltrel_deb" type="date" name="datefiltrel_deb" class="form-control requiredField" id="exampleInputdate" required>
                                                    </div>
                                            </div>
                                            <div  style=" display: inline-block;width: 170px;">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Date fin</label>
                                                        <input id="datefiltrel_fin" type="date" name="datefiltrel_fin" class="form-control requiredField" id="exampleInputdate" required>
                                                    </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                        </form>




                                        <form id="formagentfield" method="POST" action="/filter_contrat_byagent_admin"  class="col-md-10">
                                            @csrf

                                             <div class="col-md-3" style=" display: inline-block;margin-right:15px;">
                                                <label for="basiInput" class="form-label"> Agents </label>
                                                 <select id="selectagent" name="selectagent" class="form-select mb-3" aria-label="Default select example" required>
                                                    <option selected>choisir un agent</option>
                                                    <option value="tous"> TOUS</option>
                                                    @foreach ($listecommerciaux as $listecommerciaux_el)
                                                        {{-- expr --}}
                                                         <option value="{{$listecommerciaux_el['id']}}">{{strtoupper($listecommerciaux_el['firstname'].' ' .$listecommerciaux_el['lastname'])}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date debut</label>
                                                    <input id="datedebut" type="date" name="datedebut" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 

                                            <div   style=" display: inline-block;width: 170px;margin-left: 20px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date fin</label>
                                                    <input id="datefin" type="date" name="datefin" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                             {{-- <a href="/liste_contrat_byagent_admin" style="width:120px" class="btn btn-success">Reinitialiser</a> --}}


                                            
 
                                        </form>
                                        </div> 


                                        <div id="massaffectationbloc" class="col-md-12" style="margin-top:0px;margin-bottom:15px;display: none;">
                                                <a style="width:170px;display:inline-block;height: 38px;" id="massaffectation" class="btn btn-dark">Reaffecter en masse </a>
                                                <span style="display:inline-block;margin-left:10px"><span id="nbppopp">0 </span>  opportunités selectionées</span>
                                         </div>
                                        
                                </div>



                                <div class="card-body">
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>
                                      @if (!empty($foundagent) )
                                      <tr style="background:lightgray;">
                                                <td  colspan="13"><h4 style="text-align:center;">Affectations AN/RN - Filtre - [ {{$foundagent[0]['firstname'].' '.$foundagent[0]['lastname']}}]<span style="font-weight:bold">ECHEANCE DEBUT:</span> <span>{{\Carbon\Carbon::parse($datedebut)->format('d-m-Y')}}</span> <span style="font-weight:bold">ECHEANCE FIN: </span> <span>{{\Carbon\Carbon::parse($datefin)->format('d-m-Y')}}</span></h4></td>
                                            </tr>

                                        @elseif (!empty($selectedagent) && $selectedagent == 'tous')
                                      <tr style="background:lightgray;">
                                                <td  colspan="13"><h4 style="text-align:center;">Affectations AN/RN - Filtre - [Tous] <span style="font-weight:bold">ECHEANCE DEBUT:</span> <span>{{\Carbon\Carbon::parse($datedebut)->format('d-m-Y')}}</span> <span style="font-weight:bold">ECHEANCE FIN: </span> <span>{{\Carbon\Carbon::parse($datefin)->format('d-m-Y')}}</span></h4></td>
                                            </tr>


                                        @elseif (!empty($telfiltre) )
                                            <tr style="background:lightgray;">
                                                    <td  colspan="13"><h4 style="text-align:center;">Affectations AN/RN - Filtre - [Telephone] : <span style="font-weight:bold">{{$telfiltre}}</span></h4></td>
                                                </tr> 


                                         @elseif (!empty($namefilter) )
                                            <tr style="background:lightgray;">
                                                    <td  colspan="13"><h4 style="text-align:center;">Affectations AN/RN - Filtre - [Nom ou Prénom] : <span style="font-weight:bold">{{$namefilter}}</span></h4></td>
                                                </tr>

                                        
                                         @elseif (!empty($plaquefilter) )
                                            <tr style="background:lightgray;">
                                                    <td  colspan="14"><h4 style="text-align:center;">Affectations AN/RN - Filtre - [Plaque] : <span style="font-weight:bold">{{$plaquefilter}}</span></h4></td>
                                                </tr>



                                        @elseif (!empty($datefiltre_deb) && !empty($datefiltre_fin) )
                                            <tr style="background:lightgray;">
                                                    <td  colspan="14"><h4 style="text-align:center;">Affectations AN/RN - Filtre - [Date echeance] :  <span style="font-weight:bold">ECHEANCE DEBUT:</span> <span>{{\Carbon\Carbon::parse($datefiltre_deb)->format('d-m-Y')}}</span> <span style="font-weight:bold">ECHEANCE FIN: </span> <span>{{\Carbon\Carbon::parse($datefiltre_fin)->format('d-m-Y')}}</span></h4></td>
                                                </tr>


                                        @elseif (!empty($datefiltrel_fin) && !empty($datefiltrel_deb) )
                                            <tr style="background:lightgray;">
                                                    <td  colspan="14"><h4 style="text-align:center;">Affectations AN/RN - Filtre - [Date relance] :  <span style="font-weight:bold">RELANCE DEBUT:</span> <span>{{\Carbon\Carbon::parse($datefiltrel_deb)->format('d-m-Y')}}</span> <span style="font-weight:bold">RELANCE FIN: </span> <span>{{\Carbon\Carbon::parse($datefiltrel_fin)->format('d-m-Y')}}</span></h4></td>
                                                </tr>





                                         @else 

                                         <tr style="background:lightgray;">
                                                <td  colspan="15"><h3 style="text-align:center;">Affectations AN/RN</h3></td>
                                            </tr>

                                        @endif

                                            <tr>
                                                 <th> Police</th>
                                                  <th>Plaque Immatriculation</th>
                                                  <th data-orderable="false"> 
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="cardtableChecker">
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                 </th>
                                                 
                                                 <th>Nom</th>
                                                 <th>Prenoms</th>
                                                 <th>Echeance</th>
                                                 <th>Relance</th>
                                                 <th>Tel</th>
                                                 <th>Period</th> 
                                                 <th>Statut</th> 
                                                 <th>Prime NETTE </th> 
                                                 <th>Prime TTC </th> 
                                                 <th>Sousc.par</th>
                                                 <th>Enregistrer le </th>
                                                   <th><i style="font-size: 24px;" class="ri-tools-fill"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                         

                                          @foreach ($listeprospection as $listeprospection_element)


                                            <tr>
                                                
                                                <td>{{$listeprospection_element['numpolice']}}</td>
                                                <td>{{$listeprospection_element['opportunite']['plaque_immatriculation']}}</td>
                                                 <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOpp" type="checkbox" value="{{$listeprospection_element['opportunite']['id'] .'|'. $listeprospection_element['commentaire']['echeance'] .'|'. \Carbon\Carbon::parse($listeprospection_element['commentaire']['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($listeprospection_element['commentaire']['heure_relance'])->format('H:i:s').'|'. $listeprospection_element['commentaire']['primenet'].'|'. $listeprospection_element['commentaire']['primettc'].'|'. $listeprospection_element['commentaire']['periode_soucription'].'|'. $listeprospection_element['commentaire']['assureur_actuel']}}" id="cardtableCheck01">
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td> 

                                                <td>{{$listeprospection_element['opportunite']['nom']}}</td>
                                                <td>{{$listeprospection_element['opportunite']['prenoms']}}</td>

                                                @if ($listeprospection_element['commentaire']['echeance'] != null)
                                                 
                                                <td data-sort="{{$listeprospection_element['commentaire']['echeance']}}">{{\Carbon\Carbon::parse($listeprospection_element['commentaire']['echeance'])->format('d-m-Y ');}}</td>
                                                @else
                                                <td> - </td>
                                                @endif
                                                 <td data-sort="{{$listeprospection_element['commentaire']['daterelance']}}">{{\Carbon\Carbon::parse($listeprospection_element['commentaire']['daterelance'])->format('d-m-Y');}}</td>
                                              

                                                <td>

                                                    <a href="tel:{{$listeprospection_element['opportunite']['telephone']}}">{{$listeprospection_element['opportunite']['telephone']}}</a>


                                                </td>
                                                <td>{{$listeprospection_element['commentaire']['periode_soucription']}}</td>
                                                <td> 
                                                    
                                                   
                                                    @if (!empty($listeprospection_element['commentaire'] && count($listeprospection_element['commentaire']) > 0))
                                                        {{-- expr --}}
                                                   

                                                         @if ($listeprospection_element['commentaire']['resultat'] == 'horscible_rn')
                                                            <span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_element['commentaire']['resultat']}}</span>
                                                          @endif

                                                           @if ($listeprospection_element['commentaire']['resultat'] == 'reporte_rn')
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_element['commentaire']['resultat']}}</span>

                                                         @endif


                                                          @if ($listeprospection_element['commentaire']['resultat']== 'perdu_rn')
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_element['commentaire']['resultat']}}</span>

                                                         @endif



                                                          @if ($listeprospection_element['commentaire']['resultat']== 'poursuivre_rn')
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_element['commentaire']['resultat']}}</span>

                                                         @endif

                                                         @if ($listeprospection_element['commentaire']['resultat']== 'rdvsouscription_rn')
                                                            <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> {{$liste_relances_element['resultat']}}</span>

                                                         @endif


                                                         @if ($listeprospection_element['commentaire']['resultat']== 'gagne')
                                                           {{--  <div class="alert alert-success text-center display-6" role="alert">
                                                                <b style="text-transform: uppercase;"></b> 
                                                            </div> --}}

                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_element['commentaire']['resultat']}}</span>

                                                         @endif

                                                     @else

                                                      <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> Opportunité Nouvelle</span>

                                                      @endif
                                                </td>
                                                <td>{{$listeprospection_element['commentaire']['primenet']}}</td>
                                                <td>{{$listeprospection_element['commentaire']['primettc']}}</td>
                                              
                                                <td>{{$listeprospection_element['commentaire']['agent_backoffice']['firstname'].' ' .$listeprospection_element['commentaire']['agent_backoffice']['lastname']}}</td>
                                                <td data-sort="{{$listeprospection_element['created_at']}}">{{\Carbon\Carbon::parse($listeprospection_element['created_at'])->format('d-m-Y H:i');}}</td>
                                                <td>
                                                    {{-- <a class="btn btn-primary" href="/enregister_note_propection/{{$listeprospection_element['opportunite']['id']}}">Commenter</a> --}}


                                                     <div class="dropdown">
                                                                <a href="#" role="button" id="{{$listeprospection_element['opportunite']['id']}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="{{$listeprospection_element['opportunite']['id']}}">
                                                                    <li> <a class="dropdown-item" href="/enregister_note_propection/{{$listeprospection_element['opportunite']['id']}}"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Commenter</a></li>
                                                                    <li><a class="dropdown-item " href="/prospection_full_details/{{$listeprospection_element['opportunite']['id']}}">  <i class=" ri-list-check align-bottom me-2 text-muted"></i> Details</a></li>

                                                                    <li> <a class="dropdown-item histo_rn_btn"href="#"data-opp="{{$listeprospection_element['opportunite']['id']}}"> <i class="ri-stack-line align-bottom me-2 text-muted"></i> Historique RN</a></li>

                                                                     <li><a class="dropdown-item attrib_btn" href="#" data-bs-toggle="modal"  data-opp="{{$listeprospection_element['opportunite']['id'] .'|'. $listeprospection_element['commentaire']['echeance'] .'|'. \Carbon\Carbon::parse($listeprospection_element['commentaire']['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($listeprospection_element['commentaire']['heure_relance'])->format('H:i:s')}}">  <i class=" ri-arrow-left-right-line align-bottom me-2 text-muted"></i> Reaffecter</a></li>



                                                                    {{-- <li><a class="dropdown-item" href="tables-basic.html#">Delete</a></li> --}}
                                                                </ul>
                                                            </div>



                                                </td>

                                               
                                               {{--  <td>
                                                    <a class="btn btn-success" href="/prospection_full_details/{{$listeprospection_element['opportunite']['id']}}">Details</a>



                                                </td> --}}
                                            </tr>
                                          @endforeach

                                       

                                          @foreach ($listeprospection_nc as $listeprospection_nc_elm)
                                                <tr>
                                                <td> - </td> 
                                                <td>{{$listeprospection_nc_elm['opportunite']['plaque_immatriculation']}} </td>

                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOpp" type="checkbox" value="{{$listeprospection_nc_elm['opportunite']['id'] .'|'. $listeprospection_nc_elm['echeance'] .'|'. \Carbon\Carbon::parse($listeprospection_nc_elm['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($listeprospection_nc_elm['heure_relance'])->format('H:i:s').'|'. $listeprospection_nc_elm['primenet'].'|'. $listeprospection_nc_elm['primettc'].'|'. $listeprospection_nc_elm['periode_soucription'].'|'. $listeprospection_nc_elm['assureur_actuel']}}" id="cardtableCheck01">
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>

                                                </td>
                                                 
                                               
                                                <td>{{$listeprospection_nc_elm['opportunite']['nom']}}</td>
                                                <td>{{$listeprospection_nc_elm['opportunite']['prenoms']}}</td>

                                                @if ($listeprospection_nc_elm['echeance'] != null)
                                                 
                                                <td data-sort="{{$listeprospection_nc_elm['echeance']}}">{{\Carbon\Carbon::parse($listeprospection_nc_elm['echeance'])->format('d-m-Y ');}}</td>
                                                @else
                                                <td> - </td>
                                                @endif
                                                 <td data-sort="{{$listeprospection_nc_elm['daterelance']}}">{{\Carbon\Carbon::parse($listeprospection_nc_elm['daterelance'])->format('d-m-Y ');}}</td>
                                                <td>
                                                     <a href="tel:{{$listeprospection_nc_elm['opportunite']['telephone']}}">{{$listeprospection_nc_elm['opportunite']['telephone']}}</a>
                                                </td>
                                                <td>{{$listeprospection_nc_elm['periode_soucription']}}</td>


                                                <td> 
                                                    
                                                   
                                                    {{-- @if (!empty($listeprospection_nc_elm['commentaire'] && count($listeprospection_nc_elm['commentaire']) > 0)) --}}
                                                        {{-- expr --}}
                                                   

                                                         @if ($listeprospection_nc_elm['resultat'] == 'horscible_rn')
                                                            <span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_nc_elm['resultat']}}</span>
                                                          @endif

                                                           @if ($listeprospection_nc_elm['resultat'] == 'reporte_rn')
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_nc_elm['resultat']}}</span>

                                                         @endif


                                                          @if ($listeprospection_nc_elm['resultat']== 'perdu_rn')
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_nc_elm['resultat']}}</span>

                                                         @endif



                                                          @if ($listeprospection_nc_elm['resultat']== 'poursuivre_rn')
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_nc_elm['resultat']}}</span>

                                                         @endif


                                                          @if ($listeprospection_nc_elm['resultat']== 'rdvsouscription_rn')
                                                            <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_nc_elm['resultat']}}</span>

                                                         @endif

                                                         


                                                         @if ($listeprospection_nc_elm['resultat']== 'gagne')
                                                           {{--  <div class="alert alert-success text-center display-6" role="alert">
                                                                <b style="text-transform: uppercase;"></b> 
                                                            </div> --}}

                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> {{$listeprospection_nc_elm['resultat']}}</span>

                                                         @endif

                                                    {{--  @else

                                                      <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> Opportunité Nouvelle</span>

                                                      @endif --}}
                                                </td>


                                                <td>{{$listeprospection_nc_elm['primenet']}}</td>
                                                <td>{{$listeprospection_nc_elm['primettc']}}</td>
                                                <td>{{$listeprospection_nc_elm['agent_backoffice']['firstname'].' ' .$listeprospection_nc_elm['agent_backoffice']['lastname']}}</td>
                                                <td>{{\Carbon\Carbon::parse($listeprospection_nc_elm['created_at'])->format('d-m-Y H:i');}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                                <a href="#" role="button" id="{{$listeprospection_nc_elm['opportunite']['id']}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="{{$listeprospection_nc_elm['opportunite']['id']}}">
                                                                    <li> <a class="dropdown-item" href="/enregister_note_propection/{{$listeprospection_nc_elm['opportunite']['id']}}"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Commenter</a></li>
                                                                    <li><a class="dropdown-item attrib_btn" href="/prospection_full_details/{{$listeprospection_nc_elm['opportunite']['id']}}">  <i class=" ri-list-check align-bottom me-2 text-muted"></i> Details</a></li>

                                                                    <li> <a class="dropdown-item histo_rn_btn"href="#"data-opp="{{$listeprospection_nc_elm['opportunite']['id']}}"> <i class="ri-stack-line align-bottom me-2 text-muted"></i> Historique RN</a></li>
                                                                   
                                                                </ul>
                                                            </div>
                                                </td>
                                                 {{--<td>
                                                    <a class="btn btn-success" href="/prospection_full_details/{{$listeprospection_nc_elm['opportunite']['id']}}">Details</a> 


                                                    

                                                </td>--}}
                                            </tr>
                                          @endforeach
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->


                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


                                        <div>
                                            <div id="agentdispo" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Affectation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="content_liv_pop">
                                                           
                                                            <table class="table table-nowrap">
                                                            <tr style="background:#e2e2e2;">
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold">MOISE DE KOTCHY </span>
                                                                    <span style="display:block;"> 10 opportunités en cours</span>
                                                                </td>
                                                                <td style="text-align:right;padding-right: 10px;"><a class="btn btn-primary"  href="">Attribuer</a></td>
                                                            </tr>
                                                            <tr >
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold">MOISE DE KOTCHY </span>
                                                                    <span style="display:block;"> 10 opportunités en cours</span>
                                                                </td>
                                                                <td style="text-align:right;padding-right: 10px;"><a class="btn btn-primary" href="">Attribuer</a></td>
                                                            </tr>
                                                        </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                           {{--  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary ">Save Changes</button> --}}
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>



                                        <!-- Static Backdrop -->
                                        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Static Backdrop Modal
                                        </button> --}}
                                        <!-- staticBackdrop Modal -->
                                        <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center p-5">
                                                        <lord-icon
                                                            src="https://cdn.lordicon.com/lupuorrc.json"
                                                            trigger="loop"
                                                            colors="primary:#121331,secondary:#08a88a"
                                                            style="width:120px;height:120px">
                                                        </lord-icon>
                                                        
                                                        <div class="mt-4">
                                                            <h4 class="mb-3">Opération réussie!</h4>
                                                            <p class="text-muted mb-4"> L'affectation s'est effectuées avec succès </p>
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                                <a href="javascript:void(0);" class="btn btn-success">OK</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div>
                                            <div id="show_histo_rn" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Historique RN</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="content_histo_rn">
                                                           
                                                            <table class="table table-nowrap">
                                                            <tr style="background:#e2e2e2;">
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold">Veuillez patienter...</span>
                                                                </td>
                                                               
                                                            </tr>
                                                            
                                                        </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                           {{--  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary ">Save Changes</button> --}}
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>


                                        <div>
                                            <div id="agentdispo_mass" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Affectation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="content_liv_pop_mass">
                                                           
                                                            <table class="table table-nowrap">
                                                            <tr style="background:#e2e2e2;">
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold;text-align:center">Veuillez patienter...</span>
                                                                   
                                                                </td>
                                                                
                                                            </tr>
                                                           
                                                        </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                           {{--  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary ">Save Changes</button> --}}
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>






                

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Velzon.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Themesbrand
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
     @stop



    

    <!-- JAVASCRIPT -->
    @section('footerCss')
        <!-- JAVASCRIPT -->

        <script type="text/javascript">
         var affibtn = '<?php echo $affbtnexp;?>';
        </script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/js/plugins.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="/assets/js/pages/datatables.init.js"></script>
    <!-- App js -->
    <script src="/assets/js/app.js"></script>
        <script src="/assets/js/app.js"></script>


        <script>

            var currentOpp =0;
             $(document).on('click','.attrib_btn', function(e){
                   e.preventDefault();  
                 currentOpp = $(this).attr('data-opp');
                   
               $.ajax({
                type : "GET",
                url : '/find_available_agent',
                // data: {donnee:donnee},   
                success : function(r) {
                  $('#content_liv_pop').html(r);
                  $('#agentdispo').modal('show');
                  $('#numcom').html(currentOpp);
                }
              })
            });   


               $(document).on('click','.histo_rn_btn', function(e){
                   e.preventDefault();  
                 currentOpp = $(this).attr('data-opp');

             $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                   
               $.ajax({
                type : "POST",
                url : '/find_histo_rn',
                data: {idopp:currentOpp},   
                success : function(r) {
                  $('#content_histo_rn').html(r);
                  $('#show_histo_rn').modal('show');
                  // $('#numcom').html(currentOpp);
                }
              })
            }); 



             // $(document).on('click','.setliv', function(e){
             //       e.preventDefault();  
             //       // var numcmd = $(this).attr('data-com');
             //       var id_agent = $(this).attr('data-idagent');

             //             $.ajaxSetup({
             //                  headers: {
             //                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             //                  }
             //              });

             //               $.ajax({
             //                type : "POST",
             //                data: {numopp:currentOpp, id_agent: id_agent},
             //                url : '/attrib_opportunite',
             //                // data: {donnee:donnee},   
             //                success : function(r) {
             //                  if(r=='inserted') {
             //                    $('#agentdispo').modal('hide');
             //                    $('#successModal').modal('show');
             //                    setTimeout(function(){
             //                       location.reload(true);
             //                    }, 3000);
                                
             //                  }
                                
             //                }
             //              })
             //  });   




             $(document).on('click','.setliv', function(e){
                   e.preventDefault();  
                   // var numcmd = $(this).attr('data-com');
                   var id_agent = $(this).attr('data-idagent');
                   var dateaffect = $('input[name="dateaffect"]').val();

                         $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                           $.ajax({
                            type : "POST",
                            data: {numopp:currentOpp, id_agent: id_agent, dateaffect: dateaffect},
                            url : '/reaff_newnote_rn',
                            // data: {donnee:donnee},   
                            success : function(r) {
                              if(r=='inserted') {
                                $('#agentdispo').modal('hide');
                                $('#successModal').modal('show');
                                setTimeout(function(){
                                   location.reload(true);
                                }, 3000);
                                
                              }
                                
                            }
                          })
              });  
                        
          $('#selectfiltre').on('change', function(e) {
               typefiltre = $(this).val();

    
              if (typefiltre == 'date_rel' ) {

                 $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none');   
                  $("#formnamefield").css('display','none'); 
                  $("#formagentfield").css('display','none'); 
                   $("#formplaquefield").css('display','none'); 
                     $("#formdaterelfield").css('display','block');
              }
           
              if (typefiltre == 'tel') {
                  $("#formtelfield").css('display','block');  
                  $("#formdatefield").css('display','none');   
                  $("#formnamefield").css('display','none'); 
                  $("#formagentfield").css('display','none'); 
                   $("#formplaquefield").css('display','none'); 
                     $("#formdaterelfield").css('display','none');
                  //datasend ={tel:inputTel};
              }
               if (typefiltre == 'date_ech' ) {
                 $('#hiddenselectedfiltre').val(typefiltre);
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','block'); 
                   $("#formnamefield").css('display','none'); 
                    $("#formagentfield").css('display','none'); 
                     $("#formplaquefield").css('display','none'); 
                      $("#formdaterelfield").css('display','none');
              } 


              if (typefiltre == 'agent') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none'); 
                 $("#formagentfield").css('display','block'); 
                 $("#formnamefield").css('display','none'); 
                   $("#formplaquefield").css('display','none'); 
                    $("#formdaterelfield").css('display','none');
              }  


               if (typefiltre == 'clientname') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none'); 
                 $("#formagentfield").css('display','none'); 
                 $("#formnamefield").css('display','block'); 
                  $("#formplaquefield").css('display','none');
                   $("#formdaterelfield").css('display','none');    
              } 


               if (typefiltre == 'plaque') {
                 $("#formtelfield").css('display','none');  
                 $("#formdatefield").css('display','none'); 
                 $("#formagentfield").css('display','none'); 
                 $("#formplaquefield").css('display','block'); 
                 $("#formnamefield").css('display','none');
                 $("#formdaterelfield").css('display','none');  
                  
              } 
              

              
          })



         var liste_opp = [];
        $(document).on('click','#massaffectation', function(e){
                $.ajax({
                        type : "GET",
                        url : '/find_available_agent_mass',
                        success : function(r) {
                          $('#content_liv_pop_mass').html(r);
                        }
                      })

             $('#agentdispo_mass').modal('show');

        })

          $('#cardtableChecker').change(function() {
                if(this.checked) {
                     $('.checkboxOpp:visible').prop('checked', true);
                      // liste_opp.push($(this).val());
                         liste_opp = [];
                        $('.checkboxOpp:visible').each(function() {
                             liste_opp.push($(this).val());
                        });

                         $("#nbppopp").html(liste_opp.length);
                      $("#massaffectationbloc").css("display",'block'); 
                }else{
                    liste_opp = [];
                 $('.checkboxOpp:visible').prop('checked', false);  
                 $("#massaffectationbloc").css("display",'none');     
                }
            }); 


          $('.checkboxOpp').each(function() {
                var el =$(this);

            el.on('change', function(e) {
                var element =  $(this).val();
                         if(this.checked) {
                            liste_opp.push($(this).val());
                            if(liste_opp.length > 1){
                                $("#massaffectationbloc").css("display",'block');
                                $("#nbppopp").html(liste_opp.length);
                            }else
                             $("#massaffectationbloc").css("display",'none');
                         }else{
                            liste_opp = jQuery.grep(liste_opp, function (value) {
                                return value != element;
                            });
                            $("#nbppopp").html(liste_opp.length);
                            if(liste_opp.length <= 1){
                                $("#massaffectationbloc").css("display",'none');
                                $("#nbppopp").html(0);

                            }

                         }
                })
            })



           $(document).on('click','.setlivmass', function(e){
                   e.preventDefault();  
                   // var numcmd = $(this).attr('data-com');
                   var id_agent = $(this).attr('data-idagent');
                   var btnclicked = $(this);
                   var dateaffect = $('input[name="dateaffect"]').val();

                         $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                           $.ajax({
                            type : "POST",
                            data: {arraylist:liste_opp, id_agent: id_agent,dateaffect: dateaffect},
                            url : '/reaff_newnote_mass_rn',
                            // data: {donnee:donnee},   
                            beforeSend: function() {
                                                btnclicked.addClass('not-active').html('Patienter...'); 
                                            },
                            success : function(r) {
                              if(r=='inserted') {
                                liste_opp = [];
                                $('#agentdispo_mass').modal('hide');
                                $('#successModal').modal('show');
                                setTimeout(function(){
                                   location.reload(true);
                                }, 3000);
                                
                              }
                                
                            }
                          })
              }); 


        </script>
    @stop