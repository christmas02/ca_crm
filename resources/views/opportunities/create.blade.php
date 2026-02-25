<x-app-layout>
    <x-slot name="header">Nouvelle opportunité</x-slot>

    <div class="max-w-4xl">
        <div class="card">
            <div class="card-header">
                <h3>Créer une opportunité</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('opportunities.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Section: Prospect --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-primary-400 rounded-full"></div>
                            Informations du prospect
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label for="nom" class="form-label">Nom *</label>
                                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required class="form-input">
                                @error('nom')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="prenoms" class="form-label">Prénoms *</label>
                                <input type="text" id="prenoms" name="prenoms" value="{{ old('prenoms') }}" required class="form-input">
                                @error('prenoms')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="telephone" class="form-label">Téléphone *</label>
                                <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}" required class="form-input">
                                @error('telephone')<span class="form-error">{{ $message }}</span>@enderror
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
                                <label for="observation" class="form-label">Observation</label>
                                <textarea id="observation" name="observation" rows="3" class="form-textarea">{{ old('observation') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="canal" class="form-label">Canal</label>
                                <select id="canal" name="canal" class="form-select">
                                    <option value="">Sélectionner</option>
                                    @foreach(['Appel téléphonique', 'Email direct', 'Porte-à-porte', 'Salon auto', 'Web', 'Recommandation'] as $canal)
                                        <option value="{{ $canal }}" {{ old('canal') == $canal ? 'selected' : '' }}>{{ $canal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="telephone2" class="form-label">Téléphone secondaire</label>
                                <input type="text" id="telephone2" name="telephone2" value="{{ old('telephone2') }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="isasap" class="form-label">Client ASAP</label>
                                <select id="isasap" name="isasap" class="form-select">
                                    <option value="">Sélectionner</option>
                                    <option value="oui" {{ old('isasap') == 'oui' ? 'selected' : '' }}>Oui</option>
                                    <option value="non" {{ old('isasap') == 'non' ? 'selected' : '' }}>Non</option>
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
                                <input type="text" id="plaque_immatriculation" name="plaque_immatriculation" value="{{ old('plaque_immatriculation') }}" placeholder="Ex: AB-123-CD" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="echeance" class="form-label">Date d'échéance assurance</label>
                                <input type="date" id="echeance" name="echeance" value="{{ old('echeance') }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="lieuprospection" class="form-label">Lieu de prospection</label>
                                <input type="text" id="lieuprospection" name="lieuprospection" value="{{ old('lieuprospection') }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="assureur_actuel" class="form-label">Assureur actuel</label>
                                <input type="text" id="assureur_actuel" name="assureur_actuel" value="{{ old('assureur_actuel') }}" class="form-input">
                            </div>
                        </div>
                    </div>

                    {{-- Section: Documents --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-purple-500 rounded-full"></div>
                            Documents
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="urlcarte_grise_terrain" class="form-label">Carte grise</label>
                                <input type="file" id="urlcarte_grise_terrain" name="urlcarte_grise_terrain" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                                <p class="text-xs text-gray-400 mt-1">PDF, JPG ou PNG (max 5MB)</p>
                            </div>
                            <div class="form-group">
                                <label for="url_attestationassurance_terrain" class="form-label">Attestation d'assurance</label>
                                <input type="file" id="url_attestationassurance_terrain" name="url_attestationassurance_terrain" accept=".pdf,.jpg,.jpeg,.png" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                                <p class="text-xs text-gray-400 mt-1">PDF, JPG ou PNG (max 5MB)</p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Créer l'opportunité
                        </button>
                        <a href="{{ route('opportunities.index') }}" class="btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
