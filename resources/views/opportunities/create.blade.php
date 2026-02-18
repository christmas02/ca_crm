<x-app-layout>
    <x-slot name="header">Nouvelle opportunité</x-slot>

    <div class="max-w-4xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('opportunities.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Client --}}
                    <div class="md:col-span-2">
                        <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                        <select id="client_id" name="client_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                            @endforeach
                        </select>
                        @error('client_id')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                    </div>

                    {{-- Titre --}}
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    </div>

                    {{-- Canal --}}
                    <div>
                        <label for="canal" class="block text-sm font-medium text-gray-700">Canal (Moyen d'arrivée)</label>
                        <select id="canal" name="canal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner</option>
                            @foreach(['Appel téléphonique', 'Email direct', 'Porte-à-porte', 'Salon auto', 'Web', 'Recommandation'] as $canal)
                                <option value="{{ $canal }}" {{ old('canal') == $canal ? 'selected' : '' }}>{{ $canal }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Source --}}
                    <div>
                        <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                        <select id="source" name="source" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner</option>
                            @foreach(['Téléphone', 'Email', 'Site web', 'Recommandation', 'Salon', 'Porte-à-porte'] as $src)
                                <option value="{{ $src }}" {{ old('source') == $src ? 'selected' : '' }}>{{ $src }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Immatriculation du véhicule --}}
                    <div>
                        <label for="vehicle_registration" class="block text-sm font-medium text-gray-700">Immatriculation du véhicule</label>
                        <input type="text" id="vehicle_registration" name="vehicle_registration" value="{{ old('vehicle_registration') }}" placeholder="Ex: AB-123-CD" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Date d'échéance de l'assurance --}}
                    <div>
                        <label for="insurance_expiration_date" class="block text-sm font-medium text-gray-700">Date d'échéance assurance</label>
                        <input type="date" id="insurance_expiration_date" name="insurance_expiration_date" value="{{ old('insurance_expiration_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Lieu de prospection --}}
                    <div>
                        <label for="prospection_location" class="block text-sm font-medium text-gray-700">Lieu de prospection</label>
                        <input type="text" id="prospection_location" name="prospection_location" value="{{ old('prospection_location') }}" placeholder="Ex: Paris 15e" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Carte grise --}}
                    <div>
                        <label for="gray_card_path" class="block text-sm font-medium text-gray-700">Carte grise</label>
                        <input type="file" id="gray_card_path" name="gray_card_path" accept=".pdf,.jpg,.jpeg,.png" class="mt-1 block w-full text-sm text-gray-500">
                        <p class="text-xs text-gray-500 mt-1">PDF, JPG ou PNG</p>
                    </div>

                    {{-- Attestation --}}
                    <div>
                        <label for="attestation_path" class="block text-sm font-medium text-gray-700">Attestation</label>
                        <input type="file" id="attestation_path" name="attestation_path" accept=".pdf,.jpg,.jpeg,.png" class="mt-1 block w-full text-sm text-gray-500">
                        <p class="text-xs text-gray-500 mt-1">PDF, JPG ou PNG</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Créer</button>
                    <a href="{{ route('opportunities.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
