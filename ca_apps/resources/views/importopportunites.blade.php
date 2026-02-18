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
                  <h4 class="mb-sm-0">PROSPECTION</h4>
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
                                    <h4 class="card-title mb-0 flex-grow-1">Importer</h4>
                                    <div class="flex-shrink-0">
                                        
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <p class="text-muted">Ce formulaire pour les importeer une liste d'opportunité à partir d'un fichier excel.  
                                    </p>
                                    <div class="live-preview">

                                         <div class="alert alert-success" role="alert" style="display:none">
                                                    <strong> Opportunitées importées avec succès! </strong>  <b> <a href="/listeprosprection">Voir la liste des opportunitées</a>
                                                </div>
                                        <form id="importefileform" action="javascript:void(0);" enctype="multipart/form-data">
                                            <div class="row">

                                           
                                            <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="formSizeDefault" class="form-label">Importer une liste d'opportunites</label>
                                                        
                                                        <input class="form-control" id="formSizeDefault" name="file" type="file">
                                                    </div>
                                                </div>

                                                

                                                <!--end col-->

                                                <div style="margin-bottom:10px"></div>

                                               
                                                <!--end col-->
                                                 <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button type="submit" id="importfile" class="btn btn-primary">Enregistrer</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <div class="d-none code-view">
                                        
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
    <script src="assets/libs/prismjs/prism.js"></script>
    <script src="assets/js/app.js"></script>

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

         $("#importfile").click(function(e) {
           
            e.preventDefault();
            var hasError = false;
            var btnclicked = $(this);
            var uploadhaserror = false;
            var datasT = new FormData();
            var hasErrorupload = new Array();

            $('#importefileform').find('input, textarea, select').each(function() {
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
            $('#createNote .requiredField').each(function() {
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
                  url: '/uploadfile',
                  beforeSend: function(){
                     btnclicked.removeClass('normalstate');
                    btnclicked.addClass('is-active');
                  },
                  success: function(response){
                   if (response =='data imported') {
                    // var button = btnclicked;
                    $('.alert-success').css('display','block');
                   // $("input[type=text],textarea,input[type=date],input[type=time]").val("")
                   }
                  }
                });
            }
         })



 function chech_uploadedfile(selfile){
    var element = selfile;
    var hasErrorf = false;
    var iSize = element[0].files[0].size;
    var iType = element[0].files[0].type;
    var ValidImageTypes = ['application/vnd.ms-excel'];
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