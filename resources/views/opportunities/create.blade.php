<x-app-layout>
    <x-slot name="header">Nouvelle opportunité</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('opportunities.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                        <select id="client_id" name="client_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                        <select id="source" name="source" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner</option>
                            @foreach(['Téléphone', 'Email', 'Site web', 'Recommandation', 'Salon', 'Porte-à-porte'] as $src)
                                <option value="{{ $src }}" {{ old('source') == $src ? 'selected' : '' }}>{{ $src }}</option>
                            @endforeach
                        </select>
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
