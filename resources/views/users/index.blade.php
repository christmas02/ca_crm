<x-app-layout>
    <x-slot name="header">Gestion des utilisateurs</x-slot>

    <div class="mb-4 flex justify-end">
        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Nouvel utilisateur</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">{{ $user->role->name ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->team->name ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm flex gap-3">
                        <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:underline">Modifier</a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</x-app-layout>
