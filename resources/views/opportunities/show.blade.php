<x-app-layout>
    <x-slot name="header">{{ $opportunity->title }}</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    @if($opportunity->status)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $opportunity->status->color }}">
                        {{ $opportunity->status->name }}
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: #6b7280">
                        Non assigné
                    </span>
                    @endif
                    <div class="flex gap-2">
                        @can('update', $opportunity)
                        <a href="{{ route('opportunities.edit', $opportunity) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200">Modifier</a>
                        @endcan
                        @can('delete', $opportunity)
                        <form method="POST" action="{{ route('opportunities.destroy', $opportunity) }}" onsubmit="return confirm('Supprimer cette opportunité ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-sm rounded-md hover:bg-red-200">Supprimer</button>
                        </form>
                        @endcan
                    </div>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">Client</dt>
                        <dd class="mt-1"><a href="{{ route('clients.show', $opportunity->client) }}" class="text-indigo-600 hover:underline">{{ $opportunity->client->full_name }}</a></dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Source</dt>
                        <dd class="mt-1">{{ $opportunity->source ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Canal</dt>
                        <dd class="mt-1">{{ $opportunity->canal ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Créé par</dt>
                        <dd class="mt-1">{{ $opportunity->creator->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Assigné à</dt>
                        <dd class="mt-1">{{ $opportunity->assignee->name ?? 'Non assigné' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Équipe</dt>
                        <dd class="mt-1">{{ $opportunity->team->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Date de création</dt>
                        <dd class="mt-1">{{ $opportunity->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Immatriculation véhicule</dt>
                        <dd class="mt-1">{{ $opportunity->vehicle_registration ?? '—' }}</dd>
                    </div>
                </dl>

                {{-- Vehicle & Location Info --}}
                <div class="mt-4 pt-4 border-t grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">Date d'échéance assurance</dt>
                        <dd class="mt-1">{{ $opportunity->insurance_expiration_date ? \Carbon\Carbon::parse($opportunity->insurance_expiration_date)->format('d/m/Y') : '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Lieu de prospection</dt>
                        <dd class="mt-1">{{ $opportunity->prospection_location ?? '—' }}</dd>
                    </div>
                </div>

                {{-- Documents --}}
                @if($opportunity->gray_card_path || $opportunity->attestation_path)
                <div class="mt-4 pt-4 border-t">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Documents</h4>
                    <div class="space-y-2">
                        @if($opportunity->gray_card_path)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Carte grise</span>
                            <a href="{{ asset('storage/' . $opportunity->gray_card_path) }}" target="_blank" class="text-indigo-600 hover:underline text-xs">Télécharger</a>
                        </div>
                        @endif
                        @if($opportunity->attestation_path)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Attestation</span>
                            <a href="{{ asset('storage/' . $opportunity->attestation_path) }}" target="_blank" class="text-indigo-600 hover:underline text-xs">Télécharger</a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @if($opportunity->description)
                <div class="mt-4 pt-4 border-t">
                    <h4 class="text-sm font-medium text-gray-500">Description</h4>
                    <p class="mt-1 text-sm text-gray-700">{{ $opportunity->description }}</p>
                </div>
                @endif
            </div>

            {{-- Comments --}}
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">Commentaires ({{ $opportunity->comments->count() }})</h3>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($opportunity->comments as $comment)
                    <div class="border-l-4 border-indigo-200 pl-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-700 mt-1">{{ $comment->body }}</p>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Aucun commentaire.</p>
                    @endforelse

                    <form method="POST" action="{{ route('comments.store', $opportunity) }}" class="mt-4 pt-4 border-t">
                        @csrf
                        <textarea name="body" rows="3" required placeholder="Ajouter un commentaire..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                        <button type="submit" class="mt-2 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Commenter</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar Actions --}}
        <div class="space-y-6">
            {{-- Assign --}}
            @can('assign', $opportunity)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Affecter à un agent conseil</h3>
                <form method="POST" action="{{ route('opportunities.assign', $opportunity) }}">
                    @csrf
                    <select name="assigned_to" required class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Sélectionner</option>
                        @foreach($conseilUsers as $agent)
                            <option value="{{ $agent->id }}" {{ $opportunity->assigned_to == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700">Affecter</button>
                </form>
            </div>
            @endcan

            {{-- Change Status --}}
            @can('changeStatus', $opportunity)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Changer le statut</h3>
                <form method="POST" action="{{ route('opportunities.change-status', $opportunity) }}">
                    @csrf
                    <select name="status_id" required class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ $opportunity->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">Mettre à jour</button>
                </form>
            </div>
            @endcan

            {{-- Assignment History --}}
            @if($opportunity->assignments->count())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Historique d'affectation</h3>
                <div class="space-y-2">
                    @foreach($opportunity->assignments->sortByDesc('created_at') as $assignment)
                    <div class="text-sm">
                        <span class="text-gray-500">{{ $assignment->created_at->format('d/m/Y H:i') }}</span><br>
                        <span class="text-gray-600">{{ $assignment->assigner->name }}</span> &rarr; <span class="font-medium">{{ $assignment->assignee->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
