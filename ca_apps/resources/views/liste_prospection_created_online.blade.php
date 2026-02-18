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
                                <h4 class="mb-sm-0">OPPORTUNITES CREES PAR DES AGENTS </h4>

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
                                    <h5 class="card-title mb-0">Opportunites crées en ligne</h5>
                                </div>


                                <div id="filterform" class="row gy-4" style="padding-left: 20px;background: #f2f2f2;margin: 15px;">
                                          <h2>FORMULAIRE DE RECHERCHE</h2>
                                        <form id="formtelfield" method="POST" action="/filter_opportunite_created_online"  class="col-md-10">
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
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">Filtrer</button>
                                                </div>
                                            </div>

                                             {{-- <a href="/liste_prosprection_created_online" style="width:200px" class="btn btn-success">Reinitialiser</a> --}}
 
                                        </form> 


                                        <button style="width:200px;display: none;height: 50px;" id="massaffectation" type="submit"  class="btn btn-success">Affecter en masse </button>
                                        
                                </div>



                                <div class="card-body">
                                    {{-- table table-bordered nowrap table-striped --}}
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>
                                            <tr style="background:lightgray;">
                                                <td  colspan="11"><h3 style="text-align:center;">Opportunitées crées en ligne</h3></td>
                                            </tr>
                                            <tr>
                                                 <th>Immatriculation</th>
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
                                                 <th>Créer par</th>
                                                 <th>Créer le </th>
                                                 <th>Commenter</th>
                                                 <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($listeprospection as $listeprospection_element)

                                           
                                            <tr>
                                                
                                                <td>{{$listeprospection_element['plaque_immatriculation']?? 'Non defini'}}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOpp" type="checkbox" value="{{$listeprospection_element['id']}}" >
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>

                                                <td>{{$listeprospection_element['nom']}}</td>
                                                <td>{{$listeprospection_element['prenoms']}}</td>
                                                <td>{{\Carbon\Carbon::parse($listeprospection_element['echeance'])->format('d-m-Y');}}</td>
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
                                                <td>{{$listeprospection_element['agent_enligne']['lastname']??' Non defini'}}</td>
                                                <td>{{\Carbon\Carbon::parse($listeprospection_element['created_at'])->format('d-m-Y');}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="/enregister_note_propection/{{$listeprospection_element['id']}}">Commenter</a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-success" href="/prospection_full_details/{{$listeprospection_element['id']}}">Details</a>
                                                </td> 
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
                                                                <a href="javascript:void(0);" class="btn btn-success  fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                                
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



    <script>

      // $('#finalrequest').find('input')

        var liste_opp = [];
        $(document).on('click','#massaffectation', function(e){
         
            $('.checkboxOpp').each(function() {
                 if(this.checked) {
                    liste_opp.push($(this).val());
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




    // $('#buttons-datatables').dataTable({
    //   "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
    //     "pageLength": 25
    // });


            // $('#buttons-datatables').dataTable({
            //     // "autoWidth": false,
            //     // "lengthChange": false,
            //     "destroy": true,
            //     "pageLength": 25
            // });

        // $('#buttons-datatables').dataTable({
        //         // "autoWidth": false,
        //         // "lengthChange": false,
        //         //"destroy": true,
        //         //"pageLength": 25
        //         "lengthMenu": [0, 5, 10, 20, 50, 100],
        //     });

        
            // $('#cardtableChecker')

            $('#cardtableChecker').change(function() {
                if(this.checked) {
                     $('.checkboxOpp:visible').prop('checked', true);
                      $("#massaffectation").css("display",'block'); 
                }else{
                 $('.checkboxOpp:visible').prop('checked', false);  
                 $("#massaffectation").css("display",'none');     
                }
            });



           


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

                         $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                           $.ajax({
                            type : "POST",
                            data: {arraylist:liste_opp, id_agent: id_agent},
                            url : '/attrib_opportunite_mass',
                            // data: {donnee:donnee},   
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
        </script>
    @stop