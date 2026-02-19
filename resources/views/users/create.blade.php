<x-app-layout>
    <x-slot name="header">Nouvel utilisateur</x-slot>

    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header"><h3>Créer un utilisateur</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe *</label>
                            <input type="password" id="password" name="password" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="role_id" class="form-label">Rôle *</label>
                            <select id="role_id" name="role_id" required class="form-select">
                                <option value="">Sélectionner</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="team_id" class="form-label">Équipe</label>
                            <select id="team_id" name="team_id" class="form-select">
                                <option value="">Aucune</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary">Créer</button>
                        <a href="{{ route('users.index') }}" class="btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
