<x-app-layout>
    <x-slot name="header">Modifier l'utilisateur</x-slot>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header"><h3>{{ $user->name }}</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="identification" class="form-label">Identification *</label>
                            <input type="text" id="identification" name="identification" value="{{ old('identification', $user->identification) }}" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas modifier)</label>
                            <input type="password" id="password" name="password" class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="role_id" class="form-label">Rôle *</label>
                            <select id="role_id" name="role_id" required class="form-select">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="team_id" class="form-label">Équipe</label>
                            <select id="team_id" name="team_id" class="form-select">
                                <option value="">Aucune</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team_id', $user->team_id) == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary">Enregistrer</button>
                        <a href="{{ route('users.index') }}" class="btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
