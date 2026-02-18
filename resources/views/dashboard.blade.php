<x-app-layout>
    <x-slot name="header">Tableau de bord</x-slot>

    {{-- Status Cards --}}
    @if(isset($statusCounts))
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        @foreach($statusCounts as $status)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $status->color }}"></div>
                <span class="text-sm font-medium text-gray-600">{{ $status->name }}</span>
            </div>
            <p class="text-2xl font-bold mt-2">{{ $status->opportunities_count }}</p>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Admin/Lead Dashboard --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isLead())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Total Opportunités</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalOpportunities ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Total Clients</h3>
            <p class="text-3xl font-bold text-green-600">{{ $totalClients ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Utilisateurs</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $totalUsers ?? 0 }}</p>
        </div>
    </div>

    {{-- Recent Opportunities Table --}}
    @if(isset($recentOpportunities) && $recentOpportunities->count())
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Dernières opportunités</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigné à</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentOpportunities as $opp)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('opportunities.show', $opp) }}" class="text-indigo-600 hover:underline">{{ $opp->title }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->client->full_name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: {{ $opp->status->color }}">
                                {{ $opp->status->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->assignee->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $opp->created_at->format('d/m/Y') }}</td>
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
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Mes opportunités assignées</h3>
        </div>
        @if(isset($assignedOpportunities) && $assignedOpportunities->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($assignedOpportunities as $opp)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('opportunities.show', $opp) }}" class="text-indigo-600 hover:underline">{{ $opp->title }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->client->full_name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: {{ $opp->status->color }}">
                                {{ $opp->status->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $opp->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="p-6 text-gray-500">Aucune opportunité assignée.</p>
        @endif
    </div>
    @endif

    {{-- Agent Terrain Dashboard --}}
    @if(auth()->user()->isAgentTerrain())
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold">Mes opportunités créées</h3>
            <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                Nouvelle opportunité
            </a>
        </div>
        @if(isset($createdOpportunities) && $createdOpportunities->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigné à</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($createdOpportunities as $opp)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('opportunities.show', $opp) }}" class="text-indigo-600 hover:underline">{{ $opp->title }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->client->full_name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: {{ $opp->status->color }}">
                                {{ $opp->status->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->assignee->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $opp->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="p-6 text-gray-500">Aucune opportunité créée.</p>
        @endif
    </div>
    @endif
</x-app-layout>
