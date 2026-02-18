 @extends('layouts.master')
    @section('headerCss')

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
                                <h4 class="mb-sm-0">Liste des agents en ligne</h4>

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
                                <div class="card-body">
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                 <th>id</th>
                                                 <th>Nom</th>
                                                 <th>Prenoms</th>
                                                 <th>Telephone</th>
                                                 <th> Actif </th>
                                                 <th> Privilege </th>
                                                 <th>Enregistré le</th>
                                                 <th>Modifier</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($listecommerciaux as $listecommerciaux_element)
                                            <tr>
                                                <td>{{$listecommerciaux_element['id']}}</td>
                                                <td>{{$listecommerciaux_element['lastname']}}</td>
                                                <td>{{$listecommerciaux_element['firstname']}}</td>
                                                <td>{{$listecommerciaux_element['PhoneNumber']}}</td>
                                                <td>
                                                    @if ( $listecommerciaux_element['isactive'] ==1)
                                                            
                                                    <span class="badge bg-success">Actif</span>
                                                    @else 
                                                         <span class="badge bg-danger">Désactivé</span>
                                                    @endif
                                            

                                            </td>
                                                <td>
                                                     @if ($listecommerciaux_element['privilege'] == 'niveau1') 
                                                         Full
                                                     @elseif($listecommerciaux_element['privilege'] == 'niveau2')
                                                     intermediaire
                                                     @else
                                                     Debutant
                                                     @endif
                                                </td>
                                                <td>{{\Carbon\Carbon::parse($listecommerciaux_element['created_at'])->format('d-m-Y H:i');}}</td>

                                                <td>
                                                    <a class="btn btn-primary" href="edit_online_operator/{{$listecommerciaux_element['id']}}"> modifier</a>
                                                </td>
                                            </tr>

                                          @endforeach
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->


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
                                Design & Develop by Themesbrand
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
     @stop



    

    <!-- JAVASCRIPT -->
    @section('footerCss')
        <!-- JAVASCRIPT -->
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
    @stop