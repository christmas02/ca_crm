<x-app-layout>
    <x-slot name="header">Bordereau Agents Terrain</x-slot>

    {{-- Barre de navigation --}}
    <div class="mb-6 flex gap-2">
        <a href="{{ route('bordereaux.index') }}" class="btn-secondary text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Accueil Reporting
        </a>
        <div class="badge bg-orange-100 text-orange-700">Agents Terrain</div>
    </div>

    {{-- Filtres de dates --}}
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Période d'analyse
            </h3>
            <form method="GET" action="{{ route('bordereaux.agents-terrain') }}" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Date de début</label>
                    <input type="date" name="date_debut" value="{{ $dateDebut->format('Y-m-d') }}" class="form-input w-full">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Date de fin</label>
                    <input type="date" name="date_fin" value="{{ $dateFin->format('Y-m-d') }}" class="form-input w-full">
                </div>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filtrer
                </button>
                <a href="{{ route('bordereaux.agents-terrain') }}" class="btn-secondary">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Réinitialiser
                </a>
            </form>
        </div>
    </div>

    {{-- Tableau de performance --}}
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Performance des Agents Terrain
            </h3>

            @if($metriques->isEmpty())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">Aucun agent terrain trouvé pour la période sélectionnée.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="border-b-2 border-gray-300 bg-gray-50">
                                <th class="text-left py-2 px-2 font-semibold text-gray-700">Agent</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">Opp Remontées</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">Nb CG</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">Discours OK</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">Discours NOK</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">CG No Flag</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">CG OK</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">CG NOK</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">Opp Hors Cible</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">Opp Perdus</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700">Jours Travaillés</th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700 bg-blue-50">Contrats/Opp % </th>
                                <th class="text-center py-2 px-2 font-semibold text-gray-700 bg-green-50">Taux Qualif. %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($metriques as $metrique)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    {{-- Agent --}}
                                    <td class="py-2 px-2 text-gray-900 font-semibold">
                                        <div>{{ $metrique['agent_nom'] }}</div>
                                    </td>

                                    {{-- Opp Remontées --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-indigo-100 text-indigo-700 rounded font-bold text-sm">{{ $metrique['opp_remontees'] }}</span>
                                    </td>

                                    {{-- Nb Cartes Grises --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-purple-100 text-purple-700 rounded font-bold text-sm">{{ $metrique['nb_cartes_grises'] }}</span>
                                    </td>

                                    {{-- Discours OK --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-700 rounded font-bold text-sm">{{ $metrique['discours_ok'] }}</span>
                                    </td>

                                    {{-- Discours NOK --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-red-100 text-red-700 rounded font-bold text-sm">{{ $metrique['discours_nok'] }}</span>
                                    </td>

                                    {{-- CG No Flag --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-700 rounded font-bold text-sm">{{ $metrique['cg_no_flag'] }}</span>
                                    </td>

                                    {{-- CG OK --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-emerald-100 text-emerald-700 rounded font-bold text-sm">{{ $metrique['cg_ok'] }}</span>
                                    </td>

                                    {{-- CG NOK --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-pink-100 text-pink-700 rounded font-bold text-sm">{{ $metrique['cg_nok'] }}</span>
                                    </td>

                                    {{-- Opp Hors Cible --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-orange-100 text-orange-700 rounded font-bold text-sm">{{ $metrique['opp_hors_cible'] }}</span>
                                    </td>

                                    {{-- Opp Perdus --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-rose-100 text-rose-700 rounded font-bold text-sm">{{ $metrique['opp_perdue'] }}</span>
                                    </td>

                                    {{-- Jours Travaillés --}}
                                    <td class="py-2 px-2 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded font-bold text-sm">{{ $metrique['nb_jours_travailles'] }}</span>
                                    </td>

                                    {{-- Contrats par Opp (%) --}}
                                    <td class="py-2 px-2 text-center bg-blue-50">
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-700">{{ $metrique['nb_contrats_par_opp'] }}%</span>
                                        </div>
                                    </td>

                                    {{-- Taux Qualification (%) --}}
                                    <td class="py-2 px-2 text-center bg-green-50">
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700">{{ $metrique['taux_qualification'] }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Résumé des statistiques --}}
                <div class="mt-6 grid grid-cols-6 gap-3 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <div class="text-xl font-bold text-indigo-600">{{ $metriques->sum('opp_remontees') }}</div>
                        <div class="text-xs text-gray-600 mt-1">Opp. Remontées</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-purple-600">{{ $metriques->sum('nb_cartes_grises') }}</div>
                        <div class="text-xs text-gray-600 mt-1">Cartes Grises</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-green-600">{{ $metriques->sum('discours_ok') }}</div>
                        <div class="text-xs text-gray-600 mt-1">Discours OK</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-emerald-600">{{ $metriques->sum('cg_ok') }}</div>
                        <div class="text-xs text-gray-600 mt-1">CG Validées</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-orange-600">{{ $metriques->sum('opp_hors_cible') }}</div>
                        <div class="text-xs text-gray-600 mt-1">Opp. Hors Cible</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-blue-600">{{ round($metriques->avg('taux_qualification'), 1) }}%</div>
                        <div class="text-xs text-gray-600 mt-1">Taux Qualif. Moyen</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Graphiques --}}
    @if($metriques->isNotEmpty())
        <div class="grid grid-cols-2 gap-6 mb-6">
            {{-- Graphique: Opportunités par agent --}}
            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Opportunités par Agent
                    </h3>
                    <canvas id="chartOpportunites"></canvas>
                </div>
            </div>

            {{-- Graphique: Taux de qualification --}}
            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Taux de Qualification
                    </h3>
                    <canvas id="chartQualification"></canvas>
                </div>
            </div>

            {{-- Graphique: Contrats gagnés --}}
            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Performance Contrats
                    </h3>
                    <canvas id="chartContrats"></canvas>
                </div>
            </div>

            {{-- Graphique: Ratio de conversion --}}
            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Ratio de Conversion
                    </h3>
                    <canvas id="chartConversion"></canvas>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @if($metriques->isNotEmpty())
            // Préparer les données
            const agents = @json($metriques->pluck('agent_nom'));
            const oppRemontees = @json($metriques->pluck('opportunites_remontees'));
            const oppQualifiees = @json($metriques->pluck('opportunites_qualifiees'));
            const tauxQualification = @json($metriques->pluck('taux_qualification'));
            const oppGagnees = @json($metriques->pluck('opportunites_gagnees'));
            const contratsGagnes = @json($metriques->pluck('contrats_gagnes'));
            const ratioConversion = @json($metriques->pluck('ratio_conversion'));

            // Graphique 1: Opportunités par agent
            new Chart(document.getElementById('chartOpportunites'), {
                type: 'bar',
                data: {
                    labels: agents,
                    datasets: [
                        {
                            label: 'Opportunités Remontées',
                            data: oppRemontees,
                            backgroundColor: 'rgba(99, 102, 241, 0.8)',
                            borderColor: 'rgb(99, 102, 241)',
                            borderWidth: 2
                        },
                        {
                            label: 'Opportunités Qualifiées',
                            data: oppQualifiees,
                            backgroundColor: 'rgba(34, 197, 94, 0.8)',
                            borderColor: 'rgb(34, 197, 94)',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Graphique 2: Taux de qualification
            new Chart(document.getElementById('chartQualification'), {
                type: 'line',
                data: {
                    labels: agents,
                    datasets: [
                        {
                            label: 'Taux de Qualification (%)',
                            data: tauxQualification,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 6,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true, max: 100 } }
                }
            });

            // Graphique 3: Contrats gagnés
            new Chart(document.getElementById('chartContrats'), {
                type: 'bar',
                data: {
                    labels: agents,
                    datasets: [
                        {
                            label: 'Opportunités Gagnées',
                            data: oppGagnees,
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 2
                        },
                        {
                            label: 'Contrats Gagnés',
                            data: contratsGagnes,
                            backgroundColor: 'rgba(5, 150, 105, 0.8)',
                            borderColor: 'rgb(5, 150, 105)',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Graphique 4: Ratio de conversion
            new Chart(document.getElementById('chartConversion'), {
                type: 'radar',
                data: {
                    labels: agents,
                    datasets: [
                        {
                            label: 'Ratio de Conversion (%)',
                            data: ratioConversion,
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.2)',
                            pointBackgroundColor: 'rgb(34, 197, 94)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { r: { beginAtZero: true, max: 100 } }
                }
            });
        @endif
    </script>

</x-app-layout>
