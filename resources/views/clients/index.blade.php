<x-app-layout>
    <x-slot name="header">Clients</x-slot>

    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <form method="GET" action="{{ route('clients.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un client..." class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">Rechercher</button>
        </form>
        <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Nouveau client</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ville</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Opportunités</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($clients as $client)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">
                        <a href="{{ route('clients.show', $client) }}" class="text-indigo-600 hover:underline">{{ $client->full_name }}</a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $client->email ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $client->phone ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $client->city ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $client->opportunities_count }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:underline">Modifier</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Aucun client trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $clients->links() }}</div>
</x-app-layout>
