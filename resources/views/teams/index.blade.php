<x-app-layout>
    <x-slot name="header">Gestion des équipes</x-slot>

    <div class="mb-4 flex justify-end">
        <a href="{{ route('teams.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Nouvelle équipe</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($teams as $team)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">{{ $team->name }}</h3>
                <span class="text-sm text-gray-500">{{ $team->users_count }} membres</span>
            </div>
            <p class="text-sm text-gray-600 mb-4">{{ $team->description ?? 'Aucune description' }}</p>
            <div class="flex gap-3">
                <a href="{{ route('teams.edit', $team) }}" class="text-sm text-indigo-600 hover:underline">Modifier</a>
                <form method="POST" action="{{ route('teams.destroy', $team) }}" onsubmit="return confirm('Supprimer cette équipe ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
