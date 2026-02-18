<x-app-layout>
    <x-slot name="header">{{ $client->full_name }}</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Informations</h3>
                <a href="{{ route('clients.edit', $client) }}" class="text-sm text-indigo-600 hover:underline">Modifier</a>
            </div>
            <dl class="space-y-3 text-sm">
                <div><dt class="text-gray-500">Email</dt><dd>{{ $client->email ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Téléphone</dt><dd>{{ $client->phone ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Adresse</dt><dd>{{ $client->address ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Ville</dt><dd>{{ $client->city ?? '—' }}</dd></div>
            </dl>
        </div>

        <div class="lg:col-span-2 bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Opportunités ({{ $client->opportunities->count() }})</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigné à</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($client->opportunities as $opp)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm"><a href="{{ route('opportunities.show', $opp) }}" class="text-indigo-600 hover:underline">{{ $opp->title }}</a></td>
                            <td class="px-6 py-4 text-sm">
                                @if($opp->status)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: {{ $opp->status->color }}">{{ $opp->status->name }}</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: #6b7280">Non assigné</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $opp->assignee->name ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucune opportunité.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
