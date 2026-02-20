 
    <?php $__env->startSection('headerCss'); ?>
    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

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
                  <h4 class="mb-sm-0">MODEL</h4>
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
                    <h4 class="card-title mb-0 flex-grow-1">Créer un model de vehicule</h4>
                    <div class="flex-shrink-0">
                      
                    </div>
                  </div>
                  <!-- end card header -->
                  <div class="card-body">
                    <div class="live-preview">
                      <div class="row gy-4">

                        <div class="col-md-7" style="margin: 0 auto">


                            <div class="alert alert-success" role="alert" style="display:none">
                                                    <strong> Utilisateur enregistré avec succès! </strong>  <b> <a href="">Voir la liste des utilisateurs</a></b> en savoir
                                                </div>
                            
                            <form id="createuserform" enctype="multipart/form-data" action="" autocomplete="off" method="post">

                                <div class="row">
                                  <div class="col-md-6"></div>
                                  <div class="col-md-6">
                                  <h2 style="width: 75%;display: inline-block;"></h2>
                                                
                                            </div>

                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formMarque" class="form-label">Marque</label>
                                                        <select name="marque" id="formMarque" class="form-select" data-choices data-choices-sorting="true" required>
                                                            <option selected value="">Choisir...</option>
                                                            <?php $__currentLoopData = $carlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                 <option value="<?php echo e($car['brand']); ?>"><?php echo e($car['brand']); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                             <?php $__currentLoopData = $carlist2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                 <option value="<?php echo e($car2['libelle']); ?>"><?php echo e($car2['libelle']); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div> 
                                <!--end col-->
                                <div class=" col-md-6">
                                  <div>
                                    <label for="labelInput" class="form-label">Model</label>
                                    <input type="text" name="carmodel" class="form-control requiredField" >
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
                  url: '/create_cmodel',
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

     <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/create_model.blade.php ENDPATH**/ ?>