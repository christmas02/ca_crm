<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">Assurances Partenaires</h2>
            <a href="{{ route('insurance-partners.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Ajouter un partenaire
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-700 font-semibold">Erreurs:</p>
                <ul class="text-red-600 text-sm mt-2">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($partners as $partner)
                <div class="card hover:shadow-lg transition-shadow">
                    <div class="card-header">
                        <div class="flex items-center gap-3">
                            @if($partner->logo)
                                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/></svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $partner->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $partner->email }}</p>
                            </div>
                            @if($partner->active)
                                <span class="badge bg-green-100 text-green-700">Actif</span>
                            @else
                                <span class="badge bg-gray-100 text-gray-700">Inactif</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body space-y-3">
                        @if($partner->telephone)
                            <div>
                                <p class="text-xs text-gray-400">Téléphone</p>
                                <p class="text-sm text-gray-700">{{ $partner->telephone }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-gray-400">Commission</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $partner->commission_rate }}%</p>
                        </div>
                        @if($partner->description)
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $partner->description }}</p>
                        @endif
                    </div>
                    <div class="card-footer flex gap-2">
                        <a href="{{ route('insurance-partners.show', $partner) }}" class="btn-secondary text-sm flex-1">Voir</a>
                        <a href="{{ route('insurance-partners.edit', $partner) }}" class="btn-secondary text-sm flex-1">Éditer</a>
                        <form method="POST" action="{{ route('insurance-partners.destroy', $partner) }}" onsubmit="return confirm('Êtes-vous sûr ?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger text-sm w-full">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p class="text-gray-500 text-lg">Aucun partenaire d'assurance trouvé</p>
                    <a href="{{ route('insurance-partners.create') }}" class="btn-primary mt-4 inline-block">Créer un partenaire</a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $partners->links() }}
        </div>
    </div>
</x-app-layout>
