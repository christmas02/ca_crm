<x-app-layout>
    <x-slot name="header">Modifier l'opportunité</x-slot>

    <div class="max-w-4xl">
        <div class="card">
            <div class="card-header">
                <h3>{{ $opportunity->title }}</h3>
                @if($opportunity->status)
                <span class="badge text-white" style="background-color: {{ $opportunity->status->color }}">{{ $opportunity->status->name }}</span>
                @endif
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('opportunities.update', $opportunity) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- Section: Prospect --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-primary-400 rounded-full"></div>
                            Informations du prospect
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="form-group">
                                <label for="nom" class="form-label">Nom *</label>
                                <input type="text" id="nom" name="nom" value="{{ old('nom', $opportunity->nom) }}" required class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="prenoms" class="form-label">Prénoms *</label>
                                <input type="text" id="prenoms" name="prenoms" value="{{ old('prenoms', $opportunity->prenoms) }}" required class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="telephone" class="form-label">Téléphone *</label>
                                <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $opportunity->telephone) }}" required class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="telephone2" class="form-label">Téléphone secondaire</label>
                                <input type="text" id="telephone2" name="telephone2" value="{{ old('telephone2', $opportunity->telephone2) }}" class="form-input">
                            </div>
                        </div>
                    </div>

                    {{-- Observation --}}
                    @if($opportunity->observation)
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-2 flex items-center gap-2">
                            <div class="w-1 h-4 bg-gray-400 rounded-full"></div>
                            Observation
                        </h4>
                        <p class="text-sm text-gray-600 bg-gray-50 rounded-lg p-4">{{ $opportunity->observation }}</p>
                        <textarea name="observation" rows="3" class="form-textarea rounded hidden">{{ old('observation', $opportunity->observation) }}</textarea>
                    </div>
                    @endif

                
                    {{-- Section: Véhicule & Assurance --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-blue-500 rounded-full"></div>
                            Véhicule & Assurance
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="plaque_immatriculation" class="form-label">Plaque d'immatriculation</label>
                                <input type="text" id="plaque_immatriculation" name="plaque_immatriculation" value="{{ old('plaque_immatriculation', $opportunity->plaque_immatriculation) }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="echeance" class="form-label">Date d'échéance assurance</label>
                                <input type="date" id="echeance" name="echeance" value="{{ old('echeance', $opportunity->echeance?->format('Y-m-d')) }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="lieuprospection" class="form-label">Lieu de prospection</label>
                                <input type="text" id="lieuprospection" name="lieuprospection" value="{{ old('lieuprospection', $opportunity->lieuprospection) }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="assureur_actuel" class="form-label">Assureur actuel</label>
                                <select id="assureur_actuel" name="assureur_actuel" class="form-input">
                                    <option value="">-- Sélectionner un assureur --</option>
                                    @foreach($insurancePartners as $partner)
                                    <option value="{{ $partner->name }}" {{ old('assureur_actuel', $opportunity->assureur_actuel) == $partner->name ? 'selected' : '' }}>
                                        {{ $partner->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Statuts  --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label class="form-label">Etat du discours</label>
                                <div class="flex gap-3">
                                    <button type="button" class="discourse-btn discourse-btn-ok flex-1 px-4 py-2 rounded-lg border-2 transition-all {{ old('statut_discours', $opportunity->statut_discours) == 'Validé' ? 'border-emerald-500 bg-emerald-50 text-emerald-700 font-semibold shadow-sm' : 'border-gray-300 bg-gray-100 text-gray-600 hover:border-gray-400' }}" onclick="selectDiscourseStatus(event, 'Validé')">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Discours OK
                                    </button>
                                    <button type="button" class="discourse-btn discourse-btn-nok flex-1 px-4 py-2 rounded-lg border-2 transition-all {{ old('statut_discours', $opportunity->statut_discours) == 'Rejeté' ? 'border-rose-500 bg-rose-50 text-rose-700 font-semibold shadow-sm' : 'border-gray-300 bg-gray-100 text-gray-600 hover:border-gray-400' }}" onclick="selectDiscourseStatus(event, 'Rejeté')">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m10-10a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Discours Non OK
                                    </button>
                                </div>
                                <input type="hidden" id="statut_discours" name="statut_discours" value="{{ old('statut_discours', $opportunity->statut_discours) }}">
                            </div>
                        </div>
                    </div>

                    {{-- Section: Documents  --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-purple-500 rounded-full"></div>
                            Documents 
                        </h4>
                         <div class="grid grid-cols-2 gap-3">
                            @if($opportunity->urlcarte_grise)
                            <button type="button" onclick="openDocumentModal('{{ asset('storage/' . $opportunity->urlcarte_grise) }}', 'Carte grise (back-office)')" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-primary-50 transition-colors group">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <div class="text-left"><p class="text-sm font-medium text-gray-700">Carte grise</p><p class="text-xs text-gray-400">Visualiser</p></div>
                            </button>
                            @endif
                            @if($opportunity->url_attestationassurance)
                            <button type="button" onclick="openDocumentModal('{{ asset('storage/' . $opportunity->url_attestationassurance) }}', 'Attestation (back-office)')" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-primary-50 transition-colors group">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <div class="text-left"><p class="text-sm font-medium text-gray-700">Attestation </p><p class="text-xs text-gray-400">Visualiser</p></div>
                            </button>
                            @endif
                        </div> 
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                
                                <label for="carte_grise" class="form-label">Carte grise </label>
                               
                                <p><small class="text-xs text-gray-400 mt-1">Mettre à jour la carte grise (max 5MB)</small></p>
                                <input type="file" id="carte_grise" name="urlcarte_grise" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                                <input type="hidden" name="existing_urlcarte_grise" value="{{ $opportunity->urlcarte_grise }}">
                            </div>
                            <div class="form-group">
                                <label for="attestation" class="form-label">Attestation </label>
                              
                                <p><small class="text-xs text-gray-400 mt-1">Mettre à jour l'attestation (max 5MB)</small></p>
                                <input type="file" id="attestation" name="url_attestationassurance" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                                <input type="hidden" name="existing_url_attestationassurance" value="{{ $opportunity->url_attestationassurance }}">
                            </div>
                        </div>
                    </div>

                     {{-- Date de relance et status --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-purple-500 rounded-full"></div>
                            Date de relance et statut 
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="daterelance" class="form-label">Date et heure de relance</label>
                                <input type="datetime-local" id="relance" name="relance" value="{{ old('relance', $opportunity->relance?->format('Y-m-d\TH:i')) }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="status_id" class="form-label">Statut de l'opportunité</label>
                                <select id="status_id" name="status_id" class="form-select" onchange="checkClientGagne(this)">
                                    <option value="">Sélectionner</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" data-slug="{{ $status->slug }}" {{ old('status_id', $opportunity->status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Client Gagné --}}
                    <div id="clientGagneSection" class="mb-6 pb-6 border-b border-gray-100" style="display: none;">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-green-500 rounded-full"></div>
                            Détails - Client Gagné
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="insurance_partner_id" class="form-label">Partenaire d'assurance</label>
                                <select id="insurance_partner_id" name="insurance_partner_id" class="form-input">
                                    <option value="">-- Sélectionner un partenaire --</option>
                                    @foreach($insurancePartners as $partner)
                                    <option value="{{ $partner->id }}" {{ old('insurance_partner_id', $opportunity->insurance_partner_id) == $partner->id ? 'selected' : '' }}>
                                        {{ $partner->name }} ({{ $partner->commission_rate }}%)
                                    </option>
                                    @endforeach
                                </select>
                                @error('insurance_partner_id')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="montant_nette_prime" class="form-label">Prime NET</label>
                                <input type="number" id="montant_nette_prime" name="montant_nette_prime" step="0.01" value="{{ old('montant_nette_prime', $opportunity->montant_nette_prime ?? '') }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="montant_ttc" class="form-label">Prime TTC</label>
                                <input type="number" id="montant_ttc" name="montant_ttc" step="0.01" value="{{ old('montant_ttc', $opportunity->montant_ttc ?? '') }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="montant_nette_prime" class="form-label">Période du contract</label>
                                <input type="number" id="montant_nette_prime" name="montant_nette_prime" step="0.01" value="{{ old('montant_nette_prime', $opportunity->montant_nette_prime ?? '') }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="atd_client" class="form-label">ATD client</label>
                                <input type="file" id="capture_paiement" name="capture_paiement" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-600 hover:file:bg-green-100">
                                <p><small class="text-xs text-gray-400 mt-1">Mettre à jour la capture du paiement (max 5MB)</small></p>
                            </div>
                            <div class="form-group">
                                <label for="contrat_assurance" class="form-label">Contrat d'assurance</label>
                                <input type="file" id="capture_paiement" name="capture_paiement" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-600 hover:file:bg-green-100">
                                <p><small class="text-xs text-gray-400 mt-1">Mettre à jour la capture du paiement (max 5MB)</small></p>
                            </div>
                    
                            <div class="form-group">
                                <label for="capture_paiement" class="form-label">Capture du paiement</label>
                                <input type="file" id="capture_paiement" name="capture_paiement" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-600 hover:file:bg-green-100">
                                <p><small class="text-xs text-gray-400 mt-1">Mettre à jour la capture du paiement (max 5MB)</small></p>
                            </div>
                         
                            <div class="form-group">
                                <label for="contrat" class="form-label">Attestation d'assurance</label>
                                <input type="file" id="contrat" name="contrat" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-600 hover:file:bg-green-100">
                                <p><small class="text-xs text-gray-400 mt-1">Mettre à jour le contrat (max 5MB)</small></p>
                            </div>
                        </div>
                    </div>

                    {{-- Comments --}}
                    <div class="card">
                        <div class="card-header">
                            <h3>Commentaires ({{ $opportunity->comments->count() }})</h3>
                        </div>
                        <div class="card-body space-y-4">
                            @forelse($opportunity->comments as $comment)
                            <div class="flex gap-3">
                                <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-semibold text-primary-600">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ $comment->body }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-400 text-center py-4">Aucun commentaire.</p>
                            @endforelse
                            <hr>
                                <div class="form-group">
                                    <label for="body" class="form-label">Ajouter un commentaire</label>
                                    <textarea id="body" name="body" rows="3" required placeholder="Ajouter un commentaire..." class="form-textarea"></textarea>
                                    @error('body')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                        </div>
                    </div>


            
                    {{-- Actions --}}
                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Enregistrer
                        </button>
                        <a href="{{ route('opportunities.show', $opportunity) }}" class="btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Document Modal --}}
    <div id="documentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-auto">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between">
                <h2 id="modalTitle" class="text-lg font-semibold text-gray-900">Document</h2>
                <button type="button" onclick="closeDocumentModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div id="modalContent" class="flex items-center justify-center">
                    <!-- Document content -->
                </div>
            </div>
            <div class="sticky bottom-0 bg-gray-50 border-t px-6 py-4 flex items-center justify-end gap-3">
                <button type="button" onclick="closeDocumentModal()" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                    Fermer
                </button>
                <a id="downloadBtn" href="#" target="_blank" class="px-4 py-2 bg-primary-600 text-white hover:bg-primary-700 rounded-lg">
                    📥 Télécharger
                </a>
            </div>
        </div>
    </div>

    <script>
        function openDocumentModal(url, title) {
            const modal = document.getElementById('documentModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const downloadBtn = document.getElementById('downloadBtn');
            
            modalTitle.textContent = title;
            downloadBtn.href = url;
            
            const ext = url.split('.').pop().toLowerCase();
            
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                modalContent.innerHTML = `<img src="${url}" alt="${title}" class="max-w-full max-h-[70vh] rounded-lg">`;
            } else if (ext === 'pdf') {
                modalContent.innerHTML = `
                    <iframe src="${url}" 
                            class="w-full h-[70vh] rounded-lg border border-gray-200"
                            allow="fullscreen">
                    </iframe>
                `;
            } else {
                modalContent.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-600 font-medium">Format de fichier non supporté en aperçu</p>
                        <p class="text-sm text-gray-500 mt-1">Cliquez sur "Télécharger" pour ouvrir le fichier</p>
                    </div>
                `;
            }
            
            modal.classList.remove('hidden');
        }
        
        function closeDocumentModal() {
            const modal = document.getElementById('documentModal');
            modal.classList.add('hidden');
        }
        
        // Fermer le modal en cliquant en dehors
        document.getElementById('documentModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDocumentModal();
            }
        });
        
        // Fermer le modal avec la touche Échap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDocumentModal();
            }
        });

        // Gérer l'affichage du bloc "Client Gagné"
        function checkClientGagne(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const slug = selectedOption.getAttribute('data-slug');
            const clientGagneSection = document.getElementById('clientGagneSection');
            
            if (slug === 'gagne') {
                clientGagneSection.style.display = 'block';
            } else {
                clientGagneSection.style.display = 'none';
            }
        }

        // Gérer la sélection du discours
        function selectDiscourseStatus(event, value) {
            event.preventDefault();
            document.getElementById('statut_discours').value = value;
            
            // Réinitialiser tous les boutons au style par défaut
            document.querySelectorAll('.discourse-btn').forEach(btn => {
                btn.classList.remove(
                    'border-emerald-500', 'bg-emerald-50', 'text-emerald-700', 'font-semibold', 'shadow-sm',
                    'border-rose-500', 'bg-rose-50', 'text-rose-700'
                );
                btn.classList.add('border-gray-300', 'bg-gray-100', 'text-gray-600');
            });
            
            // Appliquer le style actif au bouton cliqué
            const btn = event.target.closest('button');
            btn.classList.remove('border-gray-300', 'bg-gray-100', 'text-gray-600');
            
            if (value === 'Validé') {
                btn.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-700', 'font-semibold', 'shadow-sm');
            } else if (value === 'Rejeté') {
                btn.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-700', 'font-semibold', 'shadow-sm');
            }
        }

        // Vérifier au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status_id');
            if (statusSelect.value) {
                checkClientGagne(statusSelect);
            }

            // Initialiser les styles des boutons de discours
            const discourseValue = document.getElementById('statut_discours').value;
            if (discourseValue) {
                document.querySelectorAll('.discourse-btn').forEach(btn => {
                    if (discourseValue === 'Validé' && btn.classList.contains('discourse-btn-ok')) {
                        btn.classList.remove('border-gray-300', 'bg-gray-100', 'text-gray-600');
                        btn.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-700', 'font-semibold', 'shadow-sm');
                    } else if (discourseValue === 'Rejeté' && btn.classList.contains('discourse-btn-nok')) {
                        btn.classList.remove('border-gray-300', 'bg-gray-100', 'text-gray-600');
                        btn.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-700', 'font-semibold', 'shadow-sm');
                    }
                });
            }
        });
    </script>
</x-app-layout>
