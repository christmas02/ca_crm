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
                                        <li class="breadcrumb-item active">Traitement d'opportunité</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                     <div class="row">
                        <div class="col-lg-12">
                            <div class="card mt-n4 mx-n4 mb-n5">
                                <div class="bg-warning-subtle">
                                    <div class="card-body pb-4 mb-5">
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="row align-items-center">
                                                    <div class="col-md-auto">
                                                        <div class="avatar-md mb-md-0 mb-4">
                                                            <div class="avatar-title bg-white rounded-circle">
                                                                <img src="assets/images/companies/img-4.png" alt="" class="avatar-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-md">
                                                        <h4 class="fw-semibold" id="ticket-title">#VLZ135 - NOUVELLE OPPORTUNITÉ</h4>
                                                        <div class="hstack gap-3 flex-wrap">
                                                            <div class="vr"></div>
                                                            <div class="text-muted">Date de remontée : <span class="fw-medium " id="create-date">20 Dec, 2021</span></div>
                                                            <div class="vr"></div>
                                                            <div class="text-muted">Argent terrain : <span class="fw-medium" id="due-date">  Adbel Crime</span></div>
                                                            <div class="vr"></div>
                                                            <div class="badge rounded-pill bg-info fs-12" id="ticket-status">Nouvelle Opportunité</div>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div><!-- end card body -->
                                </div>
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-xxl-9">
                            <div class="card">
                                <div class="card-body p-4">
                                    <h6 class="fw-semibold text-uppercase mb-3">Identification du prospect</h6>
                                    <div>
                                        <div class="row gy-4">
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="nameInput" class="form-label">Nom et prenom du client</label>
                                                    <input type="text" class="form-control" id="nameInput" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                             <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="phone1Input" class="form-label">Telephone 1</label>
                                                    <input type="text" class="form-control" id="phone1Input" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                             <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="phone2Input" class="form-label">Telephone 2 </label>
                                                    <input type="text" class="form-control" id="phone2Input" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mt-4"></div>
                                    <h6 class="fw-semibold text-uppercase mb-3"> Identification du véhicule du prospect </h6>
                                    <div>
                                        <div class="row gy-4">
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="immatriculationInput" class="form-label">Immatriculation </label>
                                                    <input type="text" class="form-control" id="immatriculationInput" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                             <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="immatriculationInput" class="form-label"> </label>
                                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#carteGriseModal">
                                                        <i class="ri-gallery-line"></i> Afficher Carte Grise
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                             <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="immatriculationInput" class="form-label">Mettre à jour la carte grise </label>
                                                    <input type="file" class="form-control" id="immatriculationInput" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="mt-4"></div>
                                    <h6 class="fw-semibold text-uppercase mb-3"> Qualification de la fiche client </h6>
                                    <div>
                                        <div class="row gy-4">
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="immatriculationInput" class="form-label">Commantaire sur terrain </label>
                                                    <p><small class="text-muted">Ce champ est désactivé et ne peut être modifié que par les commerciaux sur le terrain via l'application mobile.</small></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="immatriculationInput" class="form-label">Date d’échéance </label>
                                                    <input type="date" class="form-control" id="immatriculationInput" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="immatriculationInput" class="form-label">Assureur actuel </label>
                                                    <input type="text" class="form-control" id="immatriculationInput" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                             <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="immatriculationInput" class="form-label"> Validation du discours commercial : : </label>
                                                    <button type="button" class="btn btn-danger" id="btnNon" onclick="handleDiscourseValidation(0)">
                                                        <i class="ri-close-line"></i> Non
                                                    </button>
                                                    <button type="button" class="btn btn-success" id="btnOui" onclick="handleDiscourseValidation(1)">
                                                        <i class="ri-check-line"></i> Oui
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-4 col-md-4">
                                                <div>
                                                    <label for="immatriculationInput" class="form-label">Date et heure de relance </label>
                                                    <input type="datetime-local" class="form-control" id="immatriculationInput" required>
                                                </div>
                                            </div>
                                             <!--end col-->
                                            <div class="col-xxl-4 col-md-4">
                                                <h6 class="fw-semibold">Status</h6>
                                                <select class="form-select mb-3" id="statusSelect" aria-label="Default select example" onchange="handleStatusChange()">
                                                    <optgroup label="Nouvelle opportunité"  style="background-color: blue; color: white;">
                                                        <option value="nouvelle">Opportunite remonté</option>
                                                        <option value="nouvelle">Nouvelle opportunité</option>
                                                    </optgroup>
                                                    <optgroup label="Reporté" style="background-color: orange; color: white;">
                                                        <option value="reporter">Ne décroche pas</option>
                                                        <option value="reporter"> En déplacement</option>
                                                        <option value="reporter"> Ligne indisponible</option>
                                                        <option value="reporter">véhicule au garage</option>
                                                    </optgroup>
                                                    <optgroup label="Perdus" style="background-color: red; color: white;">
                                                        <option value="perdus">Pas le propriétaire</option>
                                                        <option value="perdus"> Véhicule vendu</option>
                                                        <option value="perdus">Prix trop élevé</option>
                                                        <option value="perdus">Non joignable définitif</option>
                                                        <option value="perdus">A déjà un assureur</option>
                                                    </optgroup>
                                                    <optgroup label="Poursuivre" style="background-color: blue; color: white;">
                                                        <option value="poursuivre">Cotation envoyée</option>
                                                        <option value="poursuivre"> En attente de carte grise</option>
                                                        <option value="poursuivre">Relance ferme</option>
                                                        <option value="poursuivre">Véhicule au garage</option>
                                                    </optgroup>
                                                    <optgroup label="Client Gagner" style="background-color: green; color: white;">
                                                        <option value="gagner">Client gagné</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <!--end col-->

                                            <!-- Bloc caché pour Client Gagner -->
                                            <div id="blockClientGagne" style="display: none;" class="col-12">
                                                <div class="card mt-3">
                                                    <div class="card-header bg-success bg-opacity-10 border-success">
                                                        <h6 class="card-title fw-semibold mb-0 text-success">
                                                            <i class="ri-check-double-line"></i> Enregistrement Client Gagner
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row gy-4">
                                                            <div class="col-xxl-4 col-md-6">
                                                                <div>
                                                                    <label for="datePrime" class="form-label">Montant de la prime nette</label>
                                                                    <input type="number" class="form-control" id="datePrime" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-4 col-md-6">
                                                                <div>
                                                                    <label for="montantPrime" class="form-label">Montant de la prime TTC</label>
                                                                    <input type="number" class="form-control" id="montantPrime" placeholder="0.00" min="0" step="0.01" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-4 col-md-6">
                                                                <div>
                                                                    <label for="numPolice" class="form-label">Carte grise</label>
                                                                    <input type="file" class="form-control" id="numPolice" placeholder="Entrez le numero de police" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-4 col-md-6">
                                                                <div>
                                                                    <label for="assureur" class="form-label">ATD client</label>
                                                                    <input type="file" class="form-control" id="assureur" placeholder="Nom de l'assureur" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-4 col-md-6">
                                                                <div>
                                                                    <label for="commission" class="form-label">Cotract d'assurance</label>
                                                                    <input type="file" class="form-control" id="commission" placeholder="0" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-4 col-md-6">
                                                                <div>
                                                                    <label for="observations" class="form-label">Capture du paiement</label>
                                                                    <input type="file" class="form-control" id="observations" placeholder="Remarques importantes..." required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div action="javascript:void(0);" class="mt-3">
                                                <div class="row g-3">
                                                    <div class="col-lg-12">
                                                        <label for="exampleFormControlTextarea1" class="form-label">Leave a Comments</label>
                                                        <textarea class="form-control bg-light border-light" id="exampleFormControlTextarea1" rows="3" placeholder="Enter comments"></textarea>
                                                    </div>
                                                    <div class="col-lg-12 text-end">
                                                        <a href="javascript:void(0);" class="btn btn-success">Validee les modifications</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-body-->
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-4">Commeentaires</h5>

                                    <div data-simplebar style="height: 300px;" class="px-3 mx-n3">
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/users/avatar-8.jpg" alt="" class="avatar-xs rounded-circle" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-13">Joseph Parker <small class="text-muted">20 Dec 2021 - 05:47AM</small></h5>
                                                <p class="text-muted">I am getting message from customers that when they place order always get error message .</p>
                                                <a href="javascript: void(0);" class="badge text-muted bg-light"><i class="mdi mdi-reply"></i> Reply</a>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/users/avatar-6.jpg" alt="" class="avatar-xs rounded-circle" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-13">Donald Palmer <small class="text-muted">24 Dec 2021 - 05:20PM</small></h5>
                                                <p class="text-muted">If you have further questions, please contact Customer Support from the “Action Menu” on your <a href="javascript:void(0);" class="text-decoration-underline">Online Order Support</a>.</p>
                                                <a href="javascript: void(0);" class="badge text-muted bg-light"><i class="mdi mdi-reply"></i> Reply</a>
                                            </div>
                                        </div>
                                    
                                    </div>
                                   
                                </div>
                                <!-- end card body -->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Tickails</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless align-middle mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium">Assigned To:</td>
                                                    <td>
                                                        <div class="avatar-group">
                                                            <a href="javascript:void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Erica Kernan">
                                                                <img src="assets/images/users/avatar-4.jpg" alt="" class="rounded-circle avatar-xs" />
                                                            </a>
                                                            <a href="javascript:void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Alexis Clarke">
                                                                <img src="assets/images/users/avatar-10.jpg" alt="" class="rounded-circle avatar-xs" />
                                                            </a>
                                                            <a href="javascript:void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="James Price">
                                                                <img src="assets/images/users/avatar-3.jpg" alt="" class="rounded-circle avatar-xs" />
                                                            </a>
                                                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" data-bs-original-title="Add Members">
                                                                <div class="avatar-xs">
                                                                    <div class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                                        +
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                            
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                    
                    <!-- Modal Carte Grise -->
                    <div class="modal fade" id="carteGriseModal" tabindex="-1" aria-labelledby="carteGriseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="carteGriseModalLabel">Carte Grise Enregistrée</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="alert alert-info mb-3">
                                                <i class="ri-information-line"></i> Informations du véhicule
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label class="form-label fw-semibold">Immatriculation</label>
                                                    <p id="carteImmatriculation">-</p>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label fw-semibold">Marque</label>
                                                    <p id="carteMarque">-</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label class="form-label fw-semibold">Modèle</label>
                                                    <p id="carteModele">-</p>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label fw-semibold">Année</label>
                                                    <p id="carteAnnee">-</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Numéro de châssis</label>
                                                    <p id="carteNumeroChaissis">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                 
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

    <script>
        // Fonction pour gerer la validation du discours commercial
        const handleDiscourseValidation = (value) => {
            const btnNon = document.getElementById('btnNon');
            const btnOui = document.getElementById('btnOui');
            const result = value === 1 ? 'Oui' : 'Non';
            
            if (value === 0) {
                // Si Non est clique
                btnNon.disabled = false;
                btnNon.style.opacity = '1';
                btnNon.style.cursor = 'pointer';
                btnOui.disabled = true;
                btnOui.style.opacity = '0.5';
                btnOui.style.cursor = 'not-allowed';
            } else if (value === 1) {
                // Si Oui est clique
                btnOui.disabled = false;
                btnOui.style.opacity = '1';
                btnOui.style.cursor = 'pointer';
                btnNon.disabled = true;
                btnNon.style.opacity = '0.5';
                btnNon.style.cursor = 'not-allowed';
            }
            
            console.log('Validation du discours commercial:', result, '(Valeur:', value, ')');
            alert(`Discours commercial valide: ${result} (${value})`);
        };

        // Fonction pour gerer le changement de statut
        const handleStatusChange = () => {
            const statusSelect = document.getElementById('statusSelect');
            const blockClientGagne = document.getElementById('blockClientGagne');
            const selectedValue = statusSelect.value;
            
            // Afficher le bloc si "gagner" est selectionne
            if (selectedValue === 'gagner') {
                blockClientGagne.style.display = 'block';
            } else {
                blockClientGagne.style.display = 'none';
            }
        };
    </script>

    <script>
        // Fonction pour gérer la validation du discours commercial
        const handleDiscourseValidation = (value) => {
            const btnNon = document.getElementById('btnNon');
            const btnOui = document.getElementById('btnOui');
            const result = value === 1 ? 'Oui' : 'Non';
            
            if (value === 0) {
                // Si Non est cliqué
                btnNon.disabled = false;
                btnNon.style.opacity = '1';
                btnNon.style.cursor = 'pointer';
                btnOui.disabled = true;
                btnOui.style.opacity = '0.5';
                btnOui.style.cursor = 'not-allowed';
            } else if (value === 1) {
                // Si Oui est cliqué
                btnOui.disabled = false;
                btnOui.style.opacity = '1';
                btnOui.style.cursor = 'pointer';
                btnNon.disabled = true;
                btnNon.style.opacity = '0.5';
                btnNon.style.cursor = 'not-allowed';
            }
            
            console.log('Validation du discours commercial:', result, '(Valeur:', value, ')');
            alert(`Discours commercial validé: ${result} (${value})`);
            
            // Exemple d'appel API:
            // fetch('/api/discourse-validation', {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({ validation: value })
            // }).then(response => response.json())
            //   .then(data => console.log(data));
        };
    </script>

@endsection
<!-- section js -->
@section('extra-js')


@endsection



