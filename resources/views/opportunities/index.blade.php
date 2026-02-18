<x-app-layout>
    <x-slot name="header">Opportunités</x-slot>

    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <form method="GET" action="{{ route('opportunities.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <select name="status_id" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Tous les statuts</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">Filtrer</button>
        </form>
        @can('create', App\Models\Opportunity::class)
        <a href="{{ route('opportunities.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
            Nouvelle opportunité
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Créé par</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigné à</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Source</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($opportunities as $opp)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('opportunities.show', $opp) }}" class="text-indigo-600 hover:underline font-medium">{{ $opp->title }}</a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->client->full_name }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: {{ $opp->status->color }}">
                            {{ $opp->status->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->creator->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->assignee->name ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $opp->source ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $opp->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Aucune opportunité trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $opportunities->links() }}
    </div>
</x-app-layout>
