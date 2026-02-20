 
    <?php $__env->startSection('headerCss'); ?>

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

    <?php
    
        $affbtnexp='non';
        $usersprivileges = Session::get('userprivilege_list');
        // dd($usersprivileges);
        if (in_array(25, $usersprivileges)) {
            // code...
             $affbtnexp ='oui';
        }
    ?>
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
                                <h4 class="mb-sm-0">Opportunite Hors cible / Perdue</h4>

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

                     

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Enregistrements</h5>
                                </div>


                                <div id="filterform" class="row gy-4" style="padding-left: 20px;background: #f2f2f2;margin: 15px;">
                                    <h2>FORMULAIRE DE RECHERCHE</h2>
                                    <div class="col-md-2">
                                        <label for="basiInput" class="form-label">Filtrer </label>
                                         <select id="selectfiltre" class="form-select mb-3" aria-label="Default select example">
                                            <option selected>choisir un filtre</option>
                                            <option value="tel">Telephone</option>
                                            <option value="date_ech">Date echéance</option>
                                            <option value="date_rel">Date relance</option>
                                        </select>
                                    </div>


                                    <div class="col-md-10">
                                        <form id="formtelfield" method="POST" action="/listeprosprectionbytel"  class="col-md-7" style="display:none">
                                            <?php echo csrf_field(); ?>
                                            <div   style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Téléphone</label>
                                                    <input id="telfiltre" type="text" name="telfiltre" class="form-control requiredField" id="basiInput" placeholder="Ex: 0101020203">
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                        </form>
                                         <form id="formdatefield" method="POST" action="/listeprosprectionbydate"  class="col-md-7" style="display:block">
                                            <?php echo csrf_field(); ?>
                                            <input id="hiddenselectedfiltre" type="hidden" name="selectfiltre">
                                            <div  style=" display: inline-block;width: 170px;">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Date debut</label>
                                                        <input id="datefiltre_deb" type="date" name="datefiltre_deb" class="form-control requiredField" id="exampleInputdate" required>
                                                    </div>
                                            </div>
                                            <div  style=" display: inline-block;width: 170px;">
                                                    <div class="mb-3">
                                                        <label for="exampleInputdate" class="form-label"> Date fin</label>
                                                        <input id="datefiltre_fin" type="date" name="datefiltre_fin" class="form-control requiredField" id="exampleInputdate" required>
                                                    </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                        </form>

                                        </div>
                                        
                                </div>


                                <div class="card-body">
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                 <th>Immatriculation</th>
                                                 <th>Nom</th>
                                                 <th>Prenoms</th>
                                                 <th>Echeance</th>
                                                 <th>Relance</th>
                                                 <th>Telephone</th>
                                                 <th>Statut</th>
                                                 <th>Observation</th> 
                                                 <th>Enregistrer  le </th>
                                                 <th>Commenter</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                           
                                          <?php $__currentLoopData = $listeprospection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listeprospection_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                           <?php if($listeprospection_element['resultat'] == 'perdu' || $listeprospection_element['resultat'] == 'horscible'): ?>
                                            <tr>
                                                
                                                <td><?php echo e($listeprospection_element['opportunite']['plaque_immatriculation'] ?? 'Non défini'); ?></td>
                                                <td><?php echo e($listeprospection_element['opportunite']['nom']); ?></td>
                                                <td><?php echo e($listeprospection_element['opportunite']['prenoms']); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($listeprospection_element['opportunite']['echeance'])->format('d-m-Y H:i')); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($listeprospection_element['daterelance'])->format('d-m-Y ')); ?></td>
                                                <td><?php echo e($listeprospection_element['opportunite']['telephone']); ?></td>

                                                <td> 
                                                    
                                                   
                                                    
                                                        
                                                   

                                                         <?php if($listeprospection_element['resultat'] == 'horscible'): ?>
                                                            <span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospection_element['resultat']); ?></span>
                                                          <?php endif; ?>

                                                           <?php if($listeprospection_element['resultat'] == 'reporte'): ?>
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospection_element['resultat']); ?></span>

                                                         <?php endif; ?>


                                                          <?php if($listeprospection_element['resultat']== 'perdu'): ?>
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospection_element['resultat']); ?></span>

                                                         <?php endif; ?>



                                                          <?php if($listeprospection_element['resultat']== 'poursuivre'): ?>
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospection_element['resultat']); ?></span>

                                                         <?php endif; ?>


                                                         <?php if($listeprospection_element['resultat']== 'gagne'): ?>
                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospection_element['resultat']); ?></span>

                                                         <?php endif; ?>

                                                </td>
                                                
                                                <td>

                                                    <div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($listeprospection_element['opportunite']['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Afficher     <i class="ri-eye-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="<?php echo e($listeprospection_element['opportunite']['id']); ?>" style="padding: 10px;min-width: 300px;border: solid 2px #40518959;">
                                                                     <?php echo e($listeprospection_element['opportunite']['observation']); ?>

                                                                </div>
                                                            </div>


                                                </td>
                                                <td><?php echo e(\Carbon\Carbon::parse($listeprospection_element['opportunite']['created_at'])->format('d-m-Y ')); ?></td>
                                                <td>
                                                    <a class="btn btn-primary" href="/enregister_note_propection/<?php echo e($listeprospection_element['opportunite']['id']); ?>">Commenter</a>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->


                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


                                        <div>
                                            <div id="agentdispo" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Affectation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="content_liv_pop">
                                                           
                                                            <table class="table table-nowrap">
                                                            <tr style="background:#e2e2e2;">
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold">MOISE DE KOTCHY </span>
                                                                    <span style="display:block;"> 10 opportunités en cours</span>
                                                                </td>
                                                                <td style="text-align:right;padding-right: 10px;"><a class="btn btn-primary"  href="">Attribuer</a></td>
                                                            </tr>
                                                            <tr >
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold">MOISE DE KOTCHY </span>
                                                                    <span style="display:block;"> 10 opportunités en cours</span>
                                                                </td>
                                                                <td style="text-align:right;padding-right: 10px;"><a class="btn btn-primary" href="">Attribuer</a></td>
                                                            </tr>
                                                        </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                           
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>



                                        <!-- Static Backdrop -->
                                        
                                        <!-- staticBackdrop Modal -->
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
                                                            <p class="text-muted mb-4"> L'affectation s'est effectuées avec succès </p>
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                                <a href="javascript:void(0);" class="btn btn-success">OK</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>






                

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Velzon.
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
     <?php $__env->stopSection(); ?>



    

    <!-- JAVASCRIPT -->
    <?php $__env->startSection('footerCss'); ?>
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
               if (typefiltre == 'date_ech' || typefiltre == 'date_rel' ) {
                  $('#hiddenselectedfiltre').val(typefiltre);
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','block'); 
              }  
          }) 
                        



        </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/liste_prospection_byagent_ferme.blade.php ENDPATH**/ ?>