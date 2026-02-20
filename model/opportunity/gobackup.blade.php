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
                                        <li class="breadcrumb-item active">Liste des nouvelles Opportunités </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                              <!-- Bloc de Filtres -->
                                    <div class="card mb-3 border-info">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Filtres</h5>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="resetFiltersBtn">
                                                <i class="fas fa-redo"></i> Réinitialiser
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="filterImmatriculation" class="form-label">Immatriculation</label>
                                                    <input type="text" class="form-control" id="filterImmatriculation" placeholder="Rechercher par immatriculation">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="filterNom" class="form-label">Nom</label>
                                                    <input type="text" class="form-control" id="filterNom" placeholder="Rechercher par nom">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="filterTelephone" class="form-label">Téléphone</label>
                                                    <input type="text" class="form-control" id="filterTelephone" placeholder="Rechercher par téléphone">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="filterDateEcheanceStart" class="form-label">D-Échéance (De)</label>
                                                    <input type="date" class="form-control" id="filterDateEcheanceStart">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="filterDateEcheanceEnd" class="form-label">D-Échéance (À)</label>
                                                    <input type="date" class="form-control" id="filterDateEcheanceEnd">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="filterCanal" class="form-label">Canal</label>
                                                    <input type="text" class="form-control" id="filterCanal" placeholder="Rechercher par canal">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div>    
                    </div>
                       <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0 flex-grow-1">Liste des nouvelles Opportunités</h4>
                                    <div class="gap-2" style="display: flex; gap: 0.5rem;">
                                        <button type="button" class="btn btn-primary btn-sm" id="exportExcelBtn">
                                            <i class="fas fa-file-excel"></i> Exporter Excel
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm" id="exportPdfBtn">
                                            <i class="fas fa-file-pdf"></i> Exporter PDF
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <label for="paginateSelect" class="form-label mb-0">Éléments par page:</label>
                                        <select id="paginateSelect" class="form-select" style="width: 100px;">
                                            <option value="3">3</option>
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="15">15</option>
                                            <option value="25">25</option>
                                        </select>
                                    </div>

                                    
                                    <div id="opportunitiesTable">
                                        @if(count($opportunities) > 0)
                                        <div class="table-responsive">
                                            <table id="opportunitiesTableData" class="table table-striped table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Status</th>
                                                        <th>Nom Prénom</th>
                                                        <th>Téléphone</th>
                                                        <th>Immatriculation</th>
                                                        <th>D-Echéance</th>
                                                        <th>D-Remonté</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($opportunities as $opportunity)
                                                        <tr></tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @else
                                        <div class="alert alert-info" role="alert">
                                            Aucune opportunité trouvée.
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Pagination Controls -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span id="paginationInfo"></span>
                                        </div>
                                        <nav>
                                            <ul id="paginationControls" class="pagination mb-0">
                                            </ul>
                                        </nav>
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
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
        // Action handlers for dropdown menu
        const actionDetaille  = (opportunityId) => {
            window.location.href = `/edit_opportunite/${opportunityId}`;
        };

        const actionAffecter = (opportunityId) => {
            const opp = paginationModule.getOpportunityById(opportunityId);
            if (opp) {
                alert(`Voir les détails de "${opp.nom_prenom}" (ID: ${opportunityId})`);
                // TODO: Implémenter la logique pour afficher les détails
            }
        };

        const actionArchive = (opportunityId) => {
            const opp = paginationModule.getOpportunityById(opportunityId);
            if (opp) {
                if (confirm(`Êtes-vous sûr de vouloir archiver l\'opportunité "${opp.nom_prenom}" ?`)) {
                    alert(`L\'opportunité "${opp.nom_prenom}" a été archivée`);
                    // TODO: Implémenter la logique d'archivage
                }
            }
        };
    </script>

    <style>
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 1rem;
        }

        .dropdown-item i {
            min-width: 20px;
            text-align: center;
        }

        .dropdown-item span {
            flex: 1;
        }

        .btn-light:hover {
            background-color: #f0f0f0;
        }
    </style>

    <script>
        // Pagination and table management
        const paginationModule = (() => {
            let allOpportunities = [];
            let filteredOpportunities = [];
            let currentPage = 1;
            let itemsPerPage = 10;
            const totalOpportunities = {{ $totalOpportunities }};
            
            // Filter object
            let filters = {
                immatriculation: '',
                nom: '',
                telephone: '',
                dateEcheanceStart: '',
                dateEcheanceEnd: '',
                canal: ''
            };

            // Initialize with Blade data
            @foreach($opportunities as $opp)
                allOpportunities.push({
                    id: {{ $opp->id }},
                    immatriculation: '{{ $opp->immatriculation }}',
                    nom_prenom: '{{ $opp->nom_prenom }}',
                    date_echeance: '{{ $opp->date_echeance }}',
                    date_relance: '{{ $opp->date_relance }}',
                    telephone1: '{{ $opp->telephone1 }}',
                    telephone2: '{{ $opp->telephone2 }}',
                    date_affectation: '{{ $opp->date_affectation }}',
                    argent_charge: {{ $opp->argent_charge }},
                    statut: '{{ $opp->statut }}'
                });
            @endforeach
            
            filteredOpportunities = [...allOpportunities];

            const getOpportunityById = (id) => {
                return allOpportunities.find(opp => opp.id === id);
            };

            const applyFilters = () => {
                filteredOpportunities = allOpportunities.filter(opp => {
                    // Filtre immatriculation
                    if (filters.immatriculation && !opp.immatriculation.includes(filters.immatriculation)) {
                        return false;
                    }
                    
                    // Filtre nom
                    if (filters.nom && !opp.nom_prenom.toLowerCase().includes(filters.nom.toLowerCase())) {
                        return false;
                    }
                    
                    // Filtre téléphone
                    if (filters.telephone && !opp.telephone1.includes(filters.telephone) && !opp.telephone2.includes(filters.telephone)) {
                        return false;
                    }
                    
                    // Filtre date échéance
                    if (filters.dateEcheanceStart && opp.date_echeance < filters.dateEcheanceStart) {
                        return false;
                    }
                    if (filters.dateEcheanceEnd && opp.date_echeance > filters.dateEcheanceEnd) {
                        return false;
                    }
                    
                    return true;
                });
                
                currentPage = 1;
                renderTable();
            };

            const getTotalPages = () => Math.ceil(filteredOpportunities.length / itemsPerPage);

            const getPaginatedOpportunities = () => {
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                return filteredOpportunities.slice(startIndex, endIndex);
            };

            const renderTable = () => {
                const tableBody = document.querySelector('#opportunitiesTableData tbody');
                const paginatedOpportunities = getPaginatedOpportunities();
                
                tableBody.innerHTML = '';
                
                paginatedOpportunities.forEach(opp => {
                    const row = `
                        <tr class="bg-warning bg-opacity-100 text-white">
                            <td>Opportunité nouvelle</td>
                            <td>${opp.nom_prenom}</td>
                            <td>${opp.telephone1}</td>
                            <td>${opp.immatriculation}</td>
                            <td>${new Date(opp.date_echeance).toLocaleDateString('fr-FR')}</td>
                            <td>${new Date(opp.date_affectation).toLocaleString('fr-FR')}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                        <i class="ri-settings-2-line"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="actionAffecter(${opp.id})">
                                                <i class="fas fa-arrow-right text-info"></i>
                                                <span>Affecter</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="actionDetaille(${opp.id})">
                                                <i class="fas fa-eye text-primary"></i>
                                                <span>Détaillé</span>
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="actionArchive(${opp.id})">
                                                <i class="fas fa-archive text-secondary"></i>
                                                <span>Archive</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
                
                updatePaginationInfo();
                renderPaginationControls();
            };

            const updatePaginationInfo = () => {
                const startItem = (currentPage - 1) * itemsPerPage + 1;
                const endItem = Math.min(currentPage * itemsPerPage, filteredOpportunities.length);
                const info = `Affichage ${startItem} à ${endItem} sur ${filteredOpportunities.length} opportunités`;
                document.getElementById('paginationInfo').textContent = info;
            };

            const renderPaginationControls = () => {
                const paginationContainer = document.getElementById('paginationControls');
                paginationContainer.innerHTML = '';
                const totalPages = getTotalPages();

                // Previous button
                const prevBtn = document.createElement('li');
                prevBtn.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevBtn.innerHTML = `<a class="page-link" href="javascript:void(0);" onclick="paginationModule.goToPage(${currentPage - 1})">Précédent</a>`;
                paginationContainer.appendChild(prevBtn);

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('li');
                    pageBtn.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    pageBtn.innerHTML = `<a class="page-link" href="javascript:void(0);" onclick="paginationModule.goToPage(${i})">${i}</a>`;
                    paginationContainer.appendChild(pageBtn);
                }

                // Next button
                const nextBtn = document.createElement('li');
                nextBtn.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                nextBtn.innerHTML = `<a class="page-link" href="javascript:void(0);" onclick="paginationModule.goToPage(${currentPage + 1})">Suivant</a>`;
                paginationContainer.appendChild(nextBtn);
            };

            const goToPage = (page) => {
                const totalPages = getTotalPages();
                if (page >= 1 && page <= totalPages) {
                    currentPage = page;
                    renderTable();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            };

            const changeItemsPerPage = (newItemsPerPage) => {
                itemsPerPage = parseInt(newItemsPerPage);
                currentPage = 1;
                renderTable();
            };

            const exportToPdf = () => {
                const element = document.getElementById('opportunitiesTableData');
                const opt = {
                    margin: 10,
                    filename: 'opportunites_' + new Date().toISOString().slice(0, 10) + '.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { orientation: 'landscape', unit: 'mm', format: 'a4' }
                };
                html2pdf().set(opt).from(element).save();
            };

            const exportToExcel = () => {
                let csv = 'Immatriculation,Nom Prénom,D-Echéance,D-Relance,Téléphone 1,Téléphone 2,D-Affectation,Argent Chargé,Statut\n';
                
                // Add data rows
                allOpportunities.forEach(opp => {
                    const escapedName = `"${opp.nom_prenom.replace(/"/g, '""')}"`;
                    csv += `${opp.immatriculation},${escapedName},${opp.date_echeance},${opp.date_relance},"${opp.telephone1}","${opp.telephone2}",${opp.date_affectation},${opp.argent_charge},${opp.statut}\n`;
                });
                
                // Create blob and download
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                
                link.setAttribute('href', url);
                link.setAttribute('download', 'opportunites_' + new Date().toISOString().slice(0, 10) + '.csv');
                link.style.visibility = 'hidden';
                
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };

            const addOpportunity = (immatriculation, nom_prenom, date_echeance, date_relance, telephone1, telephone2, date_affectation, argent_charge, statut) => {
                if (immatriculation && nom_prenom && date_echeance && date_relance && telephone1 && date_affectation && argent_charge && statut) {
                    const newId = Math.max(...allUsers.map(u => u.id), 0) + 1;
                    allUsers.push({
                        id: newId,
                        immatriculation: immatriculation,
                        nom_prenom: nom_prenom,
                        date_echeance: date_echeance,
                        date_relance: date_relance,
                        telephone1: telephone1,
                        telephone2: telephone2 || '',
                        date_affectation: date_affectation,
                        argent_charge: parseInt(argent_charge),
                        statut: statut
                    });
                    currentPage = 1;
                    renderTable();
                    return true;
                }
                return false;
            };

            return {
                init: () => {
                    renderTable();
                    
                    // Pagination select
                    document.getElementById('paginateSelect').addEventListener('change', (e) => {
                        changeItemsPerPage(e.target.value);
                    });
                    
                    // Filter listeners
                    document.getElementById('filterImmatriculation').addEventListener('input', (e) => {
                        filters.immatriculation = e.target.value;
                        applyFilters();
                    });
                    
                    document.getElementById('filterNom').addEventListener('input', (e) => {
                        filters.nom = e.target.value;
                        applyFilters();
                    });
                    
                    document.getElementById('filterTelephone').addEventListener('input', (e) => {
                        filters.telephone = e.target.value;
                        applyFilters();
                    });
                    
                    document.getElementById('filterDateEcheanceStart').addEventListener('change', (e) => {
                        filters.dateEcheanceStart = e.target.value;
                        applyFilters();
                    });
                    
                    document.getElementById('filterDateEcheanceEnd').addEventListener('change', (e) => {
                        filters.dateEcheanceEnd = e.target.value;
                        applyFilters();
                    });
                    
                    document.getElementById('filterCanal').addEventListener('input', (e) => {
                        filters.canal = e.target.value;
                        applyFilters();
                    });
                    
                    // Reset filters button
                    document.getElementById('resetFiltersBtn').addEventListener('click', () => {
                        filters = {
                            immatriculation: '',
                            nom: '',
                            telephone: '',
                            dateEcheanceStart: '',
                            dateEcheanceEnd: '',
                            canal: ''
                        };
                        
                        // Reset form inputs
                        document.getElementById('filterImmatriculation').value = '';
                        document.getElementById('filterNom').value = '';
                        document.getElementById('filterTelephone').value = '';
                        document.getElementById('filterDateEcheanceStart').value = '';
                        document.getElementById('filterDateEcheanceEnd').value = '';
                        document.getElementById('filterCanal').value = '';
                        
                        applyFilters();
                    });
                    
                    // Add User button
                    document.getElementById('addOpportunityBtn').addEventListener('click', () => {
                        const addOpportunityModal = new bootstrap.Modal(document.getElementById('addOpportunityModal'));
                        addOpportunityModal.show();
                    });
                    
                    // Save User button
                    document.getElementById('saveUserBtn').addEventListener('click', () => {
                        const immatriculation = document.getElementById('oppImmatriculation').value;
                        const nom_prenom = document.getElementById('oppNomPrenom').value;
                        const date_echeance = document.getElementById('oppDateEcheance').value;
                        const date_relance = document.getElementById('oppDateRelance').value;
                        const telephone1 = document.getElementById('oppTelephone1').value;
                        const telephone2 = document.getElementById('oppTelephone2').value;
                        const date_affectation = document.getElementById('oppDateAffectation').value;
                        const argent_charge = document.getElementById('oppArgentCharge').value;
                        const statut = document.getElementById('oppStatut').value;
                        
                        if (immatriculation && nom_prenom && date_echeance && date_relance && telephone1 && date_affectation && argent_charge && statut) {
                            if (paginationModule.addOpportunity(immatriculation, nom_prenom, date_echeance, date_relance, telephone1, telephone2, date_affectation, argent_charge, statut)) {
                                // Reset form
                                document.getElementById('addOpportunityForm').reset();
                                
                                // Close modal
                                const addOpportunityModal = bootstrap.Modal.getInstance(document.getElementById('addOpportunityModal'));
                                addOpportunityModal.hide();
                                
                                // Show success message
                                alert('Opportunité ajoutée avec succès!');
                            }
                        } else {
                            alert('Veuillez remplir tous les champs obligatoires!');
                        }
                    });
                    
                    // Export Excel button
                    document.getElementById('exportExcelBtn').addEventListener('click', exportToExcel);
                    
                    // Export PDF button
                    document.getElementById('exportPdfBtn').addEventListener('click', exportToPdf);
                },
                goToPage,
                changeItemsPerPage,
                exportToPdf,
                exportToExcel,
                addOpportunity,
                getOpportunityById
            };
        })();

        // Initialize pagination on page load
        document.addEventListener('DOMContentLoaded', () => {
            paginationModule.init();
        });
    </script>
@endsection
<!-- section js -->
@section('extra-js')


@endsection



