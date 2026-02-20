 
    <?php $__env->startSection('headerCss'); ?>
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

    <?php $__env->stopSection(); ?>   
  

    <?php $__env->startSection('content'); ?>
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
                        
                         <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Progress Nav Steps</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <form action="forms-wizard.html#" class="form-steps" autocomplete="off">
                                        <div class="text-center pt-3 pb-4 mb-1">
                                            <h5>Signup Your Account</h5>
                                        </div>
                                        <div id="custom-progress-bar" class="progress-nav mb-4">
                                            <div class="progress" style="height: 1px;">
                                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill active" data-progressbar="custom-progress-bar" id="pills-gen-info-tab" data-bs-toggle="pill" data-bs-target="#pills-gen-info" type="button" role="tab" aria-controls="pills-gen-info" aria-selected="true">1</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar" id="pills-info-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-info-desc" type="button" role="tab" aria-controls="pills-info-desc" aria-selected="false">2</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar" id="pills-success-tab" data-bs-toggle="pill" data-bs-target="#pills-success" type="button" role="tab" aria-controls="pills-success" aria-selected="false">3</button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="pills-gen-info" role="tabpanel" aria-labelledby="pills-gen-info-tab">
                                                <div>
                                                    <div class="mb-4">
                                                        <div>
                                                            <h5 class="mb-1">General Information</h5>
                                                            <p class="text-muted">Fill all Information as below</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="gen-info-email-input">Email</label>
                                                                <input type="email" class="form-control" id="gen-info-email-input" placeholder="Enter email" required >
                                                                <div class="invalid-feedback">Please enter an email address</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="gen-info-txt-input">texte</label>
                                                                <input type="text" class="form-control" id="gen-info-txt-input" placeholder="Enter txt" required >
                                                                <div class="invalid-feedback">Please enter an txt address</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="gen-info-username-input">User Name</label>
                                                                <input type="text" class="form-control" id="gen-info-username-input" placeholder="Enter user name" required >
                                                                <div class="invalid-feedback">Please enter a user name</div>
                                                            </div>
                                                        </div>

                                                         <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="gen-info-username-input">prenom</label>
                                                                <input type="text" class="form-control" placeholder="Enter user name" required >
                                                                <div class="invalid-feedback">Please enter a user name</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="gen-info-password-input">Password</label>
                                                        <input type="password" class="form-control" id="gen-info-password-input" placeholder="Enter Password" required >
                                                        <div class="invalid-feedback">Please enter a password</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-info-desc-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to more info</button>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-info-desc" role="tabpanel" aria-labelledby="pills-info-desc-tab">
                                                <div>
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                                                            <img src="assets/images/users/user-dummy-img.jpg" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                                <input id="profile-img-file-input" type="file" class="profile-img-file-input" accept="image/png, image/jpeg">
                                                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                                        <i class="ri-camera-fill"></i>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-14">Add Image</h5>

                                                    </div>
                                                    <div>
                                                        <label class="form-label" for="gen-info-description-input">Description</label>
                                                        <textarea class="form-control" placeholder="Enter Description" id="gen-info-description-input" rows="2" required></textarea>
                                                        <div class="invalid-feedback">Please enter a description</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button" class="btn btn-link text-decoration-none btn-label previestab" data-previous="pills-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to General</button>
                                                    <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-success-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-success" role="tabpanel" aria-labelledby="pills-success-tab">
                                                <div>
                                                    <div class="text-center">

                                                        <div class="mb-4">
                                                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                                        </div>
                                                        <h5>Well Done !</h5>
                                                        <p class="text-muted">You have Successfully Signed Up</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->
                                        </div>
                                        <!-- end tab content -->
                                    </form>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
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



    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('footerCss'); ?>

            <!-- JAVASCRIPT -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- prismjs plugin -->
    <script src="/assets/libs/prismjs/prism.js"></script>
 

    <!-- form wizard init -->
    <script src="/assets/js/pages/form-wizard_new.init.js"></script>

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



        // $('.form-steps').validate({
        //     rules: {
        //         name: {
        //             required: true
        //         }
        //     },
        //     messages: {
        //         name: {
        //             required: 'Please Enter Your Name'
        //         }
        //     }
        // });




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

     <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/simulation_form_test.blade.php ENDPATH**/ ?>