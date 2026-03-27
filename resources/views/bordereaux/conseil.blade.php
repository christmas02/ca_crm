<x-app-layout>
    <x-slot name="header">Bordereau Conseil</x-slot>

    {{-- Barre de navigation / sous-menus --}}
    <div class="mb-6 flex gap-2">
        <a href="{{ route('bordereaux.index') }}" class="btn-secondary text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour aux bordereaux
        </a>
        <div class="badge bg-primary-100 text-primary-700">Conseil</div>
    </div>

    {{-- Filtres de date --}}
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Filtres de période
            </h3>
            <form method="GET" action="{{ route('bordereaux.conseil') }}" class="flex gap-4 items-end flex-wrap">
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
                <a href="{{ route('bordereaux.conseil') }}" class="btn-secondary text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Réinitialiser
                </a>
            </form>
        </div>
    </div>


    {{-- Statistiques globales --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Nombre de conseillers</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $donnees->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Opportunités traitées</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $donnees->sum('opp_traitees') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Taux conversion moyen</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            @if($donnees->count() > 0)
                                {{ round($donnees->avg('taux_conversion'), 2) }}%
                            @else
                                0%
                            @endif
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Score moyen</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">
                            @if($donnees->count() > 0)
                                {{ round($donnees->avg('score'), 1) }}/100
                            @else
                                0/100
                            @endif
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tableau des conseillers --}}
    <div class="card">
        <div class="card-header">
            <h3>Métriques des conseillers</h3>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom du conseil</th>
                        <th class="text-center">Opp. du jour</th>
                        <th class="text-center">Opp. Traitées</th>
                        <th class="text-center">Renouvellement</th>
                        <th class="text-center">Opp. gagnées</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Taux conversion</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donnees as $conseil)
                    <tr>
                        <td>
                            <span class="font-semibold text-gray-800">{{ $conseil['nom'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-blue-100 text-blue-700">{{ $conseil['opp_jour'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-orange-100 text-orange-700 font-semibold">{{ $conseil['opp_modifiees'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-yellow-100 text-yellow-700 font-semibold">{{ $conseil['total_renouvellement'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-green-100 text-green-700 font-semibold">{{ $conseil['opp_gagnees'] }}</span>
                        </td>
                        <td class="text-center">
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-12 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    @php
                                        $percentage = min($conseil['score'], 100);
                                        $bgColor = $percentage >= 75 ? 'bg-green-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                                    @endphp
                                    <div class="{{ $bgColor }} h-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="font-bold text-sm w-12 text-right">{{ $conseil['score'] }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="font-semibold {{ $conseil['taux_conversion'] >= 50 ? 'text-green-600' : 'text-orange-600' }}">
                                {{ $conseil['taux_conversion'] }}%
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('opportunities.index', ['assigned_to' => $conseil['id'], 'date_debut' => $dateDebut->format('Y-m-d'), 'date_fin' => $dateFin->format('Y-m-d')]) }}" class="text-primary-400 hover:text-primary-600" title="Voir les opportunités de cette période">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-400">
                            Aucun conseiller trouvé.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Graphique comparatif --}}
    @if($donnees->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        {{-- Graph Taux de conversion --}}
        <div class="card">
            <div class="card-header">
                <h3>Taux de conversion par conseiller</h3>
            </div>
            <div class="card-body">
                <canvas id="tauxConversionChart"></canvas>
            </div>
        </div>

        {{-- Graph Opportunités traitées --}}
        <div class="card">
            <div class="card-header">
                <h3>Opportunités traitées par conseiller</h3>
            </div>
            <div class="card-body">
                <canvas id="oppTraiteesChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graph 1: Taux de conversion
        const ctx1 = document.getElementById('tauxConversionChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: {!! json_encode($donnees->pluck('nom')) !!},
                datasets: [{
                    label: 'Taux de conversion (%)',
                    data: {!! json_encode($donnees->pluck('taux_conversion')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: { size: 12 }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });

        // Graph 2: Opportunités traitées
        const ctx2 = document.getElementById('oppTraiteesChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: {!! json_encode($donnees->pluck('nom')) !!},
                datasets: [{
                    label: 'Opportunités traitées',
                    data: {!! json_encode($donnees->pluck('opp_traitees')) !!},
                    backgroundColor: 'rgba(34, 197, 94, 0.5)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: { size: 12 }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
    @endif
</x-app-layout>
