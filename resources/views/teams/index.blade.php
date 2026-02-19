<x-app-layout>
    <x-slot name="header">Gestion des équipes</x-slot>

    <div class="mb-4 flex justify-end">
        <a href="{{ route('teams.create') }}" class="btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nouvelle équipe
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($teams as $team)
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $team->name }}</h3>
                    <span class="badge bg-primary-100 text-primary-700">{{ $team->users_count }} membres</span>
                </div>
                <p class="text-sm text-gray-500 mb-4">{{ $team->description ?? 'Aucune description' }}</p>
                <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                    <a href="{{ route('teams.edit', $team) }}" class="text-gray-400 hover:text-blue-500" title="Modifier">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form method="POST" action="{{ route('teams.destroy', $team) }}" onsubmit="return confirm('Supprimer cette équipe ?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500" title="Supprimer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
