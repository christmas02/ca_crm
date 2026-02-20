 <?php

    $currentPage = Route::getFacadeRoot()->current()->uri();
    // dd($currentPage);
    

      if (Session::has('userprivilege_list')) {
        // code...
          $affbtnexp='non';
          $usersprivileges = Session::get('userprivilege_list');
          // dd($usersprivileges);
          if (in_array(25, $usersprivileges)) {
              // code...
               $affbtnexp ='oui';
          }

       }
   


          function nbre_perdu($cars, $selectedvalue) {
            foreach($cars as $index => $car) {
                if($car['realiserpar'] == $selectedvalue) return $index;
            }
            return FALSE;
        }

    
 ?>

<!doctype html>
<html lang="fr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
  <head>
    <meta charset="utf-8" />
        <?php if($currentPage == 'liste_prospection_groupee'): ?>
           <title>ConseilsAssur - Affectation en cours </title>
        <?php elseif($currentPage == 'liste_prospection_byagent_relance_admin'): ?>
           <title>ConseilsAssur - Relances en cours</title>
        <?php elseif($currentPage == 'liste_prosprection_created_online'): ?>
           <title>ConseilsAssur - Opportunites par agent</title>
        <?php elseif($currentPage == 'liste_contrat'): ?>
           <title>ConseilsAssur - Contrats AN/RN detailés</title>
        <?php elseif($currentPage == 'liste_prospection_ferme'): ?>
           <title>ConseilsAssur - Opportunites fermees</title>
        <?php else: ?>
        <title>ConseilsAssur - Opportunites par agent</title>
        <?php endif; ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta content="ConseilsAssur Conseils assurance" name="description" />
        <meta content="ConseilsAssur" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/images/favicon.ico">

        <style type="text/css">
          .form-check-input{
            border: solid 1.5px black !important;
          }
        </style>

    <?php echo $__env->yieldContent('headerCss'); ?>
  </head>
  <body>
    <!-- Begin page -->
    <div id="layout-wrapper">
      <header id="page-topbar">
        <div class="layout-width">
          <div class="navbar-header">
            <div class="d-flex">
              <!-- LOGO -->
              <div class="navbar-brand-box horizontal-logo">
                <a href="index.html" class="logo logo-dark">
                  <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="" height="22">
                  </span>
                  <span class="logo-lg">
                    <img src="assets/images/logo-dark.png" alt="" height="17">
                  </span>
                </a>
                <a href="index.html" class="logo logo-light">
                  <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="" height="22">
                  </span>
                  <span class="logo-lg">
                    <img src="assets/images/logo-light.png" alt="" height="17">
                  </span>
                </a>
              </div>
              <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id= "topnav-hamburger-icon">
                <span class="hamburger-icon">
                  <span></span>
                  <span></span>
                  <span></span>
                </span>
              </button>
              <!-- App Search-->
              <form class="app-search d-none d-md-block">
                <div class="position-relative">
                  <input type="text" class="form-control" placeholder="Rechercher" autocomplete="off" id="search-options" value="">
                  <span class="mdi mdi-magnify search-widget-icon"></span>
                  <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                </div>
                <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                  <div data-simplebar style="max-height: 320px;">
                    <!-- item-->
                    <div class="dropdown-header">
                      <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                    </div>
                    <div class="dropdown-item bg-transparent text-wrap">
                      <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i class="mdi mdi-magnify ms-1"></i>
                      </a>
                      <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i class="mdi mdi-magnify ms-1"></i>
                      </a>
                    </div>
                    <!-- item-->
                    <div class="dropdown-header mt-2">
                      <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                    </div>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                      <span>Analytics Dashboard</span>
                    </a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                      <span>Help Center</span>
                    </a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                      <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                      <span>My account settings</span>
                    </a>
                    <!-- item-->
                    <div class="dropdown-header mt-2">
                      <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                    </div>
                    <div class="notification-list">
                      <!-- item -->
                      <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                        <div class="d-flex">
                          <img src="assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                          <div class="flex-1">
                            <h6 class="m-0">Angela Bernier</h6>
                            <span class="fs-11 mb-0 text-muted">Manager</span>
                          </div>
                        </div>
                      </a>
                      <!-- item -->
                      <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                        <div class="d-flex">
                          <img src="assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                          <div class="flex-1">
                            <h6 class="m-0">David Grasso</h6>
                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                          </div>
                        </div>
                      </a>
                      <!-- item -->
                      <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                        <div class="d-flex">
                          <img src="assets/images/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                          <div class="flex-1">
                            <h6 class="m-0">Mike Bunch</h6>
                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="text-center pt-3 pb-1">
                    <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i>
                    </a>
                  </div>
                </div>
              </form>
            </div>
            <div class="d-flex align-items-center">
              <div class="dropdown d-md-none topbar-head-dropdown header-item">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-search fs-22"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                  <form class="p-3">
                    <div class="form-group m-0">
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                        <button class="btn btn-primary" type="submit">
                          <i class="mdi mdi-magnify"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
             

             
              <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                  <i class='bx bx-bell fs-22'></i>
                  <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                    <span id="isasap-pill">0</span> 
                    <span class="visually-hidden">unread messages</span>
                  </span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                  <div class="dropdown-head bg-primary bg-pattern rounded-top">
                    <div class="p-3">
                      <div class="row align-items-center">
                        <div class="col">
                          <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                        </div>
                        <div class="col-auto dropdown-tabs">
                          <span class="badge badge-soft-light fs-13"> <span id="nbreisasap"></span> Nouveaux</span>
                        </div>
                      </div>
                    </div>
                    <div class="px-2 pt-2">
                      <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                          <a class="nav-link active" data-bs-toggle="tab" href="tables-gridjs.html#all-noti-tab" role="tab" aria-selected="true"> CLIENT ASAP  </a>
                        </li>

                      </ul>
                    </div>
                  </div>
                  <div class="tab-content position-relative" id="notificationItemsTabContent">
                    <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                      <div data-simplebar style="max-height: 300px;" class="pe-2" id="notifcationlist">
                       
                      </div>
                    </div>
                    <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel" aria-labelledby="messages-tab">
                      <div data-simplebar style="max-height: 300px;" class="pe-2">
                        <div class="text-reset notification-item d-block dropdown-item">
                          <div class="d-flex">
                            <img src="assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                            <div class="flex-1">
                              <a href="tables-gridjs.html#!" class="stretched-link">
                                <h6 class="mt-0 mb-1 fs-13 fw-semibold">James Lemire</h6>
                              </a>
                              <div class="fs-13 text-muted">
                                <p class="mb-1">We talked about a project on linkedin.</p>
                              </div>
                              <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                <span>
                                  <i class="mdi mdi-clock-outline"></i> 30 min ago </span>
                              </p>
                            </div>
                            <div class="px-2 fs-15">
                              <div class="form-check notification-check">
                                <input class="form-check-input" type="checkbox" value="" id="messages-notification-check01">
                                <label class="form-check-label" for="messages-notification-check01"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="text-reset notification-item d-block dropdown-item">
                          <div class="d-flex">
                            <img src="assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                            <div class="flex-1">
                              <a href="tables-gridjs.html#!" class="stretched-link">
                                <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                              </a>
                              <div class="fs-13 text-muted">
                                <p class="mb-1">Answered to your comment on the cash flow forecast's graph 🔔.</p>
                              </div>
                              <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                <span>
                                  <i class="mdi mdi-clock-outline"></i> 2 hrs ago </span>
                              </p>
                            </div>
                            <div class="px-2 fs-15">
                              <div class="form-check notification-check">
                                <input class="form-check-input" type="checkbox" value="" id="messages-notification-check02">
                                <label class="form-check-label" for="messages-notification-check02"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="text-reset notification-item d-block dropdown-item">
                          <div class="d-flex">
                            <img src="assets/images/users/avatar-6.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                            <div class="flex-1">
                              <a href="tables-gridjs.html#!" class="stretched-link">
                                <h6 class="mt-0 mb-1 fs-13 fw-semibold">Kenneth Brown</h6>
                              </a>
                              <div class="fs-13 text-muted">
                                <p class="mb-1">Mentionned you in his comment on 📃 invoice #12501. </p>
                              </div>
                              <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                <span>
                                  <i class="mdi mdi-clock-outline"></i> 10 hrs ago </span>
                              </p>
                            </div>
                            <div class="px-2 fs-15">
                              <div class="form-check notification-check">
                                <input class="form-check-input" type="checkbox" value="" id="messages-notification-check03">
                                <label class="form-check-label" for="messages-notification-check03"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="text-reset notification-item d-block dropdown-item">
                          <div class="d-flex">
                            <img src="assets/images/users/avatar-8.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                            <div class="flex-1">
                              <a href="tables-gridjs.html#!" class="stretched-link">
                                <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>
                              </a>
                              <div class="fs-13 text-muted">
                                <p class="mb-1">We talked about a project on linkedin.</p>
                              </div>
                              <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                <span>
                                  <i class="mdi mdi-clock-outline"></i> 3 days ago </span>
                              </p>
                            </div>
                            <div class="px-2 fs-15">
                              <div class="form-check notification-check">
                                <input class="form-check-input" type="checkbox" value="" id="messages-notification-check04">
                                <label class="form-check-label" for="messages-notification-check04"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="my-3 text-center view-all">
                          <button type="button" class="btn btn-soft-success waves-effect waves-light">View All Messages <i class="ri-arrow-right-line align-middle"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab"></div>
                    <div class="notification-actions" id="notification-actions">
                      <div class="d-flex text-muted justify-content-center"> Select <div id="select-content" class="text-body fw-semibold px-1">0</div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="dropdown ms-sm-3 header-item topbar-user">
                <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="d-flex align-items-center">

                    <?php if(Session::get('profileImg') !='' || Session::get('profileImg') != null): ?>

                    <img class="rounded-circle header-profile-user" src="<?php echo e(Session::get('profileImg')); ?>" alt="Header Avatar">
                    <?php else: ?>
                    <img class="rounded-circle header-profile-user" src="/assets/images/users/avatar-0.png" alt="Header Avatar">

                    <?php endif; ?>

                    <span class="text-start ms-xl-2">

                      <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo e(Session::get('userlogin')); ?></span>
                      <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                     
                      <?php if(Session::get('userprivilege') == 'niveau1'): ?> Full <?php endif; ?>
                      <?php if(Session::get('userprivilege') == 'niveau2'): ?> Intermédiaire <?php endif; ?>
                      <?php if(Session::get('userprivilege') == 'niveau3'): ?> Débutant <?php endif; ?>
                     
                      
                    </span>
                    </span>
                  </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                  <!-- item-->
                  <h6 class="dropdown-header">Bienvenue <?php echo e(Session::get('login')); ?>!</h6>
                  <a class="dropdown-item" href="/monprofile">
                    <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                    <span class="align-middle">Profile</span>
                  </a>
                  
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/logout">
                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                    <span class="align-middle" data-key="t-logout">Deconnecter</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- removeNotificationModal -->
      <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
              <div class="mt-2 text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                  <h4>Are you sure ?</h4>
                  <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                </div>
              </div>
              <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- ========== App Menu ========== -->
      <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <!-- Dark Logo-->
          <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
              <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
              <img src="assets/images/logo-dark.png" alt="" height="17">
            </span>
          </a>
          <!-- Light Logo-->
          <a href="/" class="logo logo-light">
            <span class="logo-sm">
              <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
              <h3 style="color: white;margin-top: 20px;">ConseilsAssur </h3>
            </span>
          </a>
          <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
          </button>
        </div>
         <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="sidebar-background"></div>
      </div>
      <!-- Left Sidebar End -->
      <!-- Vertical Overlay-->
      <div class="vertical-overlay"></div>
      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
       
       <?php echo $__env->yieldContent('content'); ?>
      <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
      <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
    <!--preloader-->
    <div id="preloader">
      <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
    <div class="customizer-setting d-none d-md-block">
      <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
        <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
      </div>
    </div>
    

    <!-- JAVASCRIPT -->
    <?php echo $__env->yieldContent('footerCss'); ?>

    <?php
        

        $affbtnexp='non';
        $usersprivileges = Session::get('userprivilege_list');

        // dd($usersprivileges);
        if (in_array(25, $usersprivileges)) {
            // code...
             $affbtnexp ='oui';
        }
    ?>
<script


  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>

  <script src="/assets/js/fieldcontrollers.js" type="text/javascript"></script>


    <script type="text/javascript">
       $(document).ready(function () {

        
        // setInterval(function() {
        //    $.ajax({
        //           type: 'GET',
        //           url: '/notification_asap',
        //           success: function(response){
        //            //console.log(response)
        //            $('#notifcationlist').html(response);
        //           }
        //         });

        //     $.ajax({
        //           type: 'GET',
        //           url: '/notification_asapnbre',
        //           success: function(response){
        //            $('#nbreisasap').html(response);
        //             $('#isasap-pill').html(response);
                   
        //           }
        //         });

        //   }, 300000);


       })

        // setInterval(function() {
        //   $.ajax({
        //           type: 'GET',
        //           url: '/checksession',
        //           success: function(response){
        //             if(response =='no')
        //             location.reload();
        //           }
        //         });
        //  }, 300000);
    </script>
    
  </body>
</html><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/layouts/master.blade.php ENDPATH**/ ?>