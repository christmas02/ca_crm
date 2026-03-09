@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Opportunités Gagnées</h1>
            <p class="text-gray-600">{{ $opportunities->total() }} opportunité(s) en renouvellement</p>
        </div>
    </div>

    @if($opportunities->count() > 0)
    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Assureur</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Créée par</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($opportunities as $opportunity)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-800">
                                    {{ $opportunity->client?->full_name ?? $opportunity->nom . ' ' . $opportunity->prenoms }}
                                </span>
                                @if($opportunity->client?->telephone)
                                <span class="text-sm text-gray-600">{{ $opportunity->client->telephone }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-800">{{ $opportunity->nom }} {{ $opportunity->prenoms }}</span>
                                <span class="text-sm text-gray-600">{{ $opportunity->telephone }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($opportunity->insurancePartner)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">
                                {{ $opportunity->insurancePartner->name }}
                            </span>
                            @elseif($opportunity->assureur_actuel)
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded">
                                {{ $opportunity->assureur_actuel }}
                            </span>
                            @else
                            <span class="text-gray-400 text-sm">Non spécifié</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($opportunity->montant_ttc)
                            <span class="font-semibold text-gray-800">{{ number_format($opportunity->montant_ttc, 0, ',', ' ') }} FCFA</span>
                            @else
                            <span class="text-gray-400 text-sm">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $opportunity->creator?->name ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('opportunities.show', $opportunity) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-xs font-semibold">
                                    Voir
                                </a>
                                @can('update', $opportunity)
                                <a href="{{ route('opportunities.edit', $opportunity) }}" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition text-xs font-semibold">
                                    Modifier
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($opportunities->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $opportunities->links() }}
        </div>
        @endif
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Aucune opportunité gagnée</h3>
        <p class="text-gray-600">Il n'y a actuellement aucune opportunité avec le statut "Gagné" à gérer.</p>
    </div>
    @endif
</div>
@endsection
