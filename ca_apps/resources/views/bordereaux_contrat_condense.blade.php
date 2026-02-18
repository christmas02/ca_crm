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
                                <h4 class="mb-sm-0">Liste des contrats AR / RN condensés</h4>

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

                                <div id="filterform" class="row gy-4" style="padding-left: 20px;background: #f2f2f2;margin: 15px;">
                                     <h2>FORMULAIRE DE RECHERCHE</h2>
                                   <form id="formtelfield" method="POST" action="/filter_contrat_condenses"  class="col-md-10">
                                            @csrf

                                             <div class="col-md-2" style=" display: inline-block;margin-right:15px;">
                                                <label for="basiInput" class="form-label"> Periodicité </label>
                                                 <select id="periodecontrat" name="periodecontrat" class="form-select mb-3" aria-label="Default select example" required>
                                                    <option selected>Periode contrat</option>
                                                    <option value="tous">Toutes confondues</option>
                                                    <option value="1">1 mois</option>
                                                    <option value="3">3 mois</option>
                                                    <option value="6">6 mois</option>
                                                    <option value="12">12 mois</option>
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
                                            @if ($datedebut !== null  && $datefin !== null && $periodecontrat !== null)
                                            <tr style="background:lightgray;">
                                                <td  colspan="13"><h3 style="text-align:center;">Contrats AN/RN [{{$periodecontrat .' Mois'}}] condensés du  {{\Carbon\Carbon::parse($datedebut)->format('d-m-Y') .' au '.\Carbon\Carbon::parse($datefin)->format('d-m-Y')  }}</h3></td>
                                            </tr>
                                            @else
                                            <tr style="background:lightgray;">
                                                <td  colspan="13"><h3 style="text-align:center;">Contrats AN/RN condensés du {{date ('d-m-Y')}}</h3></td>
                                            </tr>
                                            @endif
                                            <tr>
                                                 <th>Nom</th>
                                                 <th>Prenoms</th>
                                                 <th>Opportunite Traitées</th>
                                                 <th>Contrats gagnés</th>
                                                 <th>Contrats AN</th>
                                                 <th>Contrats RN</th>
                                                 <th>Score</th>
                                                 <th>Taux Aff / Traité</th>
                                                 <th>Taux convers G/T</th>
                                                 <th>Prime Nette</th>
                                                 <th>Prime Ttc</th>
                                                 <th>Details</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                         
                                          @foreach ($contrat_condens as $contrat_condens_element)

                                            <tr>
                                                <td>{{$contrat_condens_element['agent_backoffice']['lastname']}}</td>
                                                <td>{{$contrat_condens_element['agent_backoffice']['firstname']}}</td>
                                                <td>{{$contrat_condens_element['totaltraites']}}</td>
                                                <td>{{$contrat_condens_element['nbre_opport_gagne']}}</td>
                                                 <td>{{number_format($contrat_condens_element['nombre_contrat_an'], 0, '.', ' ')}}</td>

                                                  <td>{{number_format($contrat_condens_element['nombre_contrat_rn'], 0, '.', ' ')}}</td>
                                                    @php
                                                      $score =  $contrat_condens_element['nombre_contrat_an'] + $contrat_condens_element['nombre_contrat_rn']/3;
                                                    @endphp
                                                  <td>{{number_format(round($score), 0, '.', ' ')}}</td>

                                                @if (count($contrat_condens_element['agent_backoffice']['affectations']) !=0)
                                                <td>{{
                                                   number_format( $contrat_condens_element['totaltraites'] * 100 / count( $contrat_condens_element['agent_backoffice']['affectations']) ,2)
                                                 . ' % '}} </td>
                                                 @else
                                                     <td>{{
                                                    0 .' %'
                                                 }}</td>
                                                 @endif

                                                 <td>{{
                                                    number_format($contrat_condens_element['nbre_opport_gagne'] * 100 / $contrat_condens_element['totaltraites'] ,2) 
                                                 . ' % '}}  </td>


                                                  {{-- <td>{{number_format($contrat_condens_element['sumprimenet'], 0, '.', ' ')}}</td> --}}

                                                <td>{{$contrat_condens_element['sumprimenet']}}</td>
                                                <td>{{ $contrat_condens_element['sumprimettc']}}</td>

                                             @if ($datedebut !== null  && $datefin !== null)
                                                <td>
                                                    @if ($contrat_condens_element['nbre_opport_gagne'] !=0)
                                                        {{-- expr --}}
                                                    
                                                    <a class="btn btn-dark" href="/details_contrats_byagent/{{$contrat_condens_element['agent_backoffice']['id'].'/'.$datedebut.'/'.$datefin }}">Details</a>
                                                    @else
                                                     - 

                                                    @endif
                                                </td>
                                            @else

                                            @php
                                                $today = date('Y-m-d');
                                            @endphp

                                            <td>
                                                @if ($contrat_condens_element['nbre_opport_gagne'] !=0)
                                                    <a class="btn btn-dark" href="/details_contrats_byagent/{{$contrat_condens_element['agent_backoffice']['id'].'/'.$today.'/'.$today }}">Details</a>

                                                 @else
                                                     - 

                                                    @endif
                                                </td>

                                            @endif
                                            



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


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © ConseilsAssur.
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


        </script>
    @stop