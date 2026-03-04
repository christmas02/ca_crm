<x-app-layout>
    <x-slot name="header">Éditer un partenaire d'assurance</x-slot>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header">
                <h3>{{ $insurancePartner->name }}</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-700 font-semibold">Erreurs:</p>
                        <ul class="text-red-600 text-sm mt-2">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('insurance-partners.update', $insurancePartner) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="space-y-6">
                        {{-- Information Générale --}}
                        <div class="pb-6 border-b border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-800 mb-4">Informations générales</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group md:col-span-2">
                                    <label for="name" class="form-label">Nom du partenaire *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $insurancePartner->name) }}" required class="form-input">
                                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $insurancePartner->email) }}" required class="form-input">
                                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $insurancePartner->telephone) }}" class="form-input">
                                    @error('telephone')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- Détails --}}
                        <div class="pb-6 border-b border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-800 mb-4">Détails</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="website" class="form-label">Site web</label>
                                    <input type="url" id="website" name="website" value="{{ old('website', $insurancePartner->website) }}" class="form-input">
                                    @error('website')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="commission_rate" class="form-label">Taux de commission (%) *</label>
                                    <input type="number" id="commission_rate" name="commission_rate" value="{{ old('commission_rate', $insurancePartner->commission_rate) }}" step="0.01" min="0" max="100" required class="form-input">
                                    @error('commission_rate')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group md:col-span-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" rows="4" class="form-textarea">{{ old('description', $insurancePartner->description) }}</textarea>
                                    @error('description')<span class="form-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- Logo et Status --}}
                        <div class="pb-6 border-b border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-800 mb-4">Logo</h4>
                            @if($insurancePartner->logo)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $insurancePartner->logo) }}" alt="{{ $insurancePartner->name }}" class="h-32 rounded-lg">
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="logo" class="form-label">Changer le logo</label>
                                <input type="file" id="logo" name="logo" accept="image/*" class="form-input text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF (max 5MB)</p>
                                @error('logo')<span class="form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Statut --}}
                        <div>
                            <label class="flex items-center gap-3">
                                <input type="hidden" name="active" value="0">
                                <input type="checkbox" name="active" value="1" {{ old('active', $insurancePartner->active) ? 'checked' : '' }} class="w-4 h-4 text-primary-600 rounded">
                                <span class="text-sm font-medium text-gray-700">Actif</span>
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Mettre à jour
                        </button>
                        <a href="{{ route('insurance-partners.index') }}" class="btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
