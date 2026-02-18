<x-app-layout>
    <x-slot name="header">Modifier le client</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('clients.update', $client) }}">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $client->first_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $client->last_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $client->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $client->address) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $client->city) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Enregistrer</button>
                    <a href="{{ route('clients.show', $client) }}" class="text-sm text-gray-600 hover:text-gray-900">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
