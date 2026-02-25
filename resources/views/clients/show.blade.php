<x-app-layout>
    <x-slot name="header">Client : {{ $client->full_name }}</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Client info --}}
        <div class="lg:col-span-2 card">
            <div class="card-header">
                <h3>Informations</h3>
            </div>
            <div class="card-body">
                <dl class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div><dt class="text-gray-400 text-xs">Nom</dt><dd class="font-medium text-gray-800 mt-0.5">{{ $client->nom ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400 text-xs">Prénoms</dt><dd class="font-medium text-gray-800 mt-0.5">{{ $client->prenoms ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400 text-xs">Téléphone</dt><dd class="mt-0.5">{{ $client->telephone ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400 text-xs">Téléphone 2</dt><dd class="mt-0.5">{{ $client->telephone2 ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400 text-xs">Plaque</dt><dd class="mt-0.5">{{ $client->plaque_immatriculation ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400 text-xs">Assureur actuel</dt><dd class="mt-0.5">{{ $client->assureur_actuel ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400 text-xs">Lieu de prospection</dt><dd class="mt-0.5">{{ $client->lieuprospection ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400 text-xs">Client depuis</dt><dd class="mt-0.5">{{ $client->created_at->format('d/m/Y') }}</dd></div>
                </dl>
            </div>
        </div>

        {{-- Stats --}}
        <div class="card">
            <div class="card-header"><h3>Résumé</h3></div>
            <div class="card-body flex flex-col items-center justify-center py-8">
                <p class="text-4xl font-bold text-primary-400">{{ $client->opportunities->count() }}</p>
                <p class="text-sm text-gray-400 mt-1">Opportunités</p>
            </div>
        </div>
    </div>

    {{-- Opportunités liées --}}
    <div class="card">
        <div class="card-header">
            <h3>Opportunités</h3>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Agent Conseil</th>
                        <th>Créé par</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($client->opportunities as $opp)
                    <tr>
                        <td><a href="{{ route('opportunities.show', $opp) }}" class="text-primary-400 hover:text-primary-500 font-semibold">{{ $opp->title }}</a></td>
                        <td>
                            <span class="badge text-white" style="background-color: {{ $opp->status->color ?? '#6b7280' }}">{{ $opp->status->name ?? '—' }}</span>
                        </td>
                        <td>{{ $opp->assignee->name ?? '—' }}</td>
                        <td>{{ $opp->creator->name ?? '—' }}</td>
                        <td class="text-gray-400">{{ $opp->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400">Aucune opportunité liée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
