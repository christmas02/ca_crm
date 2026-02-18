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
                                <h4 class="mb-sm-0">Liste des contrats AR / RN detailés</h4>

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
                                    <h5 class="card-title mb-0">Contrats AR / RN detailés</h5>
                                </div>

                                <div id="filterform" class="row gy-4" style="padding-left: 20px;background: #f2f2f2;margin: 15px;">
                                     <h2>FORMULAIRE DE RECHERCHE</h2>
                                   <form id="formtelfield" method="POST" action="/filter_liste_contrat"  class="col-md-10">
                                            @csrf

                                             <div class="col-md-2" style=" display: inline-block;margin-right:15px;">
                                                <label for="basiInput" class="form-label"> Agents </label>
                                                 <select id="selectagent" name="selectagent" class="form-select mb-3" aria-label="Default select example" required>
                                                    <option selected value="">choisir un agent</option>
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
 
                                        </form> 
                                        
                                </div>



                                <div class="card-body">
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>
                                            <tr style="background:lightgray;">
                                                <td  colspan="14"><h3 style="text-align:center;">Contrats AN/RN detaillés</h3></td>
                                            </tr>
                                            <tr>
                                                 <th>Num Police</th>
                                                 <th> </th>
                                                 <th>Nom</th>
                                                 <th>Prenoms</th>
                                                 <th>Echeance</th>
                                                 <th >Tel 1</th>
                                                 <th >Tel 2</th> 
                                                 <th>Periode</th>
                                                <th>Prime Nette</th>
                                                 <th>Prime Ttc</th> 
                                                 <th>Souscrit par</th>
                                                 <th>Enregistrer  le </th>

                                                  <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                          @foreach ($listeprospection as $listeprospection_element)


                                            <tr>
                                                
                                                <td>{{$listeprospection_element['numpolice']}}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="cardtableCheck01">
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>

                                                <td>{{$listeprospection_element['opportunite']['nom']}}</td>
                                                <td>{{$listeprospection_element['opportunite']['prenoms']}}</td>
                                                <td data-sort="{{$listeprospection_element['commentaire']['echeance']}}">{{\Carbon\Carbon::parse($listeprospection_element['commentaire']['echeance'])->format('d-m-Y');}}</td>
                                                <td style="max-width: 100px !important;">{{$listeprospection_element['opportunite']['telephone']}}</td>
                                                <td style="max-width: 100px !important;">{{$listeprospection_element['opportunite']['telephone2']}}</td>
                                                 <td>{{$listeprospection_element['commentaire']['periode_soucription'] .' mois'}}</td>
                                                <td>{{$listeprospection_element['commentaire']['primenet']}}</td>
                                                <td>{{$listeprospection_element['commentaire']['primettc']}}</td>
                                               {{--  <td><img height="50" src="{{$listeprospection_element['urlcarte_grise']}}" alt=""></td>
                                                <td> <a href=""> <img height="50" src="{{$listeprospection_element['url_attestationassurance']}}"> </a></td> --}}
                                                <td>{{$listeprospection_element['commentaire']['agent_backoffice']['firstname'].' ' .$listeprospection_element['commentaire']['agent_backoffice']['lastname']}}</td>
                                                <td>{{\Carbon\Carbon::parse($listeprospection_element['created_at'])->format('d-m-Y H:i');}}</td>
                                                <td>
                                                    {{-- <a class="btn btn-primary" href="/enregister_note_propection/{{$listeprospection_element['opportunite']['id']}}">Commenter</a> --}}



                                                     <div class="dropdown">
                                                                <a href="#" role="button" id="{{$listeprospection_element['opportunite']['id']}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="{{$listeprospection_element['opportunite']['id']}}">
                                                                    <li><a class="dropdown-item" href="/enregister_note_propection/{{$listeprospection_element['opportunite']['id']}}">
                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                    Commenter</a></li>
                                                                
                                                                    <li><a class="dropdown-item attrib_btn" href="/prospection_full_details/{{$listeprospection_element['opportunite']['id']}}">
                                                                        <i class=" ri-arrow-left-right-line align-bottom me-2 text-muted"></i>
                                                                    Details</a></li>
                                                                  
                                                                    <li class="dropdown-divider"></li>
                                                                    <li><a class="dropdown-item delete_btn" data-opp="{{$listeprospection_element['id']}}" >
                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                    Supprimer</a></li>
                                                                
                                                                </ul>
                                                            </div>








                                                </td>

                                               
                                               {{--  <td>
                                                    <a class="btn btn-success" href="/prospection_full_details/{{$listeprospection_element['opportunite']['id']}}">Details</a>
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-danger delete_btn"   data-opp="{{$listeprospection_element['id']}}">Supprimer</button>
                                                </td> --}}
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
                                                                <h4>Supprimer le contrat.</h4>
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
                            url : '/attrib_opportunite',
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
                  $("#formdatefield").css('display','none');   
                  //datasend ={tel:inputTel};
              }
              if (typefiltre == 'date') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','block'); 
              }  
          }) 



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
                          url: "/removecontrat",
                          data: {data_rem :todelete},
                          success: function (data) {
                               $('#firstmodal').modal('hide');
                               if(data =='inserted'){
                               location.reload();
                              }
                          }
                  });

                });



        </script>
    @stop