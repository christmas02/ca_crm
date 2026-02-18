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


                    <div class="row">
                        <div class="col-xxl-6"> 
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">informations de base</h4>
                                    <div class="flex-shrink-0"></div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <p class="text-muted">Informations de base 
                                    </p>
                                    <div class="live-preview">
                                        <form id="createNote" action="javascript:void(0);">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                     
                                                        <label for="firstNameinput" class="form-label">Nom client</label>
                                                        <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="nomclient" value="{{$findOpportunity['nom']}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="firstNameinput" class="form-label">Prénoms client</label>
                                                        <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="prenomclient" value="{{$findOpportunity['prenoms']}}">
                                                    </div>
                                                </div>

                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="firstNameinput" class="form-label">Téléphone</label>
                                                        <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="telclient" value="{{$findOpportunity['telephone']}}">
                                                    </div>
                                                 </div>

                                                 {{-- @php
                                                     dd(Arr::last($findOpportunity['commentaires'])['echeance'])
                                                 @endphp --}}
                                               

                                                @if ($findOpportunity['commentaires'] )
                                                    {{-- expr --}}

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Echéance</label>
                                                        <input type="date" name="dateecheance" class="form-control" id="exampleInputdate" value="{{\Carbon\Carbon::parse(Arr::last($findOpportunity['commentaires'])['echeance'])->format('Y-m-d')}}">
                                                    </div>
                                                </div>


                                                @else 


                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Echéance</label>
                                                        <input type="date" name="dateecheance" class="form-control" id="exampleInputdate" value="{{\Carbon\Carbon::parse($findOpportunity['echeance'])->format('Y-m-d')}}">
                                                    </div>
                                                </div>



                                                @endif


                                                
                                                <div class="col-md-6">
                                                    <div>
                                                    <label for="readonlyInput" class="form-label">Lieu Prospection</label>
                                                        <input type="text" class="form-control" id="readonlyInput" value="{{$findOpportunity['lieuprospection']}}">
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div>
                                                    <label for="readonlyInput" class="form-label">Immatriculation</label>
                                                        <input type="text" class="form-control" id="readonlyInput" value="{{$findOpportunity['plaque_immatriculation'] ?? 'Non defini'}}">
                                                    </div>
                                                </div>


                                                
                                                 <div class="col-md-12"></div>

                                                  <div class="col-md-12">
                                                    <div>
                                                        <label for="exampleFormControlTextarea5" class="form-label">Observation</label>
                                                        <textarea name="observation" class="form-control" id="exampleFormControlTextarea5" rows="3"> {{$findOpportunity['observation']}}</textarea>
                                                    </div>
                                                </div>


                                                <!--end col-->

                                                <div style="margin-bottom:10px"></div>

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


                        <div class="col-xxl-6"> 
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Cartes </h4>
                                    <div class="flex-shrink-0">

                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="live-preview">

                                     <div class="row">
                                            <div class="col-md-6">
                                                <div class="card card-height-100 ">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Attestation assurance</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mx-auto">


                                                             @if ($findOpportunity['url_attestationassurance']!='')
                                                                {{-- expr --}}
                                                                 <img src="{{$findOpportunity['url_attestationassurance']}}" style="width: 350px;height: 250px; margin: 0 auto;display: block;" alt="">
                                                            @else
                                                             <img src="/assets/images/No-Image-Placeholder.png" style="width: 350px;height: 250px; margin: 0 auto;display: block;" alt="">

                                                            @endif

                                                            <div style="margin-top: 20px;">
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

                                                             @if ($findOpportunity['urlcarte_grise']!='')
                                                                {{-- expr --}}
                                                                 <img src="{{$findOpportunity['urlcarte_grise']}}" style="width: 350px;height: 250px; margin: 0 auto;display: block;" alt="">
                                                            @else
                                                             <img src="/assets/images/No-Image-Placeholder.png" style="width: 350px;height: 250px; margin: 0 auto;display: block;" alt="">

                                                            @endif

                                                            <div style="margin-top: 20px;">
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

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6" style="margin-top: 20px">
                            <div class="text-center">
                                 <a href="/prospection_full_details/{{$findOpportunity['id']}}"  style="width: 98%; height: 50px;margin-top: 20px;font-weight: bold;line-height: 35px;"   class="btn btn-primary">Traiter l'opportunité</a>
                            </div>
                        </div>

                         <div class="col-md-6" style="margin-top: 20px">
                            <div class="text-center">
                                 <a href="/prospection_full_details/{{$findOpportunity['id']}}"  style="width: 98%; height: 50px;margin-top: 20px; font-weight: bold;line-height: 35px;"   class="btn btn-success">Mettre à jour les informations</a>
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
                                                        <th scope="col">Date Commentaire</th>
                                                        <th scope="col">Commentaire</th>
                                                        <th scope="col">interet</th>
                                                        <th scope="col">Echeance</th>
                                                        <th scope="col">Date Relance</th>
                                                        <th scope="col">Heure Relance</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>



                                                    @foreach ($findOpportunity['commentaires'] as $commmentaire)
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


    @endsection


    @section('footerCss')

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
    </style>
     
    <script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>

    <script>
    $(document).ready(function () {

         $("#save_createuserform").click(function(e) {
            console.log('bonjour');
            e.preventDefault();
            var hasError = false;
            var btnclicked = $(this);
            var uploadhaserror = false;
            var datasT = new FormData();
            var hasErrorupload = new Array();

            $('#createuserform').find('input, textarea, select').each(function() {
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
                } else {
                    datasT.append(this.name, $(this).val());
                }
            });

            $('.requiredField').addClass('fieldtrue');
            $('#createuserform .requiredField').each(function() {
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
                  url: '/createuser',
                  beforeSend: function(){
                     btnclicked.removeClass('normalstate');
                    btnclicked.addClass('is-active');
                  },
                  success: function(response){
                   if (response =='inserted') {
                    // var button = btnclicked;
                    $('.alert-success').css('display','block');
                    $("input[type=text], textarea").val("")
                   }
                  }
                });
            }
         })
     });
     </script>   

     @endsection