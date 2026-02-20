 
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
  
    <?php
      // dd($findAgent);
    ?>

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
                  <h4 class="mb-sm-0">OPERATEUR TERRAIN</h4>
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
                    <h4 class="card-title mb-0 flex-grow-1">Modifier un operateur Terrain</h4>
                    <div class="flex-shrink-0">
                      <div class="form-check form-switch form-switch-right form-switch-md">
                        <label for="form-grid-showcode" class="form-label text-muted">Show Code</label>
                        <input class="form-check-input code-switcher" type="checkbox" id="form-grid-showcode">
                      </div>
                    </div>
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
                                                        <input name="isactiv" type="checkbox" class="form-check-input" id="customSwitchsizelg" <?php if($findAgent['isactive']==1): ?>checked <?php endif; ?> >
                                                        <label class="form-check-label" for="customSwitchsizelg">Est actif</label>
                                                    </div>
                                                </div>
                                <div class=" col-md-6">
                                  <div>
                                    <label for="basiInput" class="form-label">Nom</label>
                                    <input type="text" name="lastname" class="form-control " value="<?php echo e($findAgent['lastname']); ?>" >
                                  </div>
                                </div>
                                <!--end col-->
                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Prénoms</label>
                                    <input type="text" name="firstname" class="form-control " value="<?php echo e($findAgent['firstname']); ?>">
                                  </div>
                                </div>
                                <!--end col-->

                                <div class=" col-md-6">
                                  <div>
                                    <label for="basiInput" class="form-label">Numéro Téléphone</label>
                                    <input type="text" name="phonenumber" value="<?php echo e($findAgent['phonenumber']); ?>" class="form-control requiredField" >
                                  </div>
                                </div>
                                <!--end col-->

                                <!--end col-->

                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" class="form-control " i>
                                  </div>
                                </div>

                                <div class="col-md-12" style="margin-top: 10px">
                                    <div class="input-group">
                                        <button id="updatebtn" class="btn btn-primary" style="margin-right: 40px;width: 200px;" type="button">Mettre à jour</button>

                                        <button class="btn btn-success" style="width: 200px" type="button">Annuler</button>
                                    </div>
                                </div>
                                
                                </div>

                                <input type="hidden" name="selecteduser" value="<?php echo e($findAgent['id']); ?>">
                                
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
                            
                            </div>
                      </div>
                      <!--end row-->
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

            $('.requiredField').addClass('fieldtrue');
            $('.updateform .requiredField').each(function() {
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
                  url: '/updateuserterrain',
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
                  }
                });
            }
         })



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

     <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/edit_operateur_terrain.blade.php ENDPATH**/ ?>