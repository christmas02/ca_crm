<x-app-layout>
    <x-slot name="header">Nouvel utilisateur</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <input type="password" id="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700">Rôle</label>
                        <select id="role_id" name="role_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sélectionner</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="team_id" class="block text-sm font-medium text-gray-700">Équipe</label>
                        <select id="team_id" name="team_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Aucune</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Créer</button>
                    <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
