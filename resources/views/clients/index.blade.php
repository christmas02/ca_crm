<x-app-layout>
    <x-slot name="header">Clients</x-slot>

    {{-- Filter bar --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('clients.index') }}" class="flex flex-wrap items-end gap-4 w-full">
            <div class="flex-1 min-w-[200px]">
                <label>Recherche</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, téléphone, plaque..." class="pl-10 w-full">
                </div>
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Rechercher
            </button>
        </form>
    </div>

    <p class="text-xs text-gray-400 mb-4">Les clients sont créés automatiquement lorsqu'une opportunité passe au statut "Gagné".</p>

    {{-- Table --}}
    <div class="card">
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom complet</th>
                        <th>Téléphone</th>
                        <th>Plaque</th>
                        <th>Assureur</th>
                        <th>Lieu</th>
                        <th>Opportunités</th>
                        <th>Créé le</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td>
                            <a href="{{ route('clients.show', $client) }}" class="text-primary-400 hover:text-primary-500 font-semibold">{{ $client->full_name }}</a>
                        </td>
                        <td class="whitespace-nowrap">{{ $client->telephone }}</td>
                        <td>{{ $client->plaque_immatriculation ?? '—' }}</td>
                        <td>{{ $client->assureur_actuel ?? '—' }}</td>
                        <td>{{ $client->lieuprospection ?? '—' }}</td>
                        <td>
                            <span class="badge bg-primary-100 text-primary-700">{{ $client->opportunities_count }}</span>
                        </td>
                        <td class="text-gray-400">{{ $client->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-400">Aucun client pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $clients->links() }}</div>
</x-app-layout>
