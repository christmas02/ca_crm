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
                  <h4 class="mb-sm-0">VEHICULE</h4>
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
                    <h4 class="card-title mb-0 flex-grow-1">Modifier un vehicule dans l'Argus</h4>
                    <div class="flex-shrink-0">
                      {{-- <div class="form-check form-switch form-switch-right form-switch-md">
                        <label for="form-grid-showcode" class="form-label text-muted">Show Code</label>
                        <input class="form-check-input code-switcher" type="checkbox" id="form-grid-showcode">
                      </div> --}}
                    </div>
                  </div>
                  <!-- end card header -->
                  <div class="card-body">
                    <div class="live-preview">
                      <div class="row gy-4">

                        <div class="col-md-7" style="margin: 0 auto">


                            <div class="alert alert-success" role="alert" style="display:none">
                                                    <strong> Vehicule modifié avec succès! </strong>  <b> <a href="/vehicule_list">Voir la liste des vehicules</a></b> en savoir
                                                </div>
                            
                            <form id="createuserform" enctype="multipart/form-data" action="" autocomplete="off" method="post">

                                <div class="row">
                                  <div class="col-md-6"></div>
                                  <div class="col-md-6">
                                  <h2 style="width: 75%;display: inline-block;"></h2>
                                                
                                            </div>
                                {{--  <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formMarque" class="form-label">Marque</label>
                                                        <select name="marque" id="formMarque" class="form-select" data-choices data-choices-sorting="true" required>
                                                            <option selected value="">Choisir...</option>
                                                            @foreach ($carlist as $car)
                                                                 <option value="{{$car['brand']}}">{{$car['brand']}}</option>
                                                            @endforeach

                                                            @foreach ($carlist2 as $car2)
                                                                 <option value="{{$car2['libelle']}}">{{$car2['libelle']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>  --}}
                                <!--end col-->

                                {{-- <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formModel" class="form-label">Model</label>
                                                        <select name="model" id="formModel" class="form-select" data-choices data-choices-sorting="true" required>
                                                        </select>
                                                    </div>
                                                </div>  --}}
                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Marque</label>
                                    <input type="text" name="marque" class="form-control requiredField" value="{{$cardetails[0]['brand']}}">
                                  </div>
                                </div>

                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Model</label>
                                    <input type="text" value="{{$cardetails[0]['brand']}}" name="model" class="form-control requiredField" >
                                  </div>
                                </div>

                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Type vehicule</label>
                                    <input type="text" value="{{$cardetails[0]['type']}}" name="typevehicule" class="form-control requiredField" >
                                  </div>
                                </div>

                               {{--   <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="ForminputState" class="form-label">Type</label>
                                                        <select name="typevehicule" id="ForminputState" class="form-select" data-choices data-choices-sorting="true">
                                                           <option selected value="">Choisir...</option>
                                                            @foreach ($car_type_list as $typelist)
                                                                 <option value="{{$typelist['type']}}">{{$typelist['type']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> --}}

                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Nombre de place</label>
                                    <input type="text" value="{{$cardetails[0]['places']}}" name="nombreplace" class="form-control requiredField" >
                                  </div>
                                </div>

                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Annee de sortie</label>
                                    <input type="text"  value="{{$cardetails[0]['carsvalues'][0]['date']}}" name="annsortie" class="form-control requiredField" >
                                  </div>
                                </div>

                                 <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Puissance</label>
                                    <input type="text"  value="{{$cardetails[0]['power']}}" name="puissance" class="form-control requiredField" >
                                  </div>
                                </div>

                                <input type="hidden"  value="{{$cardetails[0]['id']}}" name="carid">
                                <input type="hidden"  value="{{$cardetails[0]['car_code']}}" name="car_code">

                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Valeur neuve</label>
                                    <input type="text"  value="{{$cardetails[0]['carsvalues'][0]['amount']}}" name="valeurneuve" class="form-control requiredField" >
                                  </div>
                                </div>
                                <!--end col-->

                                

                                <div class="col-md-12" style="margin-top: 10px">
                                    <div class="input-group">
                                        <button id="save_createuserform" class="btn btn-primary" style="margin-right: 40px;width: 200px;" type="button">Enregistrer</button>

                                        <button class="btn btn-success" style="width: 200px" type="button">Annuler</button>
                                    </div>
                                </div>
                                
                                </div>
                                
                            </form>
                            
                            </div>
                      </div>
                      <!--end row-->
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

    <script src="/assets/js/pages/password-addon.init.js"></script>
    
    <style>
        .form-control{
            border: 1px solid #5b5b5b !important;
        }

        .requiredfield{
            border: 1px solid #ec2626 !important;
        }

        .invalid{
            border: 1.5px solid #ec2626 !important;
        }
        .not-active {
            pointer-events: none;
            cursor: default;
            background: #909090 !important;
        }

        select, select option {text-transform:uppercase}
        
    </style>
     
    <script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>

    <script>
    $(document).ready(function () {


        $('#formMarque').on('change',function(e){
         var marque = $(this).val();
         $('#formModel').attr('disabled','disabled');

         $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
             $.ajax({
                type:'POST',
                url:'/find_new_carmodel',
                data: {marque:marque},
                 // beforeSend: function(){
                 //     $('#spinner0').css('display','block');
                 //      },
                success:function(data){
                    $('#formModel').removeAttr('disabled');
                   // $('#spinner0').css('display','none');
                  $("#formModel").html(data);
                }
            });
          
         });



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
                  url: '/update_cars',
                   beforeSend: function() {
                      $('#save_createuserform').addClass('not-active').html('Patienter...'); 
                  },
                  success: function(response){
                   if (response =='inserted') {
                    // var button = btnclicked;
                    $('.alert-success').css('display','block');
                    $("input[type=text], textarea").val("")

                  $('#save_createuserform').removeClass('not-active').html('Enregistrer'); 
                   }
                  }
                });
            }
         })
     });
     </script>   

     @endsection