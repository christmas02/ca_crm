<x-app-layout>
    <x-slot name="header">Tableau de bord</x-slot>

    {{-- Custom Stat Cards by Role --}}
    @if(isset($stats))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach($stats as $stat)
        <div class="stat-card cursor-pointer hover:shadow-lg transition-shadow stat-card-clickable" 
             data-stat-label="{{ $stat['label'] }}"
             data-stat-index="{{ $loop->index }}">
            <div>
                <p class="stat-card-value" style="color: {{ $stat['color'] }}">{{ $stat['value'] }}</p>
                <p class="stat-card-label">{{ $stat['label'] }}</p> 
            </div>
            <div class="stat-card-icon" style="background-color: {{ $stat['color'] }}15">
                <span style="color: {{ $stat['color'] }}" class="text-2xl">{{ $stat['icon'] }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Card pour afficher les opportunités correspondantes --}}
    @if(auth()->user()->isAgentConseil() || auth()->user()->isAgentConseilRenouvellement())
    <div class="card">
        <div class="card-header">
            <h3>Détail des opportunités</h3>
        </div>
        <div id="stat-opportunities-container" class="card-body">
            <div class="text-gray-400 text-center py-10">
                Cliquez sur une statistique pour afficher les opportunités correspondantes
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card-clickable');
            console.log('Nombres de stat cards trouvées:', statCards.length);
            
            statCards.forEach((card, index) => {
                console.log(`Attaching click listener to card ${index}:`, card);
                card.addEventListener('click', function() {
                    const label = this.getAttribute('data-stat-label');
                    const statIndex = this.getAttribute('data-stat-index');
                    console.log(`Carte cliquée: ${label} (index: ${statIndex})`);
                    
                    // Récupérer les opportunités correspondantes
                    fetch(`{{ route('dashboard.stat-opportunities') }}?stat_index=${statIndex}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Data reçue:', data);
                        displayOpportunities(data, label);
                    })
                    .catch(error => console.error('Erreur fetch:', error));
                });
            });
            
            function displayOpportunities(data, label) {
                const container = document.getElementById('stat-opportunities-container');
                console.log('Container trouvé:', container);
                
                if (!data.opportunities || data.opportunities.length === 0) {
                    container.innerHTML = `
                        <div class="text-gray-400 text-center py-10">
                            Aucune opportunité pour: <strong>${label}</strong>
                        </div>
                    `;
                    return;
                }
                
                let html = `
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Statut</th>
                                    <th>Nom du client</th>
                                    <th>Téléphone</th>
                                    <th>Immatriculation</th>
                                    <th>D-Échéance</th>
                                    <th>D-Relance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                
                data.opportunities.forEach(opp => {
                    const statusColor = opp.status?.color || '#999';
                    const statusName = opp.status?.name || 'N/A';
                    const echeanceDate = opp.echeance ? new Date(opp.echeance).toLocaleDateString('fr-FR') : '—';
                    const relanceDate = opp.relance ? new Date(opp.relance).toLocaleDateString('fr-FR') : '—';
                    
                    html += `
                        <tr>
                            <td><span class="badge text-white" style="background-color: ${statusColor}">${statusName}</span></td>
                            <td><a href="/opportunities/${opp.id}" class="text-primary-400 hover:text-primary-500 font-semibold">${opp.full_name}</a></td>
                            <td class="whitespace-nowrap">${opp.telephone || '—'}</td>
                            <td class="whitespace-nowrap">${opp.plaque_immatriculation || '—'}</td>
                            <td class="whitespace-nowrap">${echeanceDate}</td>
                            <td class="text-gray-400 whitespace-nowrap">${relanceDate}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="/opportunities/${opp.id}" class="text-gray-400 hover:text-primary-400" title="Voir">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="/opportunities/${opp.id}/edit" class="text-gray-400 hover:text-blue-500" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                
                html += `
                            </tbody>
                        </table>
                    </div>
                `;
                
                container.innerHTML = html;
            }
        });
    </script>

    {{-- Stat Cards by Group --}}
    @if(isset($groupCounts) && (auth()->user()->isAdmin() || auth()->user()->isLead()))
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        @foreach($groupCounts as $group)
        <a href="{{ $group->url ?? route('opportunities.index', ['group' => $group->group]) }}" class="stat-card hover:shadow-lg transition-shadow">
            <div>
                <p class="stat-card-value" style="color: {{ $group->color }}">{{ $group->count }}</p>
                <p class="stat-card-label">{{ $group->group }}</p> 
            </div>
            <div class="stat-card-icon" style="background-color: {{ $group->color }}15">
                <svg class="w-6 h-6" style="color: {{ $group->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    {{-- Admin/Lead Dashboard --}}
 

    @if(isset($recentOpportunities) && $recentOpportunities->count())
    <div class="card">
        <div class="card-header">
            <h3>Dernières opportunités</h3>
            <a href="{{ route('opportunities.index') }}" class="text-sm text-primary-400 hover:text-primary-500 font-medium">Voir tout</a>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom et prenom du client</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Assigné à</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOpportunities as $opp)
                    <tr>
                        <td><a href="{{ route('opportunities.show', $opp) }}" class="text-primary-400 hover:text-primary-500 font-medium">{{ $opp->full_name }}</a></td>
                        <td>{{ $opp->telephone ?? '—' }}</td>
                        <td>
                            @if($opp->status)
                            <span class="badge text-white" style="background-color: {{ $opp->status->color }}">{{ $opp->status->name }}</span>
                            @endif
                        </td>
                        <td>{{ $opp->assignee->name ?? '—' }}</td>
                        <td class="text-gray-400">{{ $opp->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif


    {{-- Agent Conseil Dashboard 
    @if(auth()->user()->isAgentConseil())
    <div class="card">
        <div class="card-header">
            <h3>Mes opportunités assignées</h3>
        </div>
        @if(isset($assignedOpportunities) && $assignedOpportunities->count())
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>

                        <th>Nom et prnom du client</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignedOpportunities as $opp)
                    <tr>
                        <td><a href="{{ route('opportunities.show', $opp) }}" class="text-primary-400 hover:text-primary-500 font-medium">{{ $opp->full_name }}</a></td>
                        <td>{{ $opp->telephone ?? '—' }}</td>
                        <td>
                            @if($opp->status)
                            <span class="badge text-white" style="background-color: {{ $opp->status->color }}">{{ $opp->status->name }}</span>
                            @endif
                        </td>
                        <td class="text-gray-400">{{ $opp->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="card-body text-gray-400 text-center py-10">Aucune opportunité assignée.</div>
        @endif
    </div>
    @endif --}}

    {{-- Agent Terrain Dashboard --}}
    @if(auth()->user()->isAgentTerrain())
    <div class="card">
        <div class="card-header">
            <h3>Mes opportunités créées</h3>
            <a href="{{ route('opportunities.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nouvelle
            </a>
        </div>
        @if(isset($createdOpportunities) && $createdOpportunities->count())
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Prospect</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Assigné à</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($createdOpportunities as $opp)
                    <tr>
                        <td><a href="{{ route('opportunities.show', $opp) }}" class="text-primary-400 hover:text-primary-500 font-medium">{{ $opp->title }}</a></td>
                        <td class="font-medium text-gray-800">{{ $opp->full_name }}</td>
                        <td>{{ $opp->telephone ?? '—' }}</td>
                        <td>
                            @if($opp->status)
                            <span class="badge text-white" style="background-color: {{ $opp->status->color }}">{{ $opp->status->name }}</span>
                            @endif
                        </td>
                        <td>{{ $opp->assignee->name ?? '—' }}</td>
                        <td class="text-gray-400">{{ $opp->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="card-body text-gray-400 text-center py-10">Aucune opportunité créée.</div>
        @endif
    </div>
    @endif
</x-app-layout>
