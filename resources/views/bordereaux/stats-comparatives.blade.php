<x-app-layout>
    <x-slot name="header">Stats Comparatives - Comparaison de Périodes</x-slot>

    {{-- Barre de navigation --}}
    <div class="mb-6 flex gap-2">
        <a href="{{ route('bordereaux.index') }}" class="btn-secondary text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Accueil Reporting
        </a>
        <div class="badge bg-purple-100 text-purple-700">Comparaison de Périodes</div>
    </div>

    {{-- Filtres de dates --}}
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Sélectionner les périodes
            </h3>
            <form method="GET" action="{{ route('bordereaux.stats-comparatives') }}" class="grid grid-cols-2 gap-6">
                {{-- Période 1 --}}
                <div>
                    <h4 class="text-xs font-bold text-gray-700 mb-3 uppercase">Période 1</h4>
                    <div class="flex gap-3 items-end">
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Date de début</label>
                            <input type="date" name="p1_debut" value="{{ $p1_debut->format('Y-m-d') }}" class="form-input w-full">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Date de fin</label>
                            <input type="date" name="p1_fin" value="{{ $p1_fin->format('Y-m-d') }}" class="form-input w-full">
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 mt-2">
                        {{ $p1_debut->format('d/m/Y') }} → {{ $p1_fin->format('d/m/Y') }}
                    </div>
                </div>

                {{-- Période 2 --}}
                <div>
                    <h4 class="text-xs font-bold text-gray-700 mb-3 uppercase">Période 2</h4>
                    <div class="flex gap-3 items-end">
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Date de début</label>
                            <input type="date" name="p2_debut" value="{{ $p2_debut->format('Y-m-d') }}" class="form-input w-full">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Date de fin</label>
                            <input type="date" name="p2_fin" value="{{ $p2_fin->format('Y-m-d') }}" class="form-input w-full">
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 mt-2">
                        {{ $p2_debut->format('d/m/Y') }} → {{ $p2_fin->format('d/m/Y') }}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="col-span-2 flex gap-3 justify-end">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Comparer
                    </button>
                    <a href="{{ route('bordereaux.stats-comparatives') }}" class="btn-secondary">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tableau de comparaison --}}
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Comparaison des Métriques
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-300 bg-gray-50">
                            <th class="text-left py-3 px-3 font-semibold text-gray-700">Métrique</th>
                            <th class="text-center py-3 px-3 font-semibold text-gray-700">
                                <div class="text-xs uppercase">Période 1</div>
                                <div class="text-gray-500 font-normal">{{ $p1_debut->format('d/m') }} - {{ $p1_fin->format('d/m/Y') }}</div>
                            </th>
                            <th class="text-center py-3 px-3 font-semibold text-gray-700">
                                <div class="text-xs uppercase">Période 2</div>
                                <div class="text-gray-500 font-normal">{{ $p2_debut->format('d/m') }} - {{ $p2_fin->format('d/m/Y') }}</div>
                            </th>
                            <th class="text-center py-3 px-3 font-semibold text-gray-700">
                                <div class="text-xs uppercase">Évolution</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Total opportunités enregistrées --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 text-gray-900 font-semibold">Total Opportunités Enregistrées</td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-700 rounded font-semibold">{{ $metriques_p1['opp_total'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-700 rounded font-semibold">{{ $metriques_p2['opp_total'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['opp_total'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['opp_total'] }}%
                                    </span>
                                @elseif($variations['opp_total'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['opp_total'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Opportunités traitées --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 text-gray-900 font-semibold">Opportunités Traitées</td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-cyan-100 text-cyan-700 rounded font-semibold">{{ $metriques_p1['opp_traite'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-cyan-100 text-cyan-700 rounded font-semibold">{{ $metriques_p2['opp_traite'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['opp_traite'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['opp_traite'] }}%
                                    </span>
                                @elseif($variations['opp_traite'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['opp_traite'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Opportunités gagnées --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 text-gray-900 font-semibold">Opportunités Gagnées</td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-green-100 text-green-700 rounded font-semibold">{{ $metriques_p1['opp_gagnee'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-green-100 text-green-700 rounded font-semibold">{{ $metriques_p2['opp_gagnee'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['opp_gagnee'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['opp_gagnee'] }}%
                                    </span>
                                @elseif($variations['opp_gagnee'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['opp_gagnee'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Taux de conversion global --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors bg-primary-50">
                            <td class="py-3 px-3 text-gray-900 font-bold text-primary-900">Taux de Conversion Global</td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-100 text-primary-700">{{ $metriques_p1['taux_conversion'] }}%</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-100 text-primary-700">{{ $metriques_p2['taux_conversion'] }}%</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['taux_conversion'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['taux_conversion'] }}%
                                    </span>
                                @elseif($variations['taux_conversion'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['taux_conversion'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Total affaires nouvelles --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 text-gray-900 font-semibold">Total Affaires Nouvelles (XOF)</td>
                            <td class="py-3 px-3 text-center font-semibold text-gray-900">{{ number_format($metriques_p1['affaires_nouvelles'], 2, ',', ' ') }}</td>
                            <td class="py-3 px-3 text-center font-semibold text-gray-900">{{ number_format($metriques_p2['affaires_nouvelles'], 2, ',', ' ') }}</td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['affaires_nouvelles'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['affaires_nouvelles'] }}%
                                    </span>
                                @elseif($variations['affaires_nouvelles'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['affaires_nouvelles'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Chiffres d'affaires --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 text-gray-900 font-semibold">Chiffres d'Affaires (XOF)</td>
                            <td class="py-3 px-3 text-center font-semibold text-gray-900">{{ number_format($metriques_p1['chiffre_affaires'], 2, ',', ' ') }}</td>
                            <td class="py-3 px-3 text-center font-semibold text-gray-900">{{ number_format($metriques_p2['chiffre_affaires'], 2, ',', ' ') }}</td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['chiffre_affaires'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['chiffre_affaires'] }}%
                                    </span>
                                @elseif($variations['chiffre_affaires'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['chiffre_affaires'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Commission totale --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 text-gray-900 font-semibold">Commission Totale (XOF)</td>
                            <td class="py-3 px-3 text-center font-semibold text-gray-900">{{ number_format($metriques_p1['commission_total'], 2, ',', ' ') }}</td>
                            <td class="py-3 px-3 text-center font-semibold text-gray-900">{{ number_format($metriques_p2['commission_total'], 2, ',', ' ') }}</td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['commission_total'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['commission_total'] }}%
                                    </span>
                                @elseif($variations['commission_total'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['commission_total'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Nombre de contrats --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 text-gray-900 font-semibold">Nombre de Contrats</td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-indigo-100 text-indigo-700 rounded font-semibold">{{ $metriques_p1['nombre_contrats'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-indigo-100 text-indigo-700 rounded font-semibold">{{ $metriques_p2['nombre_contrats'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['nombre_contrats'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['nombre_contrats'] }}%
                                    </span>
                                @elseif($variations['nombre_contrats'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['nombre_contrats'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Prime moyenne par contrat --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 text-gray-900 font-semibold">Prime Moyenne par Contrat (XOF)</td>
                            <td class="py-3 px-3 text-center font-semibold text-gray-900">{{ number_format($metriques_p1['prime_moyenne'], 2, ',', ' ') }}</td>
                            <td class="py-3 px-3 text-center font-semibold text-gray-900">{{ number_format($metriques_p2['prime_moyenne'], 2, ',', ' ') }}</td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['prime_moyenne'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['prime_moyenne'] }}%
                                    </span>
                                @elseif($variations['prime_moyenne'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['prime_moyenne'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Score moyen par équipe --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors bg-purple-50">
                            <td class="py-3 px-3 text-gray-900 font-bold text-purple-900">Score Moyen par Équipe</td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 text-purple-700 rounded-full font-bold text-lg">{{ $metriques_p1['score_moyen_equipe'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 text-purple-700 rounded-full font-bold text-lg">{{ $metriques_p2['score_moyen_equipe'] }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                @if($variations['score_moyen_equipe'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        +{{ $variations['score_moyen_equipe'] }}%
                                    </span>
                                @elseif($variations['score_moyen_equipe'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                                        {{ $variations['score_moyen_equipe'] }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0%</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Légende des variations --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="card bg-green-50 border border-green-200">
            <div class="card-body">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-green-900 text-sm">Amélioration</h4>
                        <p class="text-xs text-green-700">Croissance positive</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-red-50 border border-red-200">
            <div class="card-body">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-red-900 text-sm">Diminution</h4>
                        <p class="text-xs text-red-700">Baisse négative</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-gray-50 border border-gray-200">
            <div class="card-body">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 1114 0 7 7 0 01-14 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Stable</h4>
                        <p class="text-xs text-gray-700">Aucune variation</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="grid grid-cols-2 gap-6 mb-6">
        {{-- Comparaison Opportunités --}}
        <div class="card">
            <div class="card-body">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Comparaison Opportunités
                </h3>
                <canvas id="chartOpportunites"></canvas>
            </div>
        </div>

        {{-- Comparaison Chiffres d'Affaires --}}
        <div class="card">
            <div class="card-body">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Chiffres d'Affaires
                </h3>
                <canvas id="chartAffaires"></canvas>
            </div>
        </div>

        {{-- Comparaison Contrats --}}
        <div class="card">
            <div class="card-body">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Performance Contrats
                </h3>
                <canvas id="chartContrats"></canvas>
            </div>
        </div>

        {{-- Comparaison Taux & Scores --}}
        <div class="card">
            <div class="card-body">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Taux & Scores
                </h3>
                <canvas id="chartTauxScores"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Couleurs
        const colorPrimaire = 'rgba(59, 130, 246, 0.8)';
        const colorSecondaire = 'rgba(34, 197, 94, 0.8)';
        const colorBorder1 = 'rgb(59, 130, 246)';
        const colorBorder2 = 'rgb(34, 197, 94)';

        // Graphique 1: Opportunités
        new Chart(document.getElementById('chartOpportunites'), {
            type: 'bar',
            data: {
                labels: ['Total Opp', 'Opp Traitées', 'Opp Gagnées'],
                datasets: [
                    {
                        label: 'Période 1',
                        data: [{{ $metriques_p1['opp_total'] }}, {{ $metriques_p1['opp_traite'] }}, {{ $metriques_p1['opp_gagnee'] }}],
                        backgroundColor: colorPrimaire,
                        borderColor: colorBorder1,
                        borderWidth: 2
                    },
                    {
                        label: 'Période 2',
                        data: [{{ $metriques_p2['opp_total'] }}, {{ $metriques_p2['opp_traite'] }}, {{ $metriques_p2['opp_gagnee'] }}],
                        backgroundColor: colorSecondaire,
                        borderColor: colorBorder2,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Graphique 2: Chiffres d'Affaires
        new Chart(document.getElementById('chartAffaires'), {
            type: 'bar',
            data: {
                labels: ['Affaires Nouvelles', 'CA Total', 'Commission'],
                datasets: [
                    {
                        label: 'Période 1',
                        data: [{{ $metriques_p1['affaires_nouvelles'] }}, {{ $metriques_p1['chiffre_affaires'] }}, {{ $metriques_p1['commission_total'] }}],
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 2
                    },
                    {
                        label: 'Période 2',
                        data: [{{ $metriques_p2['affaires_nouvelles'] }}, {{ $metriques_p2['chiffre_affaires'] }}, {{ $metriques_p2['commission_total'] }}],
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Graphique 3: Contrats
        new Chart(document.getElementById('chartContrats'), {
            type: 'radar',
            data: {
                labels: ['Contrats', 'Prime Moyenne', 'Taux Conversion'],
                datasets: [
                    {
                        label: 'Période 1',
                        data: [{{ $metriques_p1['nombre_contrats'] }}, {{ $metriques_p1['prime_moyenne'] / 1000 }}, {{ $metriques_p1['taux_conversion'] }}],
                        borderColor: colorBorder1,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        pointBackgroundColor: colorBorder1,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Période 2',
                        data: [{{ $metriques_p2['nombre_contrats'] }}, {{ $metriques_p2['prime_moyenne'] / 1000 }}, {{ $metriques_p2['taux_conversion'] }}],
                        borderColor: colorBorder2,
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        pointBackgroundColor: colorBorder2,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        suggestedMax: 100
                    }
                }
            }
        });

        // Graphique 4: Taux & Scores
        new Chart(document.getElementById('chartTauxScores'), {
            type: 'line',
            data: {
                labels: ['Taux Conversion', 'Score', 'Prime Moy (÷100)'],
                datasets: [
                    {
                        label: 'Période 1',
                        data: [{{ $metriques_p1['taux_conversion'] }}, {{ $metriques_p1['score_moyen_equipe'] }}, {{ $metriques_p1['prime_moyenne'] / 100 }}],
                        borderColor: colorBorder1,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: colorBorder1
                    },
                    {
                        label: 'Période 2',
                        data: [{{ $metriques_p2['taux_conversion'] }}, {{ $metriques_p2['score_moyen_equipe'] }}, {{ $metriques_p2['prime_moyenne'] / 100 }}],
                        borderColor: colorBorder2,
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: colorBorder2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>