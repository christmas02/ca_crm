<x-app-layout>
    <x-slot name="header">Bordereau Contrats par Équipe</x-slot>

    {{-- Barre de navigation / sous-menus --}}
    <div class="mb-6 flex gap-2">
        <a href="{{ route('bordereaux.index') }}" class="btn-secondary text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Accueil Reporting
        </a>
        <div class="badge bg-amber-100 text-amber-700">Contrats par Équipe</div>
    </div>

    {{-- Filtres de date --}}
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Filtres de période
            </h3>
            <form method="GET" action="{{ route('bordereaux.contrats-gagnes-equipe') }}" class="flex gap-4 items-end flex-wrap">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Date de début</label>
                    <input type="date" name="date_debut" value="{{ $dateDebut->format('Y-m-d') }}" class="form-input w-40">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Date de fin</label>
                    <input type="date" name="date_fin" value="{{ $dateFin->format('Y-m-d') }}" class="form-input w-40">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Ou date spécifique</label>
                    <input type="date" name="date_specifique" value="{{ request('date_specifique', '') }}" class="form-input w-40" placeholder="Sélectionner une date">
                </div>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filtrer
                </button>
                <a href="{{ route('bordereaux.contrats-gagnes-equipe') }}" class="btn-secondary text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Réinitialiser
                </a>
            </form>
        </div>
    </div>

    {{-- Tableau récapitulatif par équipe --}}
    <div class="card">
        <div class="card-body">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Performance par Équipe
            </h3>
            
            @if($donnees->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <p class="text-gray-500 font-semibold">Aucune donnée pour cette période</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-300 bg-gray-50">
                                <th class="text-left py-3 px-3 font-semibold text-gray-700">Équipe</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Opp Traité</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Contrat AN/</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Contrat RN/</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Score</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Taux Aff / Traité</th>
                                <th class="text-center py-3 px-3 font-semibold text-gray-700">Taux Conv %</th>
                                <th class="text-right py-3 px-3 font-semibold text-gray-700">Prime Nette</th>
                                <th class="text-right py-3 px-3 font-semibold text-gray-700">Prime TTC</th>
                                <th class="text-right py-3 px-3 font-semibold text-gray-700">Prime Moy</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donnees as $row)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 text-gray-900 font-semibold">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 6a3 3 0 11-6 0 3 3 0 016 0zM17 9a4 4 0 100-8 4 4 0 000 8z"/></svg>
                                            {{ $row['nom'] }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center text-gray-700">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded font-semibold">{{ $row['opp_traite'] }}</span>
                                    </td>
                                    <td class="py-3 px-3 text-center text-gray-700">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 rounded font-semibold">{{ $row['contrat_nouveau'] }}</span>
                                    </td>
                                    <td class="py-3 px-3 text-center text-gray-700">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-amber-100 text-amber-700 rounded font-semibold">{{ $row['contrat_renouveller'] }}</span>
                                    </td>
                                    <td class="py-3 px-3 text-center text-gray-900 font-bold">
                                        <span class="inline-flex items-center justify-center w-10 h-10 bg-primary-100 text-primary-700 rounded-full font-bold">{{ $row['score'] }}</span>
                                    </td>
                                    <td class="py-3 px-3 text-center text-gray-700">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">{{ $row['taux_affectees'] }}% / {{ $row['taux_traitees'] }}%</span>
                                    </td>
                                    <td class="py-3 px-3 text-center text-gray-700">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">{{ $row['taux_conversion'] }}%</span>
                                    </td>
                                    <td class="py-3 px-3 text-right text-gray-900 font-semibold">{{ number_format($row['prime_nette'], 2, ',', ' ') }} XOF</td>
                                    <td class="py-3 px-3 text-right text-gray-900 font-semibold">{{ number_format($row['prime_ttc'], 2, ',', ' ') }} XOF</td>
                                    <td class="py-3 px-3 text-right text-gray-900 font-semibold">{{ number_format($row['prime_moyenne'], 2, ',', ' ') }} XOF</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Total Row --}}
                <div class="mt-4 pt-4 border-t-2 border-gray-300">
                    <div class="grid grid-cols-10 gap-3 text-sm font-semibold text-gray-900">
                        <div class="col-span-1">TOTAL</div>
                        <div class="col-span-1 text-center">{{ $donnees->sum('opp_traite') }}</div>
                        <div class="col-span-1 text-center">{{ $donnees->sum('contrat_nouveau') }}</div>
                        <div class="col-span-1 text-center">{{ $donnees->sum('contrat_renouveller') }}</div>
                        <div class="col-span-1 text-center">{{ number_format($donnees->sum('score'), 2) }}</div>
                        <div class="col-span-1 text-center">{{ number_format($donnees->avg('taux_affectees'), 2) }}% / {{ number_format($donnees->avg('taux_traitees'), 2) }}%</div>
                        <div class="col-span-1 text-center">{{ number_format($donnees->avg('taux_conversion'), 2) }}%</div>
                        <div class="col-span-1 text-right">{{ number_format($donnees->sum('prime_nette'), 2, ',', ' ') }} XOF</div>
                        <div class="col-span-1 text-right">{{ number_format($donnees->sum('prime_ttc'), 2, ',', ' ') }} XOF</div>
                        <div class="col-span-1 text-right">{{ number_format($donnees->avg('prime_moyenne'), 2, ',', ' ') }} XOF</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
