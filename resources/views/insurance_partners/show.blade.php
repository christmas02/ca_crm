<x-app-layout>
    <x-slot name="header">{{ $insurancePartner->name }}</x-slot>

    <div class="max-w-4xl">
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        @if($insurancePartner->logo)
                            <img src="{{ asset('storage/' . $insurancePartner->logo) }}" alt="{{ $insurancePartner->name }}" class="w-16 h-16 rounded-lg object-cover">
                        @else
                            <div class="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/></svg>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $insurancePartner->name }}</h3>
                            @if($insurancePartner->active)
                                <span class="badge bg-green-100 text-green-700">Actif</span>
                            @else
                                <span class="badge bg-gray-100 text-gray-700">Inactif</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('insurance-partners.edit', $insurancePartner) }}" class="btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Éditer
                        </a>
                        <form method="POST" action="{{ route('insurance-partners.destroy', $insurancePartner) }}" onsubmit="return confirm('Êtes-vous sûr ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body space-y-6">
                {{-- Informations de contact --}}
                <div class="pb-6 border-b border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="w-1 h-4 bg-primary-400 rounded-full"></div>
                        Informations de contact
                    </h4>
                    <dl class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-400 text-xs">Email</dt>
                            <dd class="mt-0.5">
                                <a href="mailto:{{ $insurancePartner->email }}" class="text-primary-600 hover:text-primary-700">{{ $insurancePartner->email }}</a>
                            </dd>
                        </div>
                        @if($insurancePartner->telephone)
                        <div>
                            <dt class="text-gray-400 text-xs">Téléphone</dt>
                            <dd class="mt-0.5">
                                <a href="tel:{{ $insurancePartner->telephone }}" class="text-primary-600 hover:text-primary-700">{{ $insurancePartner->telephone }}</a>
                            </dd>
                        </div>
                        @endif
                        @if($insurancePartner->website)
                        <div>
                            <dt class="text-gray-400 text-xs">Site web</dt>
                            <dd class="mt-0.5">
                                <a href="{{ $insurancePartner->website }}" target="_blank" rel="noopener noreferrer" class="text-primary-600 hover:text-primary-700">Visiter</a>
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>

                {{-- Commission et détails --}}
                <div class="pb-6 border-b border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="w-1 h-4 bg-blue-500 rounded-full"></div>
                        Commission
                    </h4>
                    <dl class="grid grid-cols-1 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-400 text-xs">Taux de commission</dt>
                            <dd class="mt-0.5 text-lg font-semibold text-gray-800">{{ $insurancePartner->commission_rate }}%</dd>
                        </div>
                    </dl>
                </div>

                {{-- Description --}}
                @if($insurancePartner->description)
                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="w-1 h-4 bg-gray-400 rounded-full"></div>
                        Description
                    </h4>
                    <p class="text-sm text-gray-600 bg-gray-50 rounded-lg p-4">{{ $insurancePartner->description }}</p>
                </div>
                @endif
            </div>
            <div class="card-footer text-xs text-gray-500">
                <p>Créé le {{ $insurancePartner->created_at->format('d/m/Y H:i') }}</p>
                <p>Modifié le {{ $insurancePartner->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('insurance-partners.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour à la liste
            </a>
        </div>
    </div>
</x-app-layout>
