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
                                <h4 class="mb-sm-0">RELANCES EN COURS</h4>

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
                                    <h5 class="card-title mb-0">Enregistrements</h5>
                                </div>


                                <div id="filterform" class="row gy-4" style="padding-left: 20px;background: #f2f2f2;margin: 15px;">
                                     <h2>FORMULAIRE DE RECHERCHE</h2>
                                     <div class="col-md-2">
                                        <label for="basiInput" class="form-label">Filtre </label>
                                         <select id="selectfiltre" class="form-select mb-3" aria-label="Default select example">
                                            <option selected>choisir un filtre</option>
                                            <option value="agent">Agent</option>
                                            <option value="tel">Telephone</option>
                                            <option value="date">Date Relance</option>
                                            
                                        </select>
                                    </div> 

                                      <div class="col-md-10">
                                      

                                      {{-- /listeprosprectionbytel_agent --}}
                                      <form id="formtelfield" method="POST" action="/filter_relance_tel_admin"  class="col-md-7" style="display:none;">
                                            @csrf
                                            <div   style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Téléphone</label>
                                                    <input id="telfiltre" type="text" name="telfiltre" class="form-control requiredField numberonly" id="basiInput" required placeholder="Ex: 0101020203">
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>
                                     </form>

                                    <form id="formdatefield" method="POST" action="/filter_relance_echeance_admin"  class="col-md-7" style="display:none">
                                            @csrf
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
                                    </form> 



                                         <form id="formagentfield" method="POST" action="/filter_relance_admin"  class="col-md-10">
                                            @csrf

                                             <div class="col-md-2" style=" display: inline-block;margin-right:15px;">
                                                <label for="basiInput" class="form-label"> Agents </label>
                                                 <select id="selectagent" name="selectagent" class="form-select mb-3" aria-label="Default select example" required>
                                                    <option selected>choisir un agent</option>
                                                    <option value="tous">TOUS</option>
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

                                             {{-- <a href="/liste_prosprection_created_online" style="width:200px" class="btn btn-success">Reinitialiser</a> --}}

                                             <a style="width:155px;display: none;height: 37px;" id="massaffectation"   class="btn btn-dark">Affecter en masse </a>
 
                                        </form> 



                                        </div>
                                         
                                        
                                </div>

                                
                                <div class="card-body">
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>
                                            <tr style="background:lightgray;">
                                                <td  colspan="13"><h3 style="text-align:center;">Recherche Relance en cours , critère [Téléphone ]: {{$tel}} </h3></td>
                                            </tr>
                                            <tr>
                                                 {{-- <th>id</th> --}}
                                                 <th data-orderable="false"> 
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="cardtableChecker">
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                 </th>
                                                 <th>Nom</th>
                                                 <th>Prenoms</th>
                                                 <th>Echeance</th>
                                                 <th>Date Relance</th>
                                                 <th>Heure Relance</th>
                                                 <th>Telephone</th>
                                                 <th>Observation</th> 
                                                 <th>Agent en charge</th>
                                                 <th>Commenter</th>
                                                 <th>Reaffecter</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                          
                                          @foreach ($listeprospection as $listeprospection_element)

                                            
                                          @if (!empty($listeprospection_element['commentaires']));
                                             
                                           @if ($listeprospection_element['commentaires'][0]['resultat'] != 'perdu' || $listeprospection_element['commentaires'][0]['resultat'] != 'horscible')

                                            <tr>
                                                
                                                {{-- <td>{{$listeprospection_element['id']}}</td> --}}
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOpp" type="checkbox" value="{{$listeprospection_element['id'] .'|'. $listeprospection_element['commentaires'][0]['echeance'] .'|'. \Carbon\Carbon::parse($listeprospection_element['commentaires'][0]['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($listeprospection_element['commentaires'][0]['heure_relance'])->format('H:i:s')}}" >
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>
                                                <td>{{$listeprospection_element['nom']}}</td>
                                                <td>{{$listeprospection_element['prenoms']}}</td>
                                                <td>{{\Carbon\Carbon::parse($listeprospection_element['commentaires'][0]['echeance'])->format('d-m-Y H:i');}}</td>
                                                <td>{{\Carbon\Carbon::parse($listeprospection_element['commentaires'][0]['daterelance'])->format('d-m-Y H:i');}}</td>
                                                 <td>{{\Carbon\Carbon::parse($listeprospection_element['commentaires'][0]['heure_relance'])->format(' H:i:s');}}</td>
                                                <td>{{$listeprospection_element['telephone']}}</td>
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

                                                <td>{{$listeprospection_element['commentaires'][0]['agent_backoffice']['firstname'].' '.$listeprospection_element['commentaires'][0]['agent_backoffice']['lastname']}}</td>
                                                {{-- <td>{{\Carbon\Carbon::parse($listeprospection_element['created_at'])->format('d-m-Y ');}}</td> --}}
                                                <td>
                                                    <a class="btn btn-primary" href="/enregister_note_propection/{{$listeprospection_element['id']}}">Commenter</a>
                                                </td>

                                                 <td>
                                                          <button type="button" class="btn btn-dark attrib_btn" data-bs-toggle="modal"  data-opp="{{$listeprospection_element['id'] .'|'. $listeprospection_element['commentaires'][0]['echeance'] .'|'. \Carbon\Carbon::parse($listeprospection_element['commentaires'][0]['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($listeprospection_element['commentaires'][0]['heure_relance'])->format('H:i:s')}}">Reaffecter</button>
                                                </td>
                                            </tr>
                                            @endif
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



             $(document).on('click','.setliv', function(e){
                   e.preventDefault();  
                   // var numcmd = $(this).attr('data-com');
                   var id_agent = $(this).attr('data-idagent');

                         $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                           $.ajax({
                            type : "POST",
                            data: {numopp:currentOpp, id_agent: id_agent},
                            url : '/reaff_newnote',
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
           
              if (typefiltre == 'tel') {
                  $("#formtelfield").css('display','block');  
                   $("#formagentfield").css('display','none'); 
                  $("#formdatefield").css('display','none');   
                  //datasend ={tel:inputTel};
              }
              if (typefiltre == 'date') {
                  $("#formtelfield").css('display','none');  
                   $("#formagentfield").css('display','none'); 
                  $("#formdatefield").css('display','block'); 
              } 

              if (typefiltre == 'agent') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none'); 
                 $("#formagentfield").css('display','block'); 
                  
              }   


              
          })     


          var liste_opp = [];
        $(document).on('click','#massaffectation', function(e){
         
            $('.checkboxOpp').each(function() {
                 if(this.checked) {
                    liste_opp.push($(this).val());
                    console.log(liste_opp);
                    $.ajax({
                        type : "GET",
                        url : '/find_available_agent_mass',
                        success : function(r) {
                          $('#content_liv_pop_mass').html(r);
                          $('#agentdispo_mass').modal('show');
                         
                        }
                      })

                 }
            
            })

        })


        $(document).on('click','.setlivmass', function(e){
                   e.preventDefault();  
                   // var numcmd = $(this).attr('data-com');
                   var id_agent = $(this).attr('data-idagent');
                   var btnclicked = $(this);

                         $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                           $.ajax({
                            type : "POST",
                            data: {arraylist:liste_opp, id_agent: id_agent},
                            url : '/reaff_newnote_mass',
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


        $('#cardtableChecker').change(function() {
                if(this.checked) {
                     $('.checkboxOpp:visible').prop('checked', true);

                      $("#massaffectation").css("display",'inline-block'); 
                }else{
                 $('.checkboxOpp:visible').prop('checked', false);  
                 $("#massaffectation").css("display",'none');     
                }
            });

            $('.checkboxOpp').each(function() {
                var el =$(this);

            el.on('change', function(e) {
                console.log('bonjour');
                // $('#cardtableChecker').change(function() {
                var element =  $(this).val();
                         if(this.checked) {
                            liste_opp.push($(this).val());
                            if(liste_opp.length > 1){
                                $("#massaffectation").css("display",'inline-block');

                            }else
                             $("#massaffectation").css("display",'none');
                         }else{
                            liste_opp = jQuery.grep(liste_opp, function (value) {
                                return value != element;
                            });
                            console.log(liste_opp);
                            if(liste_opp.length <= 1){
                                $("#massaffectation").css("display",'none');

                            }
                         }
                    
                    // })
                })
            })
        </script>
    @stop