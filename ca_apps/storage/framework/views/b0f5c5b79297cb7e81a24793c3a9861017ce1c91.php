 
    <?php $__env->startSection('headerCss'); ?>

    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

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

    <style>
        .percent{
            min-width: 50px;
            display: inline-block;
            text-align: right;
            font-weight: 600;
        }
    </style>

  <?php
    
        $affbtnexp='non';
        $usersprivileges = Session::get('userprivilege_list');
        // dd($usersprivileges);
        if (in_array(25, $usersprivileges)) {
            // code...
             $affbtnexp ='oui';
        }



         if ($nombre_contrat_rnYest!=0) 
        $evolu_contratrn = round(($nombre_contrat_rn - $nombre_contrat_rnYest) *100/$nombre_contrat_rnYest,2);
        else $evolu_contratrn =0;

         if ($nombre_contrat_anYest!=0) 
         $evolu_contratan = round(($nombre_contrat_an - $nombre_contrat_anYest) *100/$nombre_contrat_anYest,2);
         else $evolu_contratan =0;

         if ($carte_attestYest[0]['nbrecartegrise']!=0) 
          $evolu_cartecg = round(($carte_attest[0]['nbrecartegrise'] - $carte_attestYest[0]['nbrecartegrise']) *100/$carte_attestYest[0]['nbrecartegrise'],2);
         else $evolu_cartecg =0;

         if ($carte_attestYest[0]['nbreattestation']!=0) 
           $evolu_attest = round(($carte_attest[0]['nbreattestation'] - $carte_attestYest[0]['nbreattestation']) *100/$carte_attestYest[0]['nbreattestation'],2);
          else $evolu_attest =0;

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
                                <h4 class="mb-sm-0">TABLEAU DE BORD - 
                                   <?php echo e(date('d-m-Y H:i')); ?>

                               </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                        <li class="breadcrumb-item active">STAT</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card crm-widget">
                                <div class="card-body p-0">
                                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                                        <div class="col">
                                            <div class="py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Opportunite  Terrain <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-space-ship-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="<?php echo e($nombre_opp_remont); ?>">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->

                                        <div class="col">
                                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13"> Opportunites Gagnées <i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-trophy-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="<?php echo e($statopp[0]['totalgagne'] ?? 0); ?>">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                         
                                        <div class="col">
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Prime Nette <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="<?php echo e($statopp[0]['totalprimenet'] ??0); ?>">0</span> Fcfa</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Prime TTC <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" data-target="<?php echo e($statopp[0]['totalprimettc']??0); ?>">0</span> Fcfa</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col"> 
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Rendement - veille<i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-pulse-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">

                                                        <?php if($statopp_antecedent[0]['totalprimenet']!=0 && $statopp_antecedent[0]['totalprimenet']!=null): ?>
                                                         <h2 class="mb-0"><span class="counter-value" data-target="<?php echo e(round(($statopp[0]['totalprimenet'] - $statopp_antecedent[0]['totalprimenet']) / $statopp_antecedent[0]['totalprimenet'] *100 ,2 )); ?>">0</span>%</h2>
                                                        <?php else: ?> 
                                                         <h2 class="mb-0"><span class="counter-value" data-target="0.0">0</span>%</h2>
                                                        <?php endif; ?>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        
                                    </div><!-- end row -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                     <div class="row">
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Contrat RN</p>
                                                    </div>



                                                    <div class="flex-shrink-0">
                                                        <?php if($evolu_contratrn>0): ?>
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +<?php echo e($evolu_contratrn); ?> %
                                                        </h5>
                                                        <?php else: ?>
                                                         <h5 class="text-danger fs-14 mb-0">
                                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i> <?php echo e($evolu_contratrn); ?> %
                                                        </h5>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo e($nombre_contrat_rn); ?>">0</span></h4>
                                                        
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-success rounded fs-3">
                                                            <i class="bx bx-dollar-circle text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">

                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Contrat AN</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <?php if($evolu_contratan>0): ?>
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +<?php echo e($evolu_contratan); ?> %
                                                        </h5>
                                                        <?php else: ?>
                                                         <h5 class="text-danger fs-14 mb-0">
                                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i> <?php echo e($evolu_contratan); ?> %
                                                        </h5>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo e($nombre_contrat_an); ?>">0</span></h4>
                                                        
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                                            <i class="bx bx-shopping-bag text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Carte grise</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <?php if($evolu_cartecg>0): ?>
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +<?php echo e($evolu_cartecg); ?> %
                                                        </h5>
                                                        <?php else: ?>
                                                         <h5 class="text-danger fs-14 mb-0">
                                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i> <?php echo e($evolu_cartecg); ?> %
                                                        </h5>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>

                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo e($carte_attest[0]['nbrecartegrise']); ?>">0</span></h4>
                                                        
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-warning rounded fs-3">
                                                            <i class="bx bx-user-circle text-warning"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Attestations</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        

                                                         <?php if($evolu_attest>0): ?>
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +<?php echo e($evolu_attest); ?> %
                                                        </h5>
                                                        <?php else: ?>
                                                         <h5 class="text-danger fs-14 mb-0">
                                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i> <?php echo e($evolu_attest); ?> %
                                                        </h5>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo e($carte_attest[0]['nbreattestation']); ?>">0</span> </h4>
                                                        
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                                            <i class="bx bx-wallet text-primary"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xxl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Statuts opportunités</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="dashboard-crm.html#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold text-uppercase fs-12">Trier par: </span><span class="text-muted">Aujourd'hui<i class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body pb-0">
                                    <div id="sales-forecast-chart" data-colors='["--vz-success", "--vz-secondary", "--vz-gray-dark", "--vz-warning", "--vz-danger", "--vz-purple"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div><!-- end card -->
                        </div><!-- end col -->

                        

                        <div class="col-xxl-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Aperçu des opportunités</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="dashboard-crm.html#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold text-uppercase fs-12">Trier par: </span><span class="text-muted">2024<i class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="dashboard-crm.html#">Aujourd'hui</a>
                                                <a class="dropdown-item" href="dashboard-crm.html#">Semaine precedente</a>
                                                <a class="dropdown-item" href="dashboard-crm.html#">Mois précedent</a>
                                                <a class="dropdown-item" href="dashboard-crm.html#">Année précedent</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                               
                                
                                <div class="card-body px-0">
                                    <ul class="list-inline main-chart text-center mb-0">
                                        <li class="list-inline-item chart-border-left me-0 border-0">
                                          <?php if(count($totalbyYear)!=0): ?> 
                                            <h4 class="text-primary"><?php echo e($totalbyYear[0]['totalgagne']); ?> <span class="text-muted d-inline-block fs-13 align-middle ms-2">Gagnés</span></h4>
                                            <?php endif; ?>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <?php if(count($totalbyYear)!=0): ?> 
                                            <h4><?php echo e($totalbyYear[0]['totalperdue']); ?> <span class="text-muted d-inline-block fs-13 align-middle ms-2">Perdus</span>
                                            </h4>
                                            <?php endif; ?>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                             <?php if(count($totalbyYear)!=0): ?> 
                                            <h4><span data-plugin="counterup"><?php echo e(round(($totalbyYear[0]['totalgagne'] * 100)/$totalbyYear[0]['totaltraites'],2 )); ?></span>%<span class="text-muted d-inline-block fs-13 align-middle ms-2"> Ratio</span></h4>
                                            <?php endif; ?>
                                        </li>
                                    </ul>

                                    <div id="revenue-expenses-charts" data-colors='["--vz-success", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-xl-7">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Performances Conseillés - Top 10</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="dashboard-crm.html#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">Aujourd'hui<i class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="dashboard-crm.html#">Aujourd'hui</a>
                                                <a class="dropdown-item" href="dashboard-crm.html#">Semaine passée</a>
                                                <a class="dropdown-item" href="dashboard-crm.html#">Mois passé</a>
                                                <a class="dropdown-item" href="dashboard-crm.html#">Année</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless table-hover table-nowrap align-middle mb-0">
                                            <thead class="table-light">
                                                <tr class="text-muted">
                                                    <th scope="col">ID</th>
                                                    <th scope="col" style="width: 20%;">Date embauche</th>
                                                    <th scope="col">Nom et Prenoms</th>
                                                    <th scope="col" style="width: 16%;">Niveau</th>
                                                    <th scope="col" style="width: 12%;">Prime G. Net </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                         
                                             <?php $__currentLoopData = $stat_conseilles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat_conseilles_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <tr>
                                                    <td><?php echo e($stat_conseilles_element['agent_backoffice']['id']); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($stat_conseilles_element['agent_backoffice']['created_at'])->format('d-m-Y')); ?></td>
                                                    <td><img src="<?php echo e($stat_conseilles_element['agent_backoffice']['profile_picture'] ?? '/assets/images/users/user-dummy-img.jpg'); ?>" alt="" class="avatar-xs rounded-circle me-2">
                                                        <a href="dashboard-crm.html#javascript: void(0);" class="text-body fw-medium"><?php echo e($stat_conseilles_element['agent_backoffice']['lastname'].' '.$stat_conseilles_element['agent_backoffice']['firstname']); ?></a>
                                                    </td>
                                                    <td><span class="badge badge-soft-success p-2">Debutant</span></td>
                                                    <td>
                                                        <div class="text-nowrap"><?php echo e(number_format($stat_conseilles_element['sumprimenet'], 0, '.', ' ') ?? 0); ?> Fcfa</div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->


                         <div class="col-xl-5">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Recap du jour</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="dropdown-btn text-muted" href="dashboard-projects.html#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                               Aujourd'hui<i class="mdi mdi-chevron-down ms-1"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="dashboard-projects.html#">Tous</a>
                                                <a class="dropdown-item" href="dashboard-projects.html#"> 7 dern jours</a>
                                                <a class="dropdown-item" href="dashboard-projects.html#"> 30 dern jours</a>
                                                <a class="dropdown-item" href="dashboard-projects.html#"> 90 dern jours</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div id="prjects-status" data-colors='["--vz-success", "--vz-primary", "--vz-warning", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-center align-items-center mb-4">
                                            <h2 class="me-3 ff-secondary mb-0"><?php echo e($statopp[0]['totaltraites']??0); ?></h2>
                                            <div>
                                                <p class="text-muted mb-0">Opportunités traitées</p>
                                                <p class="text-success fw-medium mb-0">
                                                    <span class="badge badge-soft-success p-1 rounded-circle"><i class="ri-arrow-right-up-line"></i></span> +<?php echo e($statopp[0]['totalgagne'] ??0); ?> gagnées
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-success align-middle me-2"></i> Gagnées</p>
                                            <div>
                                                <span class="text-muted pe-5"><?php echo e($statopp[0]['totalgagne'] ??0); ?> </span>
                                                <?php if($statopp[0]['totaltraites']!=0 && $statopp[0]['totalgagne']!=null): ?>
                                                    
                                              
                                                <span class="percent"> <?php echo e(round($statopp[0]['totalgagne']*100 / $statopp[0]['totaltraites'],2)); ?></span> %
                                                <?php else: ?>
                                                  <span class="percent"> 0%</span>
                                                <?php endif; ?>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-primary align-middle me-2"></i> Rdv Souscription</p>
                                            <div>
                                                <span class="text-muted pe-5"><?php echo e($statopp[0]['totalrdvsouscription']??0); ?> </span>

                                                <?php if($statopp[0]['totaltraites']!=0 && $statopp[0]['totalrdvsouscription']!=null): ?>
                                                    
                                              
                                                <span class="percent"> <?php echo e(round($statopp[0]['totalrdvsouscription']*100 / $statopp[0]['totaltraites'],2)); ?></span> %
                                                <?php else: ?>
                                                  <span class="percent"> 0%</span>
                                                <?php endif; ?>
                                              
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-warning align-middle me-2"></i> Poursuivre</p>
                                            <div>
                                                <span class="text-muted pe-5"><?php echo e($statopp[0]['totalpoursuivre']??0); ?>  </span>
                                                 <?php if($statopp[0]['totaltraites']!=0 && $statopp[0]['totalpoursuivre']!=null): ?>
                                                    
                                              
                                                <span class="percent"> <?php echo e(round($statopp[0]['totalpoursuivre']*100 / $statopp[0]['totaltraites'],2)); ?></span> %
                                                <?php else: ?>
                                                  <span class="percent"> 0%</span>
                                                <?php endif; ?>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex justify-content-between py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-danger align-middle me-2"></i> Reports</p>
                                            <div>
                                                <span class="text-muted pe-5"><?php echo e($statopp[0]['totalreporte']??0); ?> </span>
                                                <?php if($statopp[0]['totaltraites']!=0 && $statopp[0]['totalreporte']!=null): ?>
                                                    
                                              
                                                <span class="percent"> <?php echo e(round($statopp[0]['totalreporte']*100 / $statopp[0]['totaltraites'],2)); ?></span> %
                                                <?php else: ?>
                                                  <span class="percent"> 0%</span>
                                                <?php endif; ?>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex justify-content-between py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-danger align-middle me-2"></i> Perdues</p>
                                            <div>
                                                <span class="text-muted pe-5"><?php echo e($statopp[0]['totalperdue']??0); ?> </span>
                                                <?php if($statopp[0]['totaltraites']!=0 && $statopp[0]['totalperdue']!=null): ?>
                                                    
                                                <span class="percent"> <?php echo e(round($statopp[0]['totalperdue']*100 / $statopp[0]['totaltraites'],2)); ?></span> %
                                                <?php else: ?>
                                                  <span class="percent"> 0%</span>
                                                <?php endif; ?>
                                            </div>
                                        </div><!-- end -->


                                        <div class="d-flex justify-content-between py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-danger align-middle me-2"></i> Hors cible</p>
                                            <div>
                                                <span class="text-muted pe-5"><?php echo e($statopp[0]['totalhorscible']?? 0); ?> </span>
                                                <?php if($statopp[0]['totaltraites']!=0 && $statopp[0]['totalhorscible']!=null): ?>
                                              
                                                <span class="percent"> <?php echo e(round($statopp[0]['totalhorscible']*100 / $statopp[0]['totaltraites'],2)); ?></span> %
                                                <?php else: ?>
                                                  <span class="percent"> 0%</span>
                                                <?php endif; ?>
                              </div>
                                        </div><!-- end -->
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                    </div><!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Velzon.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by ConseilsAssur
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    <?php $__env->stopSection(); ?>
    

    <?php $__env->startSection('footerCss'); ?>

    <!-- JAVASCRIPT -->


    <script type="text/javascript">
      
         var totalgagne = '<?php echo $statopp[0]['totalgagne'] ??0;?>';
     
         var totalperdue = '<?php echo $statopp[0]['totalperdue'] ??0;?>';
      
         var totalreporte = '<?php echo $statopp[0]['totalreporte']??0;?>';
      
         var totalpoursuivre = '<?php echo $statopp[0]['totalpoursuivre']??0;?>';    
     
         var totalhorscible = '<?php echo $statopp[0]['totalhorscible']??0;?>';
    
         var totalrdvsouscription = '<?php echo $statopp[0]['totalrdvsouscription']??0;?>';
    
    //total par mois
       var opp_gagn_jan = '<?php echo $totalbymonth[0]['totalgagne']??0;?>';
   
       var opp_gagn_fev = '<?php echo $totalbymonth[1]['totalgagne']??0;?>';

       var opp_gagn_mar = '<?php echo $totalbymonth[2]['totalgagne']??0;?>';
 
       var opp_gagn_avr = '<?php echo $totalbymonth[3]['totalgagne']??0;?>';
  
       var opp_gagn_mai = '<?php echo $totalbymonth[4]['totalgagne']??0 ;?>';
 
       var opp_gagn_jun = '<?php echo $totalbymonth[5]['totalgagne']??0;?>';
  
       var opp_gagn_jui = '<?php echo $totalbymonth[6]['totalgagne']??0;?>';

       var opp_gagn_out = '<?php echo $totalbymonth[7]['totalgagne']??0;?>';
  
       var opp_gagn_sep = '<?php echo $totalbymonth[8]['totalgagne']??0;?>';
  
       var opp_gagn_oc  = '<?php echo $totalbymonth[9]['totalgagne']??0;?>';

       var opp_gagn_nov  = '<?php echo $totalbymonth[10]['totalgagne']??0;?>';
 
       var opp_gagn_dec = '<?php echo $totalbymonth[11]['totalgagne']??0;?>';

  
       var opp_perdu_jan = '<?php echo $totalbymonth[0]['totalperdue']??0;?>';

       var opp_perdu_fev = '<?php echo $totalbymonth[1]['totalperdue']??0;?>';
 
       var opp_perdu_mar = '<?php echo $totalbymonth[2]['totalperdue']??0;?>';

       var opp_perdu_avr = '<?php echo $totalbymonth[3]['totalperdue']??0;?>';
  
       var opp_perdu_mai = '<?php echo $totalbymonth[4]['totalperdue']??0;?>';

       var opp_perdu_jun = '<?php echo $totalbymonth[5]['totalperdue']??0;?>';
 
       var opp_perdu_jui = '<?php echo $totalbymonth[6]['totalperdue']??0;?>';

       var opp_perdu_out = '<?php echo $totalbymonth[7]['totalperdue']??0;?>';
 
       var opp_perdu_sep = '<?php echo $totalbymonth[8]['totalperdue']??0;?>';
  
       var opp_perdu_oc  = '<?php echo $totalbymonth[9]['totalperdue']??0;?>';
 
       var opp_perdu_nov  = '<?php echo $totalbymonth[10]['totalperdue']??0;?>';
   
       var opp_perdu_dec  = '<?php echo $totalbymonth[11]['totalperdue']??0;?>';

       console.log(opp_gagn_jan +' '+ opp_perdu_oc);

    </script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/js/plugins.js"></script>

    <!-- apexcharts -->
    <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Dashboard init -->
    <script src="/assets/js/pages/dashboard-crm.init.js"></script>

     <!-- projects js -->
    <script src="assets/js/pages/dashboard-projects.init.js"></script>

    <!-- App js -->
    <script src="/assets/js/app.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/stat_diagram.blade.php ENDPATH**/ ?>