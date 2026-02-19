@extends('layout.header.console')
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
                                <h4 class="mb-sm-0">CRM - Conseilsassur</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                        <li class="breadcrumb-item active">Formulaire d'ajout d'opportunité</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    
                     <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Formulaire de proprection</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row gy-4">
                                            <div class="col-xxl-6 col-md-6">
                                                
                                                    <label for="basiInput" class="form-label">Canal</label>
                                                    <select class="form-select mb-3" aria-label="Default select example">
                                                        <option selected>Select your Status </option>
                                                        <option value="1">Declined Payment</option>
                                                        <option value="2">Delivery Error</option>
                                                        <option value="3">Wrong Amount</option>
                                                    </select>
                                                
                                            </div>
                                            <!--end col-->
                                             <div class="col-xxl-5 col-md-6 flex-shrink-0">
                                                <div class="form-check form-switch form-check-right">
                                                </div>
                                                <div class="form-check form-switch form-switch-lg" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="customSwitchsizelg" checked="">
                                                    <label class="form-check-label" for="customSwitchsizelg">Client ASAP</label>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="labelInput" class="form-label">Nom et prénom</label>
                                                    <input type="password" class="form-control" id="labelInput">
                                                </div>
                                            </div>
                                    
                                            <!--end col-->
                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="exampleInputdate" class="form-label"> Date Echeance</label>
                                                    <input type="date" class="form-control" id="exampleInputdate">
                                                </div>
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="basiInput" class="form-label">Lieu de propection</label>
                                                    <input type="password" class="form-control" id="basiInput">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="labelInput" class="form-label">Numéro de téléphone</label>
                                                    <input type="password" class="form-control" id="labelInput">
                                                </div>
                                            </div>

                                             <!--end col-->
                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="labelInput" class="form-label">Status</label>
                                                    <input type="password" class="form-control" id="labelInput">
                                                </div>
                                            </div>

                                             <!--end col-->
                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="labelInput" class="form-label">Carte grise</label>
                                                    <input type="file" class="form-control" id="labelInput">
                                                </div>
                                            </div>

                                             <!--end col-->
                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="labelInput" class="form-label">Attestation</label>
                                                    <input type="file" class="form-control" id="labelInput">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-12 col-md-6">
                                                <div>
                                                    <label for="exampleFormControlTextarea5" class="form-label">Observations</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-primary btn-label right ms-auto">Enregister</button>
                                            </div>
                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                   

                </div><!-- container-fluid -->
            </div> <!-- End Page-content -->


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
    </div>
    <!-- END layout-wrapper -->
<!-- End Content -->

 <!-- html2pdf for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <!-- App js -->
    <script src="assets/js/app.js"></script>

@endsection
<!-- section js -->
@section('extra-js')


@endsection



