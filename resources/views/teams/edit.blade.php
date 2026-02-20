<x-app-layout>
    <x-slot name="header">Modifier l'équipe</x-slot>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header"><h3>{{ $team->name }}</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('teams.update', $team) }}">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $team->name) }}" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="3" class="form-textarea">{{ old('description', $team->description) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary">Enregistrer</button>
                        <a href="{{ route('teams.index') }}" class="btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
