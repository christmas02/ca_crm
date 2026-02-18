 @extends('layouts.master') @section('headerCss')
 <!-- Layout config Js -->
 <script src="/assets/js/layout.js"></script>
 <!-- Bootstrap Css -->
 <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
 <!-- Icons Css -->
 <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
 <!-- App Css-->
 <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
 <!-- custom Css-->
 <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" /> @stop @section('content')
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
             <h4 class="mb-sm-0">PROSPECTION</h4>
             <div class="page-title-right">
               <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item">
                   <a href="javascript: void(0);">Formulaire</a>
                 </li>
                 <li class="breadcrumb-item active">Enregistrements</li>
               </ol>
             </div>
           </div>
         </div>
       </div>
       <!-- end page title -->
       <div class="row">
         <div class="col-xxl-6" style="margin:auto">
           <div class="card">
             <div class="card-header align-items-center d-flex">
               <h4 class="card-title mb-0 flex-grow-1">Note prospection</h4>
               <div class="flex-shrink-0">
                 <!-- <div class="form-check form-switch form-switch-right form-switch-md"><label for="form-grid-showcode" class="form-label text-muted">Show Code</label><input class="form-check-input code-switcher" type="checkbox" id="form-grid-showcode"></div> -->
               </div>
             </div>
             <!-- end card header -->
             <div class="card-body">
               <p class="text-muted">Ce formulaire pour les modifications de enregistrement des prospections </p>
               <div class="live-preview">
                 <form id="createNote" action="javascript:void(0);">
                   <div class="row">
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="firstNameinput" class="form-label">Nom client</label>
                         <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="nomclient" value="{{$findOpportunity['nom']}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="firstNameinput" class="form-label">Prénoms client</label>
                         <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="prenomclient" value="{{$findOpportunity['prenoms']}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="firstNameinput" class="form-label">Téléphone</label>
                         <input type="text" class="form-control" placeholder="Entrer votre nom" id="firstNameinput" name="telclient" value="{{$findOpportunity['telephone']}}" disabled>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="exampleInputdate" class="form-label"> Echéance</label>
                         <input type="date" name="dateecheance" class="form-control" id="exampleInputdate">
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="exampleInputdate" class="form-label"> Date relance</label>
                         <input type="date" name="daterelance" class="form-control" id="exampleInputdate">
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="exampleInputtime" class="form-label">Heure relance</label>
                         <input type="time" name="heurerelance" class="form-control" id="exampleInputtime">
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="firstNameinput" class="form-label">Assureur Actuel</label>
                         <input type="text" class="form-control" placeholder="assureur" id="firstNameinput" name="assureur">
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="firstNameinput" class="form-label">Période souscription (Mois) </label>
                         <input type="text" class="form-control" placeholder="1 mois" id="firstNameinput" name="periodesousc">
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="firstNameinput" class="form-label">Prime Net</label>
                         <input type="text" class="form-control" placeholder="Montant" id="firstNameinput" name="primenet">
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="firstNameinput" class="form-label">Prime TTC</label>
                         <input type="text" class="form-control" placeholder="Montant" id="firstNameinput" name="primettc">
                       </div>
                     </div>
                     {{-- <div class="col-md-6">
																					<div>
																						<label for="exampleFormControlTextarea5" class="form-label">Retour Client </label>
																						<textarea class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
																					</div>
																				</div> --}}
                     <!--end col-->
                     <!--end col-->
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="ForminputState" class="form-label">interet du client</label>
                         <select name="interetclient" id="ForminputState" class="form-select" data-choices data-choices-sorting="true">
                           <option selected>Choisir...</option>
                           <option value="interesse">interessé</option>
                           <option value="indecis">indécis</option>
                           <option value="pasinteresse">Pas intéressé</option>
                         </select>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="mb-3">
                         <label for="ForminputState" class="form-label">Resultat</label>
                         <select name="resultatentretien" id="ForminputState" class="form-select" data-choices data-choices-sorting="true">
                           <option selected>Choisir...</option>
                           <option value="gagne">Gagné</option>
                           <option value="poursuivre">Poursuivre</option>
                           <option value="reporte">Reporté</option>
                           <option value="perdu">Perdu</option>
                           <option value="horscible">Hors cible</option>
                         </select>
                       </div>
                     </div>
                     <div class="col-md-12">
                       <p style="text-align: center;font-weight: bold;color: black;"> interressé par </p>
                     </div>
                     <div class="col-md-3">
                       <div class="form-check form-check-primary mb-3">
                         <input class="form-check-input" name="flotteauto" type="checkbox" id="formCheck13" value="0">
                         <label class="form-check-label" for="formCheck13"> Flotte Auto </label>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-check form-check-secondary mb-3">
                         <input class="form-check-input" name="habitation" type="checkbox" id="formCheck14" value="0">
                         <label class="form-check-label" for="formCheck14"> Habitation </label>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-check form-check-secondary mb-3">
                         <input class="form-check-input" name="sante" type="checkbox" id="formCheck14" value="0">
                         <label class="form-check-label" for="formCheck14"> Santé </label>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-check form-check-success mb-3">
                         <input class="form-check-input" name="voyage" type="checkbox" id="formCheck15" value="0">
                         <label class="form-check-label" for="formCheck15"> Voyage </label>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="form-check form-check-warning mb-3">
                         <input class="form-check-input" name="autre" type="checkbox" id="formCheck16" value="0">
                         <label class="form-check-label" for="formCheck16"> Autre </label>
                       </div>
                     </div>
                     <div class="col-md-12"></div>
                     <div class="col-md-6">
                       <div>
                         <label for="exampleFormControlTextarea5" class="form-label">Observation</label>
                         <textarea name="observation" class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                       </div>
                     </div>
                     <div class="col-md-6">
                       <div class="text-end">
                         <label style="display:block;" for="exampleFormControlTextarea5" class="form-label"> &nbsp;</label>
                         <button style="height: 70px;width: 200px;" class="btn btn-success" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">Details</button>
                       </div>
                     </div>
                     <div class="col-md-12" style="margin-top: 20px">
                       <div class="text-center">
                         <button type="submit" style="width: 98%; height: 50px;" id="savenote" class="btn btn-primary">Enregistrer la note</button>
                       </div>
                     </div>
                     <!--end col-->
                     <div style="margin-bottom:10px"></div>
                     <input type="hidden" name="idopp" value="{{$findOpportunity['id']}}">
                     <!--end col-->
                     {{-- <div class="col-lg-12">
																											<div class="text-end">
																												<button type="submit" id="savenote" class="btn btn-primary">Enregistrer la note</button>
																											</div>
																										</div> --}}
                     <!--end col-->
                   </div>
                   <!--end row-->
                 </form>
               </div>
               <div class="d-none code-view"></div>
             </div>
           </div>
         </div>
         <!--  Large modal example -->
         <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="myLargeModalLabel">informations de Base</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                 <div class="row">
                   <div class="col-lg-12">
                     <div class="card">
                       <div class="card-body">
                         <div class="live-preview">
                           <div class="row gy-4">
                             <div class=" col-md-6">
                               <div>
                                 <label for="basiInput" class="form-label">Nom</label>
                                 <input type="text" class="form-control" id="basiInput" value="{{$listeoppeff['nom']}}" disabled>
                               </div>
                             </div>
                             <!--end col-->
                             <div class=" col-md-6">
                               <div>
                                 <label for="labelInput" class="form-label">Prénoms</label>
                                 <input type="text" class="form-control" id="labelInput" value="{{$listeoppeff['prenoms']}}" disabled>
                               </div>
                             </div>
                             <!--end col-->
                             <div class=" col-md-6">
                               <div>
                                 <label for="exampleInputdate" class="form-label"> Echéance</label>
                                 <input type="date" class="form-control" id="exampleInputdate" value="{{\Carbon\Carbon::parse($listeoppeff['echeance'])->format('Y-m-d')}}" disabled>
                               </div>
                             </div>
                             <!--end col-->
                             <div class=" col-md-6">
                               <label for="firstNameinput" class="form-label">Téléphone</label>
                               <input type="text" class="form-control" placeholder="Entrer votre telephone" id="firstNameinput" value="{{$listeoppeff['telephone']}}" disabled>
                             </div>
                             <!--end col-->
                             <div class=" col-md-6">
                               <div>
                                 <label for="readonlyInput" class="form-label">Lieu Prospection</label>
                                 <input type="text" class="form-control" id="readonlyInput" value="{{$listeoppeff['lieuprospection']}}" disabled>
                               </div>
                             </div>
                             <!--end col-->
                             <div class=" col-md-6">
                               <div>
                                 <label for="exampleFormControlTextarea5" class="form-label">Observation</label>
                                 <textarea class="form-control" id="exampleFormControlTextarea5" rows="3" disabled>{{$listeoppeff['observation']}}</textarea>
                               </div>
                             </div>
                             <!--end col-->
                           </div>
                           <!--end row-->
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-xxl-6">
                     <div class="card card-height-100 ">
                       <div class="card-header">
                         <h5 class="card-title mb-0">Attestation assurance</h5>
                       </div>
                       <div class="card-body">
                         <div class="mx-auto mb-3" style="max-width: 350px"> @if ($listeoppeff['url_attestationassurance']!='') {{-- expr --}}
                           <img src="{{$listeoppeff['url_attestationassurance']}}" style="width: 350px;height: 200px; margin: 0 auto;display: block;" alt=""> @else <img src="/assets/images/No-Image-Placeholder.png" style="width: 350px;height: 200px; margin: 0 auto;display: block;" alt=""> @endif
                           <!-- end card div elem -->
                         </div>
                         <div>
                           <div>
                             <input name="Imgattesation" class="form-control" type="file">
                           </div>
                         </div>
                         <!-- end card form elem -->
                       </div>
                     </div>
                     <!-- end card -->
                   </div>
                   <!-- end col -->
                   <div class="col-xl-6">
                     <div class="card">
                       <div class="card-header">
                         <h5 class="card-title mb-0">Carte Grise</h5>
                       </div>
                       <div class="card-body">
                         <div class="card-wrapper mb-3"> @if ($listeoppeff['urlcarte_grise']!='') {{-- expr --}}
                           <img src="{{$listeoppeff['urlcarte_grise']}}" style="width: 350px;height: 200px; margin: 0 auto;display: block;" alt=""> @else <img src="/assets/images/No-Image-Placeholder.png" style="width: 350px;height: 200px; margin: 0 auto;display: block;" alt=""> @endif
                         </div>
                         <div>
                           <div>
                             <input name="Imgcartegrise" class="form-control" type="file">
                           </div>
                         </div>
                       </div>
                       <!-- end card-body -->
                     </div>
                     <!-- end card -->
                   </div>
                   <!-- end col -->
                 </div>
                 <div class="row">
                   <div class="col-xl-12">
                     <div class="card">
                       <div class="card-header align-items-center d-flex">
                         <h4 class="card-title mb-0 flex-grow-1">Actions effectuées</h4>
                       </div>
                       <!-- end card header -->
                       <div class="card-body">
                         <p class="text-muted">Resumé les operations effectuées sur cette opportunité</p>
                         <div class="live-preview">
                           <div class="table-responsive">
                             <table class="table table-striped table-nowrap align-middle mb-0">
                               <thead>
                                 <tr>
                                   <th scope="col">Ligne</th>
                                   <th scope="col">Operateur</th>
                                   <th scope="col">Date</th>
                                   <th scope="col">Commentaire</th>
                                   <th scope="col">interet</th>
                                   <th scope="col">Echeance</th>
                                   <th scope="col">Date Relance</th>
                                   <th scope="col">Heure Relance</th>
                                   <th scope="col">Action</th>
                                 </tr>
                               </thead>
                               <tbody> @foreach ($listeoppeff['commentaires'] as $commmentaire) {{-- expr --}}
                                 <tr>
                                   <td class="fw-medium">{{$commmentaire['id']}}</td>
                                   <td>{{$commmentaire['agent_backoffice']['firstname']. ' '.$commmentaire['agent_backoffice']['lastname']}}</td>
                                   <td>{{\Carbon\Carbon::parse($commmentaire['created_at'])->format('d-m-Y')}}</td>
                                   <td>{{$commmentaire['observation']}}</td>
                                   <td> @if ($commmentaire['interetclient'] =='interesse' ) {{-- expr --}}
                                     <span class="badge bg-success">{{$commmentaire['interetclient']}}</span> @endif @if ($commmentaire['interetclient'] =='indecis' ) <span class="badge bg-warning">{{$commmentaire['interetclient']}}</span> @endif @if ($commmentaire['interetclient'] =='pasinteresse' ) <span class="badge bg-danger">{{$commmentaire['interetclient']}}</span> @endif
                                   </td>
                                   <td>{{\Carbon\Carbon::parse($commmentaire['echeance'])->format('d-m-Y')}}</td>
                                   <td>{{\Carbon\Carbon::parse($commmentaire['daterelance'])->format('d-m-Y')}}</td>
                                   <td>{{\Carbon\Carbon::parse($commmentaire['heure_relance'])->format('H:i:s')}}</td>
                                   <td>
                                     <button id="save_createuserform" class="btn btn-primary" style="margin-right: 40px;" type="button">{{$commmentaire['resultat']}}</button>
                                   </td>
                                 </tr> @endforeach
                               </tbody>
                             </table>
                           </div>
                         </div>
                       </div>
                     </div>
                     <div class="modal-footer">
                       <a href="javascript:void(0);" class="btn btn-success fw-medium" data-bs-dismiss="modal">
                         <i class="ri-close-line me-1 align-middle"></i> Fermer </a>
                       <button type="button" class="btn btn-primary ">Enregister les modifications</button>
                     </div>
                   </div>
                   <!-- /.modal-content -->
                 </div>
                 <!-- /.modal-dialog -->
               </div>
               <!-- /.modal -->
               <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                   <div class="modal-content">
                     <div class="modal-body text-center p-5">
                       <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                       <div class="mt-4">
                         <h4 class="mb-3">Opération réussie!</h4>
                         <p class="text-muted mb-4"> Commentaire enregistré avec succès </p>
                         <div class="hstack gap-2 justify-content-center">
                           <a href="javascript:void(0);" class="btn btn-success  fw-medium" data-bs-dismiss="modal">
                             <i class="ri-close-line me-1 align-middle"></i> Fermer </a>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
               </div> @endsection @section('footerCss')
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
                 .form-control {
                   border: 1px solid #5b5b5b !important;
                 }

                 .requiredfield {
                   border: 1px solid #ec2626 !important;
                 }
               </style>
               <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
               <script>
                 $(document).ready(function() {
                   $('#successModal').modal('show');
                   $("#savenote").click(function(e) {
                     e.preventDefault();
                     var hasError = false;
                     var btnclicked = $(this);
                     var uploadhaserror = false;
                     var datasT = new FormData();
                     var hasErrorupload = new Array();
                     $('#createNote').find('input, textarea, select').each(function() {
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
                       } else if ($(this).is(':checkbox')) {
                         if ($(this).is(':checked')) {
                           $(this).val(1);
                           datasT.append(this.name, $(this).val());
                         } else $(this).val(0);
                       } else {
                         datasT.append(this.name, $(this).val());
                       }
                     });
                     $('.requiredField').addClass('fieldtrue');
                     $('#createNote .requiredField').each(function() {
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
                         url: '/registernote',
                         beforeSend: function() {
                           btnclicked.removeClass('normalstate');
                           btnclicked.addClass('is-active');
                         },
                         success: function(response) {
                           if (response == 'inserted') {
                             // var button = btnclicked;
                             // $('.alert-success').css('display','block');
                             $('#successModal').modal('show');
                             $("input[type=text], textarea, input[type=date], input[type=time] ").val("")
                           }
                         }
                       });
                     }
                   })
                 });
               </script> @endsection