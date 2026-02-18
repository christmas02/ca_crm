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

    <style>
        .invalid{
          border:  2px solid #ec2626;  
        }
    </style>

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
                                <h4 class="mb-sm-0">Liste des prospections remontées et importées</h4>

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
                                <div class="card-header" style="margin-bottom: 15px;">
                                    <h5 class="card-title mb-0">Opportunitées remontées et importées</h5>
                                </div>


                                <div id="filterform" class="row gy-4" style="padding-left: 20px;background: #f2f2f2;margin: 15px;">
                                     <h2>FORMULAIRE DE RECHERCHE</h2>
                                    <div class="col-md-2">
                                        <label for="basiInput" class="form-label">Filtrer </label>
                                         <select id="selectfiltre" class="form-select mb-3" aria-label="Default select example" required>
                                            <option selected="selected" disabled="disabled" value="">choisir un filtre</option>
                                            <option value="tel">Telephone</option>
                                            <option value="clientname">Nom ou prenoms</option>
                                            <option value="date_ech">Date Echéance</option>
                                            <option value="canal">Canal</option>
                                        </select>
                                    </div>

                                        <div class="col-md-10">
                                            
                                       
                                        <form id="formnamefield" method="POST" action="/listeprosprectionbyname"  class="col-md-7">
                                            @csrf
                                            <div   style=" display: inline-block;width: 170px;">
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



                                        <form id="formcanalfield" method="POST" action="/listeprosprectionbycanal"  class="col-md-7" style="display:none">
                                            @csrf
                                            <div   style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Canal</label>
                                                    <input id="canal" type="text" name="canal" class="form-control requiredField" id="basiInput" required placeholder="Canal">
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                           

                                        </form>


                                        <form id="formtelfield" method="POST" action="/listeprosprectionbytel"  class="col-md-7" style="display:none">
                                            @csrf
                                            <div   style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Téléphone</label>
                                                    <input id="telfiltre" type="text" name="telfiltre" class="form-control requiredField" id="basiInput" placeholder="Ex: 0101020203">
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                        </form>



                                         <form id="formdatefield" method="POST" action="/listeprosprectionbydate"  class="col-md-7" style="display:none">
                                            @csrf
                                             <input id="hiddenselectedfiltre" type="hidden" name="selectfiltre">
                                            <div  style=" display: inline-block;width: 170px;">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Date debut</label>
                                                        <input id="datefiltre" type="date" name="datefiltredeb" class="form-control requiredField" id="exampleInputdate">
                                                    </div>
                                            </div>

                                            <div  style=" display: inline-block;width: 170px;">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Date fin</label>
                                                        <input id="datefiltre" type="date" name="datefiltrefin" class="form-control requiredField" id="exampleInputdate">
                                                    </div>
                                            </div>

                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>



                                         </form>



                                         </div>

                                         <div id="massaffectationbloc" class="col-md-12" style="margin-top:0px;margin-bottom:15px;display: none;">
                                                <a style="width:150px;display:inline-block;height: 38px;" id="massaffectation" class="btn btn-dark">Affecter en masse </a>
                                                <span style="display:inline-block;margin-left:10px"><span id="nbppopp">0 </span>  opportunités selectionées</span>
                                         </div>

                                        
                                </div>


                                <div class="card-body">
                                    {{-- table table-bordered nowrap table-striped --}}
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>
                                            @if (Session::get('userprivilege') == 'niveau1' ) 
                                            <tr style="background:lightgray;">
                                                <td  colspan="13"><h3 style="text-align:center;">Opportunitées remontées et importées</h3></td>
                                            </tr>
                                            @else
                                            <tr style="background:lightgray;">
                                                <td  colspan="11"><h3 style="text-align:center;">Opportunitées remontées et importées</h3></td>
                                            </tr>
                                            @endif
                                            <tr>
                                                 <th>immatriculation</th>
                                                 <th data-orderable="false"> 
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="cardtableChecker">
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                 </th>
                                                 <th>Nom</th>
                                                 <th>Prenoms</th>
                                                 <th>Echeance</th>
                                                 <th>Telephone 1</th>
                                                 <th>Observation</th> 
                                                  <th>Canal</th> 
                                                 <th>Réalisé par</th>
                                                 <th>Enregistrer le </th>
                                                 <th><i style="font-size: 24px;" class="ri-tools-fill"></i></th>
                                                 {{-- @if (Session::get('userprivilege') == 'niveau1' ) 
                                                 <th>Affecter</th>
                                                 <th>Supprimer</th>
                                                 @endif --}}
                                                 {{-- <th>Details</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($listeprospection as $listeprospection_element)

                                            @if (count($listeprospection_element['affectation'])<=0)
                                            <tr>
                                                
                                                <td>{{$listeprospection_element['plaque_immatriculation'] ?? 'Non defini'}}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOpp" type="checkbox" value="{{$listeprospection_element['id']}}" >
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>

                                                <td>{{$listeprospection_element['nom']}}</td>
                                                <td>{{$listeprospection_element['prenoms']}}</td>
                                                <td data-sort="{{$listeprospection_element['echeance']}}">{{\Carbon\Carbon::parse($listeprospection_element['echeance'])->format('d-m-Y');}}</td>
                                                <td>
                                                    <a href="tel:{{$listeprospection_element['telephone']}}">{{$listeprospection_element['telephone']}}</a>
                                                </td>
                                                <td>

                                                    <div class="dropdown">
                                                                <a href="#" role="button" id="{{$listeprospection_element['id']}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Afficher     <i class="ri-eye-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="{{$listeprospection_element['id']}}" style="padding: 10px;min-width: 300px;border: solid 2px #40518959;">
                                                                    {{$listeprospection_element['observation']}}
                                                                </div>
                                                            </div>



                                                </td>
                                                @if ($listeprospection_element['canal']=='standart')
                                                <td> standard</td>
                                                @else
                                                <td> {{$listeprospection_element['canal']}}</td>
                                                @endif
                                               {{--  <td><img height="50" src="{{$listeprospection_element['urlcarte_grise']}}" alt=""></td>
                                                <td> <a href=""> <img height="50" src="{{$listeprospection_element['url_attestationassurance']}}"> </a></td> --}}
                                                <td>{{$listeprospection_element['agent_terrain']['lastname']??' Non defini'}}</td>
                                                <td data-sort="{{$listeprospection_element['created_at']}}">{{\Carbon\Carbon::parse($listeprospection_element['created_at'])->format('d-m-Y H:i:s');}}</td>
                                                <td>
                                                    {{-- <a class="btn btn-primary" href="/enregister_note_propection/{{$listeprospection_element['id']}}">Commenter</a> --}}


                                                     <div class="dropdown">
                                                                <a href="#" role="button" id="{{$listeprospection_element['id']}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="{{$listeprospection_element['id']}}">
                                                                    <li><a class="dropdown-item" href="/enregister_note_propection/{{$listeprospection_element['id']}}">
                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                    Commenter</a></li>
                                                                 @if (Session::get('userprivilege') == 'niveau1')
                                                                    @if (count($listeprospection_element['affectation'])<=0)
                                                                    <li><a class="dropdown-item attrib_btn" href="#" data-bs-toggle="modal"  data-opp="{{$listeprospection_element['id']}}">
                                                                        <i class=" ri-arrow-left-right-line align-bottom me-2 text-muted"></i>
                                                                    Affecter</a></li>
                                                                    @endif
                                                                    <li class="dropdown-divider"></li>
                                                                    <li><a class="dropdown-item delete_btn" data-opp="{{$listeprospection_element['id']}}" >
                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                    Supprimer</a></li>
                                                                 @endif
                                                                </ul>
                                                            </div>
                                                </td>

                                                {{-- @if (Session::get('userprivilege') == 'niveau1') 
                                                <td>
                                                   
                                                    @if (count($listeprospection_element['affectation'])<=0)
                                                       
                                                          <button type="button" class="btn btn-dark attrib_btn" data-bs-toggle="modal"  data-opp="{{$listeprospection_element['id']}}">Affecter</button>
                                                    @else
                                                      <button type="button" class="btn btn-soft-primary " >Affecté</button>

                                                    @endif

                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger delete_btn"   data-opp="{{$listeprospection_element['id']}}">Supprimer</button>
                                                </td>
                                                @endif --}}
                                                {{-- <td>
                                                    <a class="btn btn-success" href="/prospection_full_details/{{$listeprospection_element['id']}}">Details</a>
                                                </td> --}}
                                            </tr>

                                            @endif



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
                                                                <a href="javascript:void(0);" class="btn btn-success  fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="modal fade" id="firstmodal" aria-hidden="true" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-5">
                                                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#red,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                                            <div class="mt-4 pt-4">
                                                                <h4>Supprimer l'opportunité.</h4>
                                                                <p class="text-muted"> Voulez vraiment faire cette suppression ?</p>
                                                                <!-- Toogle to second dialog -->
                                                                <button class="btn btn-warning" data-bs-dismiss="modal">
                                                                    Non
                                                                </button>
                                                                <button id="canceller" class="btn btn-danger" >
                                                                    Oui 
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>






                

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © ConseilsAssur.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & OVERTECH
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

      <style>
        .not-active {
            pointer-events: none;
            cursor: default;
            background: #909090 !important;
        }
    </style>
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



    <script>

      // $('#finalrequest').find('input')

    

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
                            url : '/attrib_opportunite_mass',
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

             $(document).on('click','.setliv', function(e){
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
                            data: {numopp:currentOpp, id_agent: id_agent, dateaffect: dateaffect},
                            url : '/attrib_opportunite',
                            // data: {donnee:donnee},   
                            beforeSend: function() {
                                        btnclicked.addClass('not-active').html('Patienter...'); 
                                                 $('loading').css('display','block');
                                            },
                            success : function(r) {
                              if(r=='inserted') {
                                $('loading').css('display','none');
                                $('#agentdispo').modal('hide');
                                $('#successModal').modal('show');

                                // setTimeout(function(){
                                //    location.reload(true);
                                // }, 3000);
                                
                              }
                                
                            }
                          })
              }); 




             $(document).on('click','.delete_btn', function(e){
                   e.preventDefault();  
                // currentOpp = $(this).attr('data-opp');
                  var elmt= $(this);
                  $("#firstmodal").modal('show');
                  var selectedOpp=elmt.attr('data-opp');
                  console.log(selectedOpp);
                 $("#canceller").attr("data-delete",selectedOpp); 
            }); 


            

               $(document).on('click','#canceller', function(e){
               e.preventDefault();
      
                var elmt= $(this);
                var todelete=elmt.attr('data-delete');
               // var datas='todelete='+todelete;

                 $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });
                  $.ajax({
                          type: "post",
                          url: "/removeopp",
                          data: {data_rem :todelete},
                          success: function (data) {
                               $('#firstmodal').modal('hide');
                               if(data =='inserted'){
                               location.reload();
                              }
                          }
                  });

                });



          $('#selectfiltre').on('change', function(e) {
               typefiltre = $(this).val();
           
              if (typefiltre == 'tel') {
                  $("#formtelfield").css('display','block');  
                  $("#formdatefield").css('display','none');   
                  $("#formnamefield").css('display','none');   
                   $("#formcanalfield").css('display','none'); 
                  //datasend ={tel:inputTel};
              }
               if (typefiltre == 'clientname') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none');   
                  $("#formnamefield").css('display','block');   
                  $("#formcanalfield").css('display','none'); 
                  //datasend ={tel:inputTel};
              }

               if (typefiltre == 'canal') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none');   
                  $("#formnamefield").css('display','none');   
                  $("#formcanalfield").css('display','block');   
                  
                  //datasend ={tel:inputTel};
              }

              
              if (typefiltre == 'date_ech' || typefiltre == 'date_rel') {
                $('#hiddenselectedfiltre').val(typefiltre);
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','block'); 
                   $("#formnamefield").css('display','none');   
                    $("#formcanalfield").css('display','none'); 
              }  
          })
        </script>
    @stop