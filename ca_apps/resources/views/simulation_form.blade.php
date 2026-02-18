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
                  <h4 class="mb-sm-0">SIMULATION</h4>
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
                        <div class="col-xxl-6"  style="margin:auto">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Formulaire de cotation</h4>
                                    <div class="flex-shrink-0">
                                        <a href="/formulaire_cotation_sc" class="btn btn-dark">Full saisie</a>
                                    </div>
                                </div><!-- end card header -->


                                <div class="card-body">
                                    <p class="text-muted"></p>
                                    <div class="live-preview">
                                        <div class="alert alert-success" role="alert" style="display:none">
                                                    <strong> Commentaire enregistré avec succès! </strong>  <b> <a href=""></a>
                                                </div>
                                        <form id="simul" method="POST" action="/calcul_cotation">
                                               @csrf
                                            <div class="row">


                                              {{--   <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="plaqueimma" class="form-label">Plaque immatriculation</label>
                                                        <input type="text" name="plaqueimma" class="form-control" placeholder="" id="plaqueimma">
                                                    </div>
                                                </div>


                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="proprietaire" class="form-label">Proprietaire</label>
                                                        <input type="text" name="proprietaire" class="form-control" placeholder="prorietaire" id="proprietaire">
                                                    </div>

                                                </div> --}}



                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formMarque" class="form-label">Marque</label>
                                                        <select name="marque" id="formMarque" class="form-select" data-choices data-choices-sorting="true" required>
                                                            <option selected value="">Choisir...</option>
                                                            @foreach ($carlist as $car)
                                                                 <option value="{{$car['brand']}}">{{$car['brand']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> 


                                               {{--  <div class="col-md-6">
                                                    <div class="form-check form-switch form-switch-lg " dir="ltr" style="margin-top:30px">
                                                        <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="isasap" checked="">
                                                        <label class="form-check-label" for="customSwitchsizelg">Client ASAP</label>
                                                    </div>
                                                </div> --}}



                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formModel" class="form-label">Model</label>
                                                        <select name="model" id="formModel" class="form-select" data-choices data-choices-sorting="true" required>
                                                           
                                                        </select>
                                                    </div>
                                                </div> 
                                                <!--end col-->
                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="ForminputState" class="form-label">Carburant</label>
                                                        <select name="energie" id="ForminputState" class="form-select" data-choices data-choices-sorting="true" required>
                                                            <option selected value="">Choisir...</option>
                                                            <option value="essence">Essence</option>
                                                            <option value="diesel">Diesel</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                                <!--end col-->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="compnayNameinput" class="form-label">Date Mise en circulation</label>
                                                        <input type="date" name="mise_circulation" class="form-control maxlength10" placeholder="mise en circulation" id="compnayNameinput" required>
                                                    </div>
                                                </div>

                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="compnayNameinput" class="form-label">Nombre de places</label>
                                                        <input type="text" name="nbreplace" class="form-control numberonly" placeholder="Nombre de place " id="compnayNameinput" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="puissance" class="form-label">Puissance</label>
                                                        <input type="text" name="puissance" class="form-control numberonly" placeholder="5" id="puissance" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="bns" class="form-label">BNS %</label>
                                                        <input type="text" name="bns" class="form-control numberonly" placeholder="" id="bns" value="19" required>
                                                    </div>
                                                </div>


                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="csp" class="form-label">CSP</label>
                                                        <input type="text" name="csp" class="form-control numberonly" placeholder="csp" id="csp" value="95" required>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="redcom" class="form-label">RED COM</label>
                                                        <input type="text" name="redcom" class="form-control numberonly" placeholder="reduction commercial" id="redcom" value="25" required>
                                                    </div>
                                                </div>




                                                <!--end col-->
                                            
                                                <div style="margin-bottom:10px"></div>

                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button id="idnext" type="submit" class="btn btn-primary">Suivant</button>
                                                    </div>
                                                </div>
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
                                                            <p class="text-muted mb-4"> Opportunité enregistrée avec succès </p>
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <a href="javascript:void(0);" class="btn btn-success  fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
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
        .fieduploaderror {
            border: solid red 2px !important;
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
                url:'/find_carmodel',
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







         $("#saveprospect").click(function(e) {
            console.log('bonjour');
            e.preventDefault();
            var hasError = false;
            var btnclicked = $(this);
            var uploadhaserror = false;
            var datasT = new FormData();
            var hasErrorupload = new Array();

            $('#createprospectform').find('input, textarea, select').each(function() {
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

            $('.requiredField').addClass('fieldtrue');
            $('#createprospectform .requiredField').each(function() {
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
                  url: '/addProspectOnline',
                  beforeSend: function(){
                    //  btnclicked.removeClass('normalstate');
                    // btnclicked.addClass('is-active');
                     btnclicked.addClass('not-active').html('Patienter...'); 
                  },
                  success: function(response){
                    btnclicked.removeClass('not-active').html('Enregistrer'); 
                    // var retourJson =JSON.parse(response);
                    //console.log(response.message);
                   if (response.message =='successfull') {
                    // var button = btnclicked;
                    // $('.alert-success').css('display','block');
                    $("input[type=text], input[type=date], textarea").val("");

                     $('#successModal').modal('show');
                    $("input[type=text], textarea, input[type=date], input[type=time],input[type=tel]").val("");
             
                    $("#Imgattesation").val(null);
                    $("#Imgcartegrise").val(null);
                   }
                  }
                });
            }
         })
     });


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
                    $('#saveprospect').removeClass('not-active');
                 }else{
                    $(this).siblings(".msg_file").css('display','inline');
                    $(this).siblings(".msg_file").html('Fichiers autorisés: Jpeg - Png | 8MB');
                  //  $(this).siblings('.file-selected').css('color','#f46e23');
                    $(this).addClass('fieduploaderror');
                    $('#saveprospect').addClass('not-active');

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