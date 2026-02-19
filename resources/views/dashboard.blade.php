<x-app-layout>
    <x-slot name="header">Tableau de bord</x-slot>

    {{-- Stat Cards by Status --}}
    @if(isset($statusCounts))
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        @foreach($statusCounts as $status)
        <div class="stat-card">
            <div>
                <p class="stat-card-value" style="color: {{ $status->color }}">{{ $status->opportunities_count }}</p>
                <p class="stat-card-label">{{ $status->name }}</p>
            </div>
            <div class="stat-card-icon" style="background-color: {{ $status->color }}15">
                <svg class="w-6 h-6" style="color: {{ $status->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Admin/Lead Dashboard --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isLead())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat-card">
            <div>
                <p class="stat-card-value text-primary-500">{{ $totalOpportunities ?? 0 }}</p>
                <p class="stat-card-label">Total Opportunités</p>
            </div>
            <div class="stat-card-icon bg-primary-50">
                <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <p class="stat-card-value text-accent-500">{{ $totalClients ?? 0 }}</p>
                <p class="stat-card-label">Clients (Gagnés)</p>
            </div>
            <div class="stat-card-icon bg-accent-50">
                <svg class="w-6 h-6 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <p class="stat-card-value text-purple-500">{{ $totalUsers ?? 0 }}</p>
                <p class="stat-card-label">Utilisateurs</p>
            </div>
            <div class="stat-card-icon bg-purple-50">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
    </div>

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
                        <th>Titre</th>
                        <th>Prospect</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Assigné à</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOpportunities as $opp)
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
    </div>
    @endif
    @endif

    {{-- Agent Conseil Dashboard --}}
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
                        <th>Titre</th>
                        <th>Prospect</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignedOpportunities as $opp)
                    <tr>
                        <td><a href="{{ route('opportunities.show', $opp) }}" class="text-primary-400 hover:text-primary-500 font-medium">{{ $opp->title }}</a></td>
                        <td class="font-medium text-gray-800">{{ $opp->full_name }}</td>
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
    @endif

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
