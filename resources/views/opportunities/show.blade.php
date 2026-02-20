<x-app-layout>
    <x-slot name="header">{{ $opportunity->title }}</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Info Card --}}
            <div class="card">
                <div class="card-header">
                    <div class="flex items-center gap-3">
                        @if($opportunity->status)
                        <span class="badge text-white" style="background-color: {{ $opportunity->status->color }}">{{ $opportunity->status->name }}</span>
                        @endif
                        @if($opportunity->isasap === 'oui')
                        <span class="badge bg-red-100 text-red-700">ASAP</span>
                        @endif
                        @if($opportunity->client_id)
                        <a href="{{ route('clients.show', $opportunity->client_id) }}" class="badge bg-accent-100 text-accent-700 hover:bg-accent-200">Client</a>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        @can('update', $opportunity)
                        <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn-secondary text-xs px-3 py-1.5">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Modifier
                        </a>
                        @endcan
                        @can('delete', $opportunity)
                        <form method="POST" action="{{ route('opportunities.destroy', $opportunity) }}" onsubmit="return confirm('Supprimer cette opportunité ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger text-xs px-3 py-1.5">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Supprimer
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    {{-- Prospect --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-1 h-4 bg-primary-400 rounded-full"></div>
                            Prospect
                        </h4>
                        <dl class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                            <div><dt class="text-gray-400 text-xs">Nom complet</dt><dd class="font-semibold text-gray-800 mt-0.5">{{ $opportunity->full_name }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Téléphone</dt><dd class="mt-0.5">{{ $opportunity->telephone ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Téléphone 2</dt><dd class="mt-0.5">{{ $opportunity->telephone2 ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Créé par</dt><dd class="mt-0.5">{{ $opportunity->creator->name ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Assigné à</dt><dd class="mt-0.5">{{ $opportunity->assignee->name ?? 'Non assigné' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Équipe</dt><dd class="mt-0.5">{{ $opportunity->team->name ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Canal</dt><dd class="mt-0.5">{{ $opportunity->canal ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Source</dt><dd class="mt-0.5">{{ $opportunity->source ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Date de création</dt><dd class="mt-0.5">{{ $opportunity->created_at->format('d/m/Y H:i') }}</dd></div>
                        </dl>
                    </div>

                    {{-- Véhicule & Assurance --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-1 h-4 bg-blue-500 rounded-full"></div>
                            Véhicule & Assurance
                        </h4>
                        <dl class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                            <div><dt class="text-gray-400 text-xs">Plaque</dt><dd class="mt-0.5">{{ $opportunity->plaque_immatriculation ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Échéance</dt><dd class="mt-0.5">{{ $opportunity->echeance ? $opportunity->echeance->format('d/m/Y') : '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Lieu prospection</dt><dd class="mt-0.5">{{ $opportunity->lieuprospection ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Assureur actuel</dt><dd class="mt-0.5">{{ $opportunity->assureur_actuel ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Période</dt><dd class="mt-0.5">{{ $opportunity->periode_souscription ? $opportunity->periode_souscription . ' mois' : '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Montant</dt><dd class="mt-0.5 font-semibold">{{ $opportunity->montant_souscription ? number_format($opportunity->montant_souscription, 0, ',', ' ') . ' FCFA' : '—' }}</dd></div>
                        </dl>
                    </div>

                    {{-- Statuts documents --}}
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-1 h-4 bg-yellow-500 rounded-full"></div>
                            Statuts documents
                        </h4>
                        <dl class="grid grid-cols-3 gap-4 text-sm">
                            <div><dt class="text-gray-400 text-xs">Discours</dt><dd class="mt-0.5">{{ $opportunity->statut_discours ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Carte grise</dt><dd class="mt-0.5">{{ $opportunity->statut_carte_grise ?? '—' }}</dd></div>
                            <div><dt class="text-gray-400 text-xs">Attestation</dt><dd class="mt-0.5">{{ $opportunity->statut_attestation ?? '—' }}</dd></div>
                        </dl>
                    </div>

                    {{-- Documents --}}
                    @if($opportunity->urlcarte_grise_terrain || $opportunity->url_attestationassurance_terrain || $opportunity->urlcarte_grise || $opportunity->url_attestationassurance)
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-1 h-4 bg-purple-500 rounded-full"></div>
                            Documents
                        </h4>
                        <div class="grid grid-cols-2 gap-3">
                            @if($opportunity->urlcarte_grise_terrain)
                            <a href="{{ asset('storage/' . $opportunity->urlcarte_grise_terrain) }}" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-primary-50 transition-colors group">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <div><p class="text-sm font-medium text-gray-700">Carte grise (terrain)</p><p class="text-xs text-gray-400">Télécharger</p></div>
                            </a>
                            @endif
                            @if($opportunity->url_attestationassurance_terrain)
                            <a href="{{ asset('storage/' . $opportunity->url_attestationassurance_terrain) }}" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-primary-50 transition-colors group">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <div><p class="text-sm font-medium text-gray-700">Attestation (terrain)</p><p class="text-xs text-gray-400">Télécharger</p></div>
                            </a>
                            @endif
                            @if($opportunity->urlcarte_grise)
                            <a href="{{ asset('storage/' . $opportunity->urlcarte_grise) }}" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-primary-50 transition-colors group">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <div><p class="text-sm font-medium text-gray-700">Carte grise (back-office)</p><p class="text-xs text-gray-400">Télécharger</p></div>
                            </a>
                            @endif
                            @if($opportunity->url_attestationassurance)
                            <a href="{{ asset('storage/' . $opportunity->url_attestationassurance) }}" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-primary-50 transition-colors group">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <div><p class="text-sm font-medium text-gray-700">Attestation (back-office)</p><p class="text-xs text-gray-400">Télécharger</p></div>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Observation --}}
                    @if($opportunity->observation)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800 mb-2 flex items-center gap-2">
                            <div class="w-1 h-4 bg-gray-400 rounded-full"></div>
                            Observation
                        </h4>
                        <p class="text-sm text-gray-600 bg-gray-50 rounded-lg p-4">{{ $opportunity->observation }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Comments --}}
            <div class="card">
                <div class="card-header">
                    <h3>Commentaires ({{ $opportunity->comments->count() }})</h3>
                </div>
                <div class="card-body space-y-4">
                    @forelse($opportunity->comments as $comment)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-semibold text-primary-600">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $comment->body }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-4">Aucun commentaire.</p>
                    @endforelse

                    <form method="POST" action="{{ route('comments.store', $opportunity) }}" class="mt-4 pt-4 border-t border-gray-100">
                        @csrf
                        <textarea name="body" rows="3" required placeholder="Ajouter un commentaire..." class="form-textarea"></textarea>
                        <button type="submit" class="mt-2 btn-primary text-sm">Commenter</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Assign --}}
            @can('assign', $opportunity)
            <div class="card">
                <div class="card-header"><h3>Affecter</h3></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('opportunities.assign', $opportunity) }}">
                        @csrf
                        <select name="assigned_to" required class="form-select">
                            <option value="">Sélectionner un agent</option>
                            @foreach($conseilUsers as $agent)
                                <option value="{{ $agent->id }}" {{ $opportunity->assigned_to == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="mt-3 w-full btn-primary justify-center">Affecter</button>
                    </form>
                </div>
            </div>
            @endcan

            {{-- Change Status --}}
            @can('changeStatus', $opportunity)
            <div class="card">
                <div class="card-header"><h3>Changer le statut</h3></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('opportunities.change-status', $opportunity) }}">
                        @csrf
                        <select name="status_id" required class="form-select">
                            @foreach($statuses->groupBy('group') as $group => $groupStatuses)
                                <optgroup label="{{ $group }}">
                                    @foreach($groupStatuses as $status)
                                        <option value="{{ $status->id }}" {{ $opportunity->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <button type="submit" class="mt-3 w-full btn-accent justify-center">Mettre à jour</button>
                    </form>
                </div>
            </div>
            @endcan

            {{-- Doublon --}}
            @if($opportunity->doublon_check)
            <div class="card border-yellow-200 bg-yellow-50">
                <div class="card-body">
                    <div class="flex items-center gap-2 text-yellow-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span class="font-semibold text-sm">Doublon détecté</span>
                    </div>
                    @if($opportunity->date_auth_doublon)
                    <p class="text-xs text-yellow-600 mt-2">Autorisé le {{ $opportunity->date_auth_doublon->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>
            @endif

            {{-- Assignment History --}}
            @if($opportunity->assignments->count())
            <div class="card">
                <div class="card-header"><h3>Historique d'affectation</h3></div>
                <div class="card-body space-y-3">
                    @foreach($opportunity->assignments->sortByDesc('created_at') as $assignment)
                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-2 h-2 bg-primary-400 rounded-full flex-shrink-0"></div>
                        <div>
                            <span class="text-gray-400 text-xs">{{ $assignment->created_at->format('d/m/Y H:i') }}</span>
                            <p class="text-gray-600">{{ $assignment->assigner->name }} &rarr; <span class="font-medium text-gray-800">{{ $assignment->assignee->name }}</span></p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
