 @extends('layouts.master')
    @section('headerCss')

    <!-- gridjs css -->
        <link rel="stylesheet" href="/assets/libs/gridjs/theme/mermaid.min.css">

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
                      <h4 class="mb-sm-0">Grid Js</h4>
                      <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                          <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Tables</a>
                          </li>
                          <li class="breadcrumb-item active">Grid Js</li>
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
                        <h4 class="card-title mb-0 flex-grow-1">Base Example</h4>
                      </div>
                      <!-- end card header -->
                      <div class="card-body">
                        <div id="table-gridjs"></div>
                      </div>
                      <!-- end card-body -->
                    </div>
                    <!-- end card -->
                  </div>
                  <!-- end col -->
                </div>
                <!-- end row -->
                
              </div>
              <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <footer class="footer">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-6">
                    <script>
                      document.write(new Date().getFullYear())
                    </script> © Velzon.
                  </div>
                  <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block"> Design & Develop by Themesbrand </div>
                  </div>
                </div>
              </div>
            </footer>
         </div>
        <!-- end main content-->
     @stop



    

    <!-- JAVASCRIPT -->
    @section('footerCss')
        <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/assets/libs/node-waves/waves.min.js"></script>
        <script src="/assets/libs/feather-icons/feather.min.js"></script>
        <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
        <script src="/assets/js/plugins.js"></script>

        <!-- prismjs plugin -->
        <script src="/assets/libs/prismjs/prism.js"></script>

        <!-- gridjs js -->
        <script src="/assets/libs/gridjs/gridjs.umd.js"></script>
        <!-- gridjs init -->
        <script src="/assets/js/pages/gridjs.init.js"></script>

        <!-- App js -->
        <script src="/assets/js/app.js"></script>
    @stop