 @extends('layouts.master')
    @section('headerCss')

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

    @stop 

    @section('content')
		<div class="main-content">

		            <div class="page-content">
		                <div class="container-fluid">

		                    <div class="position-relative mx-n4 mt-n4">
		                        <div class="profile-wid-bg profile-setting-img">
		                            <img src="assets/images/profile-bg.jpg" class="profile-wid-img" alt="">
		                            <div class="overlay-content">
		                                <div class="text-end p-3">
		                                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
		                                        <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
		                                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
		                                            <i class="ri-image-edit-line align-bottom me-1"></i> Changer Coverture
		                                        </label>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="row">
		                        <div class="col-xxl-3">
		                            <div class="card mt-n5">
		                                <div class="card-body p-4">
		                                    <div class="text-center">
		                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

		                                        	@if (Session::get('profileImg') !='' || Session::get('profileImg') != null)
		                                        		{{-- expr --}}

		                                        		 <img src="{{Session::get('profileImg')}}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
		                                        	@else

		                                        	<img src="/assets/images/users/avatar-0.png" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">

		                                        	@endif
		                                            


		                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit updateform">
		                                                <input id="profile-img-file-input" name="profile_picture" type="file" class="profile-img-file-input">
		                                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
		                                                    <span class="avatar-title rounded-circle bg-light text-body">
		                                                        <i class="ri-camera-fill"></i>
		                                                    </span>
		                                                </label>
		                                            </div>
		                                        </div>
		                                        <h5 class="fs-16 mb-1">{{Session::get('userfirstname') . ' '.Session::get('userlastname') }}</h5>
		                                        <p class="text-muted mb-0" style="color:black; font-weight: bold;">

		                                        	@if (Session::get('userprivilege') =='niveau1')
		                                        	  Privilège :  <span style="color: #3f5189;">Full</span>	
		                                        	@elseif(Session::get('userprivilege') =='niveau2')
		                                        	  Privilège : 	 <span style="color: #3f5189;">Intermédiare</span>	
		                                        	@else 
		                                        	  Privilège :  <span style="color: #3f5189;">Débutant</span>	
		                                        	@endif

		                                     </p>
		                                    </div>
		                                </div>
		                            </div>
		                            <!--end card-->
		                            
		                           
		                            <!--end card-->
		                        </div>
		                        <!--end col-->
		                        <div class="col-xxl-9">
		                            <div class="card mt-xxl-n5">
		                                <div class="card-header">
		                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
		                                        <li class="nav-item">
		                                            <a class="nav-link active" data-bs-toggle="tab" href="pages-profile-settings.html#personalDetails" role="tab">
		                                                <i class="fas fa-home"></i> Informations personnelles
		                                            </a>
		                                        </li>
		                                        <li class="nav-item">
		                                            <a class="nav-link" data-bs-toggle="tab" href="pages-profile-settings.html#changePassword" role="tab">
		                                                <i class="far fa-user"></i> Changer mot de password
		                                            </a>
		                                        </li>
		                                        
		                                    </ul>
		                                </div>
		                                <div class="card-body p-4">
		                                    <div class="tab-content">
		                                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
		                                            <form class="updateform" action="javascript:void(0);">
		                                                <div class="row">
		                                                    <div class="col-lg-6">
		                                                        <div class="mb-3">
		                                                            <label for="firstnameInput" class="form-label">Prenoms</label>
		                                                            <input type="text" class="form-control" id="firstnameInput" name="firstname" placeholder="Entrer votre prenom" value="{{Session::get('userfirstname')}}">
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->
		                                                    <div class="col-lg-6">
		                                                        <div class="mb-3">
		                                                            <label for="lastnameInput" class="form-label">Nom</label>
		                                                            <input type="text" class="form-control" id="lastnameInput" name="lastname" placeholder="Entrer votre nom" value="{{Session::get('userlastname')}}">
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->
		                                                    <div class="col-lg-6">
		                                                        <div class="mb-3">
		                                                            <label for="phonenumberInput" class="form-label">Télephone</label>
		                                                            <input type="text" class="form-control" id="phonenumberInput" name="phonenumber" placeholder="Entrer votre numero de telephone" value="{{Session::get('PhoneNumber')}}">
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->

		                                                    



		                                                    <div class="col-lg-6">
		                                                        <div class="mb-3">
		                                                            <label for="emailInput" class="form-label">Nom utilisateur / Login</label>
		                                                            <input type="text" class="form-control" id="emailInput" name="login" placeholder="Entrer votre login" value="{{Session::get('userlogin')}}">
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->
		                                                    
		                                                    <!--end col-->
		                                                    
		                                                    <!--end col-->
		                                                    
		                                                    <div class="col-lg-12">
		                                                        <div class="hstack gap-2 justify-content-end">
		                                                            <button id="updatebtn" type="submit" class="btn btn-primary">Mettre à jour </button>
		                                                            <button type="button" class="btn btn-soft-success">Annuler</button>
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->
		                                                </div>
		                                                <!--end row-->
		                                            </form>
		                                        </div>
		                                        <!--end tab-pane-->
		                                        <div class="tab-pane" id="changePassword" role="tabpanel">
		                                            <form action="javascript:void(0);">
		                                                <div class="row g-2">
		                                                	<p id="message" style="color: #ef0707;font-weight: 500;display: none;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p>
		                                                    <div class="col-lg-4">
		                                                        <div>
		                                                            <label for="oldpasswordInput" class="form-label ">Ancient mot de passe*</label>

		                                                            <div class="position-relative auth-pass-inputgroup mb-3">
			                                                            <input type="password" name="oldpasswordInput" class="form-control  requiredField password-input" id="oldpasswordInput" placeholder="Mot de passe actuel">
			                                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
		                                                       		</div>
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->
		                                                    <div class="col-lg-4">
		                                                        <div>
		                                                            <label for="newpasswordInput" class="form-label">Nouveau mot de passe *</label>
		                                                            <div class="position-relative auth-pass-inputgroup mb-3">

		                                                            <input type="password" name="newpasswordInput"  class="form-control requiredField password password-input" id="newpasswordInput" placeholder="Nouveau mot de passe">

		                                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>

		                                                       		 </div>
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->
		                                                    <div class="col-lg-4">
		                                                        <div>
		                                                            <label for="confirmpasswordInput" class="form-label">Confirmer Mot de passe*</label>
		                                                            <div class="position-relative auth-pass-inputgroup mb-3">
			                                                            <input type="password" name="confirmpasswordInput" class="form-control requiredField password password-input" id="confirmpasswordInput" placeholder="Confirmer mot de passe">
			                                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
		                                                        	</div>
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->
		                                                   
		                                                    <!--end col-->
		                                                    <div class="col-lg-12">
		                                                        <div class="text-end">
		                                                            <button id="submitnewpass" type="submit" class="btn btn-success">Modifier mon mot de passe</button>
		                                                        </div>
		                                                    </div>
		                                                    <!--end col-->
		                                                </div>
		                                                <!--end row-->
		                                            </form>
		                                            
		                                      
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                        <!--end col-->
		                    </div>
		                    <!--end row-->


		                     
		                </div>
		                <!-- container-fluid -->
		            </div><!-- End Page-content -->


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
                                                            <p class="text-muted mb-4"> Mise  à jour effectuée avec succès!</p>
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <a href="javascript:void(0);" class="btn btn-success  fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
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
		                            <script>document.write(new Date().getFullYear())</script> © Overtech.
		                        </div>
		                        <div class="col-sm-6">
		                            <div class="text-sm-end d-none d-sm-block">
		                                Design & Develop by Overtech
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </footer>
		</div>
	@endsection

  @section('footerCss')

	    <!-- JAVASCRIPT -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/js/plugins.js"></script>

    <!-- profile-setting init js -->
    <script src="/assets/js/pages/profile-setting.init.js"></script>
    <script src="/assets/js/pages/password-addon.init.js"></script>

    <!-- App js -->
    <script src="/assets/js/app.js"></script>

    <script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>

    <script type="text/javascript">



    
    $(document).ready(function () {




         $("#updatebtn").click(function(e) {
            console.log('bonjour');
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
                }else if ($(this).hasClass('password')){


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
                  url: '/updateprofile',
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
     });


    
       $("#submitnewpass").click(function(e) {

       		 e.preventDefault();

       		var hasError = false;
            var btnclicked = $(this);
            var uploadhaserror = false;
            var datasT = new FormData();
            var hasErrorupload = new Array();

            $('#changePassword').find('input, textarea, select').each(function() {
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
            $("#message").css('display','none');
            $('#changePassword .requiredField').each(function() {
                var i = $(this);
                i.siblings('.validate').html('');
                if (jQuery.trim($(this).val()) === '') {
                    hasError = true;
                    $(this).addClass('invalid');
                    $("#message").html('Renseignez les champs obligatoires');
                        $("#message").css('display','block');
                    i.siblings('.validate').html((hasError ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
                } else if ($(this).hasClass('password')) {

                    if($('#newpasswordInput').val() != $('#confirmpasswordInput').val()){

                    	hasError = true;
                        $(this).addClass('invalid');
                        $("#message").html('Les mots de passe ne sont identiques.');
                        $("#message").css('display','block');
                        // i.siblings('.validate').html((hasError ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
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
                  url: '/updatepassword',
                  beforeSend: function(){
                     btnclicked.removeClass('normalstate');
                    btnclicked.addClass('is-active');
                  },
                  success: function(response){
                    // var retourJson =JSON.parse(response);
                    //console.log(response.message);
                   if (response =='password updated') {
                     $('#successModal').modal('show');
                     $('.password').val('');
                   }
                   if(response == 'wrong password'){

                   	$("#message").html("L'ancien mot de passe est incorrect.");
                    $("#message").css('display','block');
                   }
                  }
                });
            }

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
      if(iSize > 2100000){
        hasErrorf = true;
      }
    }
    return hasErrorf;
  }
  
    	


    </script>

   @endsection