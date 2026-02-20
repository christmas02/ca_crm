 
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
                                    <h4 class="card-title mb-0 flex-grow-1">Formulaire de proprection</h4>
                                    <div class="flex-shrink-0">
                                        
                                    </div>
                                </div><!-- end card header -->


                                <div class="card-body">
                                    <p class="text-muted"></p>
                                    <div class="live-preview">
                                        <div class="alert alert-success" role="alert" style="display:none">
                                                    <strong> Commentaire enregistré avec succès! </strong>  <b> <a href=""></a>
                                                </div>
                                        <form id="createprospectform" action="javascript:void(0);">
                                            <div class="row">
                                                

                                                
                                                <!--end col-->

                                                <div class="col-md-12">
                                                    <div>
                                                        <label for="formFile" class="form-label">Carte grise</label>
                                                        <span class="msg_file" style="color: red;margin-left: 10px;display: none;"> fichier invalide</span>
                                                        <input id="Imgcartegrise" name="Imgcartegrise" class="form-control" type="file" >
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <!--end col-->
                                                
                                                <!--end col-->
                                                <div style="margin-top:10px"></div>
                                                

                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button id="saveprospect" type="submit" class="btn btn-primary">Scanner</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>

                                            <table id="infosvehicule" style="display: none;" class="table table-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">PROPRIETAIRE</th>
                                                            <th class="proprietaire" scope="col">Customer</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row"><a href="#" class="fw-semibold">MARQUE</a></th>
                                                            <td class="marque">Bobby Davis</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><a href="#" class="fw-semibold">MODEL</a></th>
                                                            <td class="model">Christopher Neal</td>
                                                            
                                                            
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><a href="#" class="fw-semibold">MODEL</a></th>
                                                            <td class="nbreplace">Christopher Neal</td>
                                                            
                                                            
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><a href="#" class="fw-semibold">CARBURANT</a></th>
                                                            <td class="carburant">Monkey Karry</td>
                                                          
                                                            
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><a href="#" class="fw-semibold">PUISSANCE</a></th>
                                                            <td class="puissance">James White</td>
                                                           
                                                        </tr>

                                                         <tr>
                                                            <th scope="row"><a href="#" class="fw-semibold">MISE EN CIRCULATION</a></th>
                                                            <td class="mise_circulation">James White</td>
                                                           
                                                        </tr>

                                                        <tr>
                                                            <th scope="row"><a href="#" class="fw-semibold">IMMATRICULATION</a></th>
                                                            <td class="immatriculation">James White</td>
                                                           
                                                        </tr>
                                                    </tbody>
                                                </table>


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



    <?php $__env->stopSection(); ?>


    <?php $__env->startSection('footerCss'); ?>

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
                  // url: '/addProspectOnline',
                  url: '/detecttext',
                  beforeSend: function(){
                    //  btnclicked.removeClass('normalstate');
                    // btnclicked.addClass('is-active');
                     btnclicked.addClass('not-active').html('Patienter...'); 
                  },
                  success: function(response){
                    const myArray = response.split("*");
                    btnclicked.removeClass('not-active').html('Scanner'); 
                    // var retourJson =JSON.parse(response);
                    //console.log(response.message);
                   if (myArray[0] =='successfull') {
                    // var button = btnclicked;
                    // $('.alert-success').css('display','block');
                    
                     $('#infosvehicule').css('display','block');
                    $('.proprietaire').html(myArray[1]);
                    $('.marque').html(myArray[8]);
                    $('.model').html(myArray[6]);
                    $('.carburant').html(myArray[3]);
                    $('.nbreplace').html(myArray[5]);
                    $('.puissance').html(myArray[4]);
                    $('.mise_circulation').html(myArray[7]);
                    $('.immatriculation').html(myArray[2]);
                    









                    // $("input[type=text], input[type=date], textarea").val("");

                    //  // $('#successModal').modal('show');
                    // $("input[type=text], textarea, input[type=date], input[type=time],input[type=tel]").val("");
             
                    // $("#Imgattesation").val(null);
                    // $("#Imgcartegrise").val(null);
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
      if(iSize > 8100000){
        hasErrorf = true;
      }
    }
    return hasErrorf;
  }


     </script>   

     <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/scan_cg_form.blade.php ENDPATH**/ ?>