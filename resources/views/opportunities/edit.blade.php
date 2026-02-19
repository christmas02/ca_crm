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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        </div>
                    </div>

                    {{-- Section: Opportunité --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-accent-500 rounded-full"></div>
                            Détails de l'opportunité
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group md:col-span-2">
                                <label for="title" class="form-label">Titre *</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $opportunity->title) }}" required class="form-input">
                            </div>
                            <div class="form-group md:col-span-2">
                                <label for="observation" class="form-label">Observation</label>
                                <textarea id="observation" name="observation" rows="3" class="form-textarea">{{ old('observation', $opportunity->observation) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="canal" class="form-label">Canal</label>
                                <select id="canal" name="canal" class="form-select">
                                    <option value="">Sélectionner</option>
                                    @foreach(['Appel téléphonique', 'Email direct', 'Porte-à-porte', 'Salon auto', 'Web', 'Recommandation'] as $c)
                                        <option value="{{ $c }}" {{ old('canal', $opportunity->canal) == $c ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="source" class="form-label">Source</label>
                                <select id="source" name="source" class="form-select">
                                    <option value="">Sélectionner</option>
                                    @foreach(['Téléphone', 'Email', 'Site web', 'Recommandation', 'Salon', 'Porte-à-porte'] as $src)
                                        <option value="{{ $src }}" {{ old('source', $opportunity->source) == $src ? 'selected' : '' }}>{{ $src }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="telephone2" class="form-label">Téléphone secondaire</label>
                                <input type="text" id="telephone2" name="telephone2" value="{{ old('telephone2', $opportunity->telephone2) }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="isasap" class="form-label">ASAP</label>
                                <select id="isasap" name="isasap" class="form-select">
                                    <option value="">Sélectionner</option>
                                    <option value="oui" {{ old('isasap', $opportunity->isasap) == 'oui' ? 'selected' : '' }}>Oui</option>
                                    <option value="non" {{ old('isasap', $opportunity->isasap) == 'non' ? 'selected' : '' }}>Non</option>
                                </select>
                            </div>
                        </div>
                    </div>

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
                                <input type="text" id="assureur_actuel" name="assureur_actuel" value="{{ old('assureur_actuel', $opportunity->assureur_actuel) }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="periode_souscription" class="form-label">Période de souscription (mois)</label>
                                <input type="number" id="periode_souscription" name="periode_souscription" value="{{ old('periode_souscription', $opportunity->periode_souscription) }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="montant_souscription" class="form-label">Montant (FCFA)</label>
                                <input type="number" id="montant_souscription" name="montant_souscription" value="{{ old('montant_souscription', $opportunity->montant_souscription) }}" class="form-input">
                            </div>
                        </div>
                    </div>

                    {{-- Section: Statuts documents --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-yellow-500 rounded-full"></div>
                            Statuts documents
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label for="statut_discours" class="form-label">Statut discours</label>
                                <select id="statut_discours" name="statut_discours" class="form-select">
                                    <option value="">Sélectionner</option>
                                    @foreach(['Validé', 'En attente', 'Rejeté'] as $sd)
                                        <option value="{{ $sd }}" {{ old('statut_discours', $opportunity->statut_discours) == $sd ? 'selected' : '' }}>{{ $sd }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="statut_carte_grise" class="form-label">Statut carte grise</label>
                                <select id="statut_carte_grise" name="statut_carte_grise" class="form-select">
                                    <option value="">Sélectionner</option>
                                    @foreach(['Reçu', 'Manquant', 'En attente'] as $sc)
                                        <option value="{{ $sc }}" {{ old('statut_carte_grise', $opportunity->statut_carte_grise) == $sc ? 'selected' : '' }}>{{ $sc }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="statut_attestation" class="form-label">Statut attestation</label>
                                <select id="statut_attestation" name="statut_attestation" class="form-select">
                                    <option value="">Sélectionner</option>
                                    @foreach(['Reçu', 'Manquant', 'En attente'] as $sa)
                                        <option value="{{ $sa }}" {{ old('statut_attestation', $opportunity->statut_attestation) == $sa ? 'selected' : '' }}>{{ $sa }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Documents terrain --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-purple-500 rounded-full"></div>
                            Documents terrain
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="urlcarte_grise_terrain" class="form-label">Carte grise (terrain)</label>
                                @if($opportunity->urlcarte_grise_terrain)
                                    <p class="text-xs text-accent-600 mt-1 mb-2"><a href="{{ asset('storage/' . $opportunity->urlcarte_grise_terrain) }}" target="_blank" class="hover:underline">Fichier existant</a></p>
                                @endif
                                <input type="file" id="urlcarte_grise_terrain" name="urlcarte_grise_terrain" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                            </div>
                            <div class="form-group">
                                <label for="url_attestationassurance_terrain" class="form-label">Attestation (terrain)</label>
                                @if($opportunity->url_attestationassurance_terrain)
                                    <p class="text-xs text-accent-600 mt-1 mb-2"><a href="{{ asset('storage/' . $opportunity->url_attestationassurance_terrain) }}" target="_blank" class="hover:underline">Fichier existant</a></p>
                                @endif
                                <input type="file" id="url_attestationassurance_terrain" name="url_attestationassurance_terrain" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                            </div>
                        </div>
                    </div>

                    {{-- Section: Documents back-office --}}
                    @if(auth()->user()->isAdmin() || auth()->user()->isLead() || auth()->user()->isAgentConseil())
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-red-500 rounded-full"></div>
                            Documents back-office
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="urlcarte_grise" class="form-label">Carte grise (back-office)</label>
                                @if($opportunity->urlcarte_grise)
                                    <p class="text-xs text-accent-600 mt-1 mb-2"><a href="{{ asset('storage/' . $opportunity->urlcarte_grise) }}" target="_blank" class="hover:underline">Fichier existant</a></p>
                                @endif
                                <input type="file" id="urlcarte_grise" name="urlcarte_grise" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                            </div>
                            <div class="form-group">
                                <label for="url_attestationassurance" class="form-label">Attestation (back-office)</label>
                                @if($opportunity->url_attestationassurance)
                                    <p class="text-xs text-accent-600 mt-1 mb-2"><a href="{{ asset('storage/' . $opportunity->url_attestationassurance) }}" target="_blank" class="hover:underline">Fichier existant</a></p>
                                @endif
                                <input type="file" id="url_attestationassurance" name="url_attestationassurance" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                            </div>
                        </div>
                    </div>
                    @endif

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
</x-app-layout>
