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
    `

  
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
                  <h4 class="mb-sm-0">OPERATEUR EN LIGNE</h4>
                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Forms</a>
                      </li>
                      <li class="breadcrumb-item active">Basic Elements</li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <!-- end page title -->
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Modifier un operateur en ligne</h4>
                  </div>
                  <!-- end card header -->
                  <div class="card-body">
                    <div class="live-preview">
                      <div class="row gy-4">
                        <div class="col-md-7" style="margin: 0 auto">
                            <div class="alert alert-success" role="alert" style="display:none">
                                                    <strong> Opérateur enregistré avec succès! </strong>  <b> <a href="">Voir la liste des utilisateurs</a></b> en savoir
                            </div>
                            <form class="updateform" id="updateform" enctype="multipart/form-data" action="" autocomplete="off" method="post">

                                <div class="row">
                                  <div class="col-md-6"></div>
                                  <div class="col-md-6">
                                      <h2 style="width: 75%;display: inline-block;"></h2>
                                    <div class="form-check form-switch form-switch-lg " dir="ltr" style="margin-top:30px;display: inline-block;float: right;">
                                        <input name="isactiv" type="checkbox" class="form-check-input" id="customSwitchsizelg" @if ($findAgent['isactive']==1)
                                          {{-- expr --}}
                                         checked=""@endif>
                                        @if ($findAgent['isactive']==1)
                                        <label class="form-check-label" for="customSwitchsizelg">Est actif</label>
                                        @else
                                         <label class="form-check-label" for="customSwitchsizelg">Desactivé</label>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class=" col-md-6">
                                  <div>
                                    <label for="basiInput" class="form-label">Nom</label>
                                    <input type="text" name="lastname" class="form-control " value="{{$findAgent['lastname'] }}" >
                                  </div>
                                </div>
                                <!--end col-->
                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Prénoms</label>
                                    <input type="text" name="firstname" class="form-control " value="{{$findAgent['firstname'] }}">
                                  </div>
                                </div>
                                <!--end col-->

                                <div class=" col-md-6">
                                  <div>
                                    <label for="basiInput" class="form-label">Numéro Téléphone</label>
                                    <input type="text" name="phonenumber" value="{{$findAgent['PhoneNumber'] }}" class="form-control " >
                                  </div>
                                </div>
                                <!--end col-->

                                <div class=" col-md-6">
                                  <div>
                                    <label for="basiInput" class="form-label">Login</label>
                                    <input type="text" name="login" class="form-control requiredField" value="{{$findAgent['login'] }}">
                                  </div>
                                </div>
                                <!--end col-->

                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" class="form-control " i>
                                  </div>
                                </div>


                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="ForminputState" class="form-label">Privilege</label>
                                                        <select name="privilege" id="ForminputState" class="form-select" data-choices data-choices-sorting="true">
                                                            <option selected>Choisir...</option>
                                                            <option @if ($findAgent['privilege'] == 'niveau1') selected @endif value="niveau1" >Full </option>
                                                            <option @if ($findAgent['privilege'] == 'niveau2') selected @endif value="niveau2">Intermediaire </option>
                                                            <option  @if ($findAgent['privilege'] == 'niveau3') selected @endif value="niveau3">débutant </option>
                                                        </select>
                                                    </div>
                                                </div>

                                <div class="col-md-12" style="margin-top: 10px">
                                    <div class="input-group">
                                        <button id="updatebtn" class="btn btn-primary" style="margin-right: 40px;width: 200px;" type="button">Mettre à jour</button>

                                        <button class="btn btn-success" style="width: 200px" type="button">Annuler</button>
                                    </div>
                                </div>
                                
                                </div>

                                <input type="hidden" name="selecteduser" value="{{$findAgent['id']}}">
                                
                            </form>
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
                                                            <p class="text-muted mb-4"> Modiffication enregistrée avec succès </p>
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <a href="javascript:void(0);" class="btn btn-success  fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                              </div>


                              <div class="modal fade" id="successModalpwd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                            <h4 class="mb-3">Modification de mot de passe!</h4>
                                                            <p class="text-muted mb-4"> l'utilisateur dont le mot de passe a été modifié sera deconnecté dans 5 secondes </p>
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <a href="javascript:void(0);" class="btn btn-success  fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                              </div>
                            
                        </div>
                      </div>
                      <!--end row-->
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">PRIVILEGES</h4>
                                </div>
                                <!-- end card header -->

                                <div class="card-body">
                                    {{-- <p class="text-muted">Use <code>form-check-</code> class with below-mentioned color variation to set a color switch.</p> --}}
                                    <div id="updateprivform" class="live-preview">
                                      <input type="hidden" name="user_id"  value="{{$findAgent['id'] }}">
                                        <div class="row">

                                                  @php
                                                     $usersprivileges = $user_list_priv; //Session::get('userprivilege_list');
                                                      $menu_agent_bo = array(1, 2, 3, 4);
                                                      $menu_opp = array(5, 6, 7, 8,9);
                                                      $menu_bordereau = array(17, 18, 19, 20 ,21 ,22 ,24);
                                                      $menu_dossier_encours = array(10, 11, 12, 13 ,14 ,15 ,16);
                                                      $menu_stat = array(23);
                                                      $menu_autre = array(25, 26,27,28,29);
                                                      $menu_argus = array(33, 34, 35, 36);


                                                  @endphp

                                                  @foreach ($ListePrivileges as $element)

                                                      @if ($element['id'] == 1)
                                                        {{-- expr --}}
                                                      
                                                      <div class="col-md-4">
                                                        <h5 style="font-weight: bold;margin-bottom: 20px;">AGENT BACKOFFICE</h5>

                                                          
                                                          <div>

                                                      @endif
                                                            
                                                        @if  (in_array($element['id'], $menu_agent_bo))  
                                                        <div class="form-check form-switch mb-3">
                                                            <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="{{$element['id']}}"   @if  (in_array($element['id'], $usersprivileges)) checked @endif >
                                                            <label class="form-check-label" for="SwitchCheck1">{{$element['libelle']}}</label>
                                                         </div>
                                                        @endif
                                                     

                                                        {{-- <div class="form-check form-switch form-switch-secondary mb-3">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck2" checked>
                                                            <label class="form-check-label" for="SwitchCheck2">Switch Secondary</label>
                                                        </div> --}}

                                                       {{--  <div class="form-check form-switch form-switch-success mb-3">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck3" checked>
                                                            <label class="form-check-label" for="SwitchCheck3">Switch Success</label>
                                                        </div>

                                                        <div class="form-check form-switch form-switch-warning mb-2 mb-md-0">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck4" checked>
                                                            <label class="form-check-label" for="SwitchCheck4">Switch Warning</label>
                                                        </div> --}}
                                            @if ($element['id'] == 4)
                                                    </div>
                                                </div>
                                            @endif
                                            <!--end col-->

                                            @if ($element['id'] == 5)
                                              {{-- expr --}}
                                           
                                              <div class="col-md-4">

                                                    <h5 style="font-weight: bold;margin-bottom: 20px;">OPPORTUNITES</h5>
                                                  <div>
                                              @endif

                                                     @if  (in_array($element['id'], $menu_opp))  
                                                      <div class="form-check form-switch form-switch-danger mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="{{$element['id']}}"   @if  (in_array($element['id'], $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5">{{$element['libelle']}}</label>
                                                      </div>

                                                      @endif

                                                     {{--  <div class="form-check form-switch form-switch-info mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck6" checked>
                                                          <label class="form-check-label" for="SwitchCheck6">Switch Info</label>
                                                      </div>

                                                      <div class="form-check form-switch form-switch-dark mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck7" checked>
                                                          <label class="form-check-label" for="SwitchCheck7">Switch Dark</label>
                                                      </div> --}}
                                              @if ($element['id'] == 9)
                                                    </div>
                                                </div>
                                              @endif



                                              @if ($element['id'] == 10)
                                              {{-- expr --}}
                                           
                                              <div class="col-md-4">

                                                 <h5 style="font-weight: bold;margin-bottom: 20px;">DOSSIERS EN COURS </h5>
                                                  <div>
                                              @endif



                                                     @if  (in_array($element['id'], $menu_dossier_encours))  
                                                      <div class="form-check form-switch form-switch-info mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="{{$element['id']}}"   @if  (in_array($element['id'], $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5">{{$element['libelle']}}</label>
                                                      </div>


                                                      @endif

                                                      



                                                 @if ($element['id'] == 16)

                                                      <div class="form-check form-switch form-switch-info mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="30"   @if  (in_array(30, $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5"> {{$ListePrivileges[29]['libelle']}}</label>
                                                      </div> 



                                                       <div class="form-check form-switch form-switch-info mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="31"   @if  (in_array(31, $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5"> {{$ListePrivileges[30]['libelle']}}</label>
                                                      </div> 



                                                    </div>
                                                </div>
                                              @endif


                                               @if ($element['id'] == 17)
                                              <div class="col-md-12" style="margin:20px;"></div>
                                              @endif

                                                @if ($element['id'] == 17)
                                              {{-- expr --}}
                                           
                                              <div class="col-md-4">
                                                 <h5 style="font-weight: bold;margin-bottom: 20px;">BORDEREAUX </h5>
                                                  <div>
                                              @endif


                                              @if  (in_array($element['id'], $menu_bordereau))  
                                                      <div class="form-check form-switch form-switch-dark mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="{{$element['id']}}"   @if  (in_array($element['id'], $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5">{{$element['libelle']}}</label>
                                                      </div>

                                                      @endif

                                              @if  (in_array($element['id'], $menu_stat))  
                                                      <div class="form-check form-switch form-switch-dark mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="{{$element['id']}}"   @if  (in_array($element['id'], $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5">{{$element['libelle']}}</label>
                                                      </div>

                                                      @endif

                                               @if ($element['id'] == 24)
                                                    </div>
                                                </div>
                                              @endif




                                               @if ($element['id'] == 25 )
                                              {{-- expr --}}
                                           
                                              <div class="col-md-4">
                                                 <h5 style="font-weight: bold;margin-bottom: 20px;">AUTRES </h5>
                                                  <div>
                                              @endif


                                              @if  (in_array($element['id'], $menu_autre))  
                                                      <div class="form-check form-switch form-switch-dark mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="{{$element['id']}}"   @if  (in_array($element['id'], $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5">{{$element['libelle']}}</label>
                                                      </div>

                                                      @endif




                                              @if ($element['id'] == 29)

                                                      {{-- supprimer une opportunite --}}
                                                      <div class="form-check form-switch form-switch-dark mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="37"   @if  (in_array(37, $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5"> {{$ListePrivileges[36]['libelle']}}</label>
                                                      </div> 



                                                    
                                                    </div>
                                                </div>
                                              @endif


                                                       @if ($element['id'] == 33)
                                              {{-- expr --}}
                                           
                                                <div class="col-md-4">
                                                   <h5 style="font-weight: bold;margin-bottom: 20px;">ARGUS </h5>
                                                    <div>
                                                @endif


                                                    @if  (in_array($element['id'], $menu_argus))  
                                                      <div class="form-check form-switch form-switch-dark mb-3">
                                                          <input class="form-check-input" type="checkbox" role="switch"  name="privilege_user[]" value="{{$element['id']}}"   @if  (in_array($element['id'], $usersprivileges)) checked @endif>
                                                          <label class="form-check-label" for="SwitchCheck5">{{$element['libelle']}}</label>
                                                      </div>

                                                      @endif


                                                  @if ($element['id'] == 36)
                                                    
                                                    </div>
                                                </div>
                                              @endif

                                               


                                              @endforeach
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                   
                                <div class="col-md-12 text-center">
                                   <button id="updatepriv" class="btn btn-dark" style="margin-right: 40px;margin-top: 40px;" type="button">Mettre à jour les privileges</button>
                                </div>

                                </div>
                                <!--end card-body-->


                            </div>
                            <!--end card-->
                        </div> <!-- end col -->
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
    $(document).ready(function () {


      $("#updatebtn").click(function(e) {
            e.preventDefault();
            var hasError = false;
            var btnclicked = $(this);
            var uploadhaserror = false;
            var datasT = new FormData();
            var hasErrorupload = new Array();

            $('.updateform').find('input, textarea, select').each(function() {
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
                }else if ($(this).is(':checkbox')) {
                    if ($(this).is(':checked')) {
                        $(this).val(1);
                        datasT.append(this.name, $(this).val());
                    }else
                    $(this).val(0);
                }
                 else {
                    datasT.append(this.name, $(this).val());
                }
            });


            $('.updateform .requiredField').each(function() {
                var i = $(this);
                $(this).removeClass('invalid');
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
                  url: '/updateuserbasics',
                  beforeSend: function(){
                     btnclicked.removeClass('normalstate');
                    btnclicked.addClass('is-active');
                  },
                  success: function(response){
                    // var retourJson =JSON.parse(response);
                    //console.log(response.message);
                   if (response =='inserted') {
                     $('#successModal').modal('show');
                   }
                    if (response =='pwdedited') {
                     $('#successModalpwd').modal('show');
                      setInterval(function() {
                        $.ajax({
                                type: 'GET',
                                url: '/notification_asap',
                                success: function(response){
                                  location.reload();
                                }
                              });
                       }, 5000);
                     
                   }
                   
                  }
                });
            }
         })


    


    $("#updatepriv").click(function(e) {
            e.preventDefault();
            var hasError = false;
            var btnclicked = $(this);
            var uploadhaserror = false;
            var datasT = new FormData();
            var hasErrorupload = new Array();

            $('#updateprivform').find('input, textarea, select').each(function() {
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
                }else if ($(this).is(':checkbox')) {
                    if ($(this).is(':checked')) {
                        // $(this).val(1);
                        datasT.append(this.name, $(this).val());
                    }
                    // else
                    // $(this).val(0);
                }
                 else {
                    datasT.append(this.name, $(this).val());
                }
            });

            $('.requiredField').addClass('fieldtrue');
            $('#updateprivform .requiredField').each(function() {
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
                  url: '/updateuserpriv',
                  beforeSend: function(){
                     btnclicked.removeClass('normalstate');
                    btnclicked.addClass('is-active');
                  },
                  success: function(response){
                    // var retourJson =JSON.parse(response);
                    //console.log(response.message);
                   if (response =='succes') {
                     $('#successModal').modal('show');
                     
                   }
                  }
                });
            }
         })




  
  $('input[type=checkbox][name="privilege_user[]"]').on('change', function() {
  // $('input[name=privilege_user[]]').change(function() {
 
    if (this.value == 10) {
      $('input[name="privilege_user[]"][value="13"]').prop('checked', false);
    }

    if (this.value == 13) {
      $('input[name="privilege_user[]"][value="10"]').prop('checked', false);
    }


    if (this.value == 11) {
      $('input[name="privilege_user[]"][value="14"]').prop('checked', false);
    }

    if (this.value == 14) {
      $('input[name="privilege_user[]"][value="11"]').prop('checked', false);
    }


    if (this.value == 12) {
      $('input[name="privilege_user[]"][value="15"]').prop('checked', false);
    }

    if (this.value == 15) {
      $('input[name="privilege_user[]"][value="12"]').prop('checked', false);
    }


    if (this.value == 30) {
      $('input[name="privilege_user[]"][value="31"]').prop('checked', false);
    }

    if (this.value == 31) {
      $('input[name="privilege_user[]"][value="30"]').prop('checked', false);
    }
  
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
  
      


         
     });
     </script>   

     @endsection