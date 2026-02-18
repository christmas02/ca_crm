<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Se connecter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
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
        .invalid{
          border:  2px solid #ec2626;  
        }
    </style>

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="#" class="d-inline-block auth-logo">
                                    <img src="/assets/images/logo-light.png" alt="" height="20">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Backoffice Assurance</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Bienvenue !</h5>
                                    <p class="text-muted">Se connecter pour continuer</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form id="loginuserform" action="" enctype="multipart/form-data" >

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Login</label>
                                            <input type="text" name="adminusername" class="form-control requiredField" id="username" placeholder="Entrer votre login">
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="#" class="text-muted">Mot de passe oublié?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Mot de passe </label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" name="adminpwd" class="form-control pe-5 password-input requiredField" placeholder="Entrer votre mot de passe" id="password-input">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                        </div>

                                        <div class="mt-4">
                                            <button id="loginBtn" class="btn btn-success w-100" type="submit">Se connecter</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                       {{--  <div class="mt-4 text-center">
                            <p class="mb-0">Don't have an account ? <a href="auth-signup-basic.html" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
                        </div> --}}

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="/assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="/assets/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="/assets/js/pages/password-addon.init.js"></script>


      <script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>

    <script>
    $(document).ready(function () {


        

        

         $("#loginBtn").click(function(e) {
            console.log('bonjour');
            e.preventDefault();
            var hasError = false;
            var btnclicked = $(this);
            var uploadhaserror = false;
            var datasT = new FormData();
            var hasErrorupload = new Array();

            $('#loginuserform').find('input, textarea, select').each(function() {
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
            $('#loginuserform .requiredField').each(function() {
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
                  url: '/loginadmin',
                  beforeSend: function(){
                     btnclicked.removeClass('normalstate');
                    btnclicked.addClass('is-active');
                  },
                  success: function(response){
                   if (response =='inserted') {
                    // var button = btnclicked;
                    $('.alert-success').css('display','block');
                    $("input[type=text], textarea").val("")
                   }
                  }
                });
            }
         })
     });
     </script>   
</body>

</html>