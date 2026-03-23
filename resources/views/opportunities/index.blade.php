<x-app-layout>
    <x-slot name="header">Opportunités</x-slot>

    {{-- Filter bar --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('opportunities.index') }}" class="flex flex-wrap items-end gap-4 w-full">
            <div class="flex-1 min-w-[200px]">
                <label>Recherche</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, téléphone, plaque..." class="pl-10 w-full">
                </div>
            </div>
            
            <div>
                <label>Statut</label>
                <select name="status_id">
                    <option value="">Tous</option>
                    @foreach($statuses->groupBy('group') as $group => $groupStatuses)
                        <optgroup label="{{ $group }}">
                            @foreach($groupStatuses as $status)
                                <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Plage d'échéance</label>
                <div class="flex items-center gap-2">
                    <input type="date" name="date_start" value="{{ request('date_start') }}" class="form-input w-40">
                    <span class="text-gray-400">à</span>
                    <input type="date" name="date_end" value="{{ request('date_end') }}" class="form-input w-40">
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filtrer
                </button>
                @can('create', App\Models\Opportunity::class)
                <a href="{{ route('opportunities.create') }}" class="btn-primary bg-accent-500 hover:bg-accent-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nouvelle
                </a>
                @endcan
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card" x-data="{ 
        selectedIds: [], 
        allChecked: false,
        totalCheckboxes: 0,
        init() {
            this.totalCheckboxes = document.querySelectorAll('input.opportunity-checkbox').length;
        }
    }" x-init="init()">
        {{-- Bulk actions bar --}}
        @if(!auth()->user()->isAgentConseil() && !auth()->user()->isAgentConseilRenouvellement())
        <div x-show="selectedIds.length > 0" class="bg-blue-50 border-b border-blue-200 px-6 py-3 flex items-center justify-between">
            <span class="text-sm font-medium text-blue-800">
                <span x-text="selectedIds.length"></span> opportunité(s) sélectionnée(s)
            </span>
            <button @click="openAssignModal()" type="button" class="btn-primary bg-blue-500 hover:bg-blue-600">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Affecter à une personne
            </button>
        </div>
        @endif

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        @if(!auth()->user()->isAgentConseil() && !auth()->user()->isAgentConseilRenouvellement())
                        <th class="w-10">
                            <div class="flex flex-col items-center gap-2">
                                <input type="checkbox"
                                    @change="allChecked = $el.checked; selectedIds = allChecked ? Array.from(document.querySelectorAll('input.opportunity-checkbox')).map(el => el.value) : []; document.querySelectorAll('input.opportunity-checkbox').forEach(el => el.checked = allChecked)"
                                    :checked="allChecked"
                                    class="rounded cursor-pointer w-5 h-5" title="Sélectionner tout">
                                <div class="text-xs text-gray-500 font-semibold">OU</div>
                                <div class="flex flex-col items-center gap-1 bg-blue-50 p-2 rounded border-2 border-blue-300">
                                    <label class="text-xs font-bold text-blue-700 text-center">Sél. N</label>
                                    <div class="flex items-center gap-1">
                                        <input type="number" 
                                            min="0"
                                            :max="totalCheckboxes"
                                            placeholder="0"
                                            @change="
                                                const num = parseInt($el.value) || 0;
                                                const checkboxes = Array.from(document.querySelectorAll('input.opportunity-checkbox'));
                                                checkboxes.forEach((el, idx) => el.checked = idx < num);
                                                selectedIds = checkboxes.slice(0, num).map(el => el.value);
                                                allChecked = false;
                                            "
                                            class="w-14 h-8 text-center text-sm font-bold border-2 border-blue-500 rounded bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <span class="text-xs text-gray-600 font-semibold" x-text="'/ ' + totalCheckboxes"></span>
                                    </div>
                                </div>
                        </th>
                        @endif
                        <th>Statut</th>
                        <th>Nom du client</th>
                        <th>Téléphone</th>
                        <th>Immatriculation</th>
                        <th>D-Échéance</th>
                        <th>D-Relance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opportunities as $opp)
                    <tr>
                        @if(!auth()->user()->isAgentConseil() && !auth()->user()->isAgentConseilRenouvellement())
                        <td class="w-10">
                            <input type="checkbox"
                                name="opportunity_ids"
                                value="{{ $opp->id }}"
                                @change="selectedIds.includes(String($el.value)) ? selectedIds = selectedIds.filter(id => id !== String($el.value)) : selectedIds.push(String($el.value)); allChecked = false"
                                class="rounded opportunity-checkbox"
                            >
                        </td>
                        @endif
                        <td>
                            @if($opp->status)
                            <span class="badge text-white" style="background-color: {{ $opp->status->color }}">{{ $opp->status->name }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('opportunities.show', $opp) }}" class="text-primary-400 hover:text-primary-500 font-semibold">{{ $opp->full_name }}</a>
                        </td>
                        <td class="whitespace-nowrap">{{ $opp->telephone ?? '—' }}</td>
                        <td class="whitespace-nowrap">{{ $opp->plaque_immatriculation ?? '—' }}</td>
                        <td class="whitespace-nowrap">{{ $opp->echeance ? $opp->echeance->format('d/m/Y') : '—' }}</td>
                        <td class="text-gray-400 whitespace-nowrap">{{ $opp->relance ? $opp->relance->format('d/m/Y') : '—' }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('opportunities.show', $opp) }}" class="text-gray-400 hover:text-primary-400" title="Voir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @can('update', $opp)
                                <a href="{{ route('opportunities.edit', $opp) }}" class="text-gray-400 hover:text-blue-500" title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @endcan
                                @can('delete', $opp)
                                <form method="POST" action="{{ route('opportunities.destroy', $opp) }}" onsubmit="return confirm('Supprimer ?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-10 text-gray-400">Aucune opportunité trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $opportunities->links() }}</div>

    {{-- Assign Modal --}}
    <div id="assignModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Affecter à une personne</h2>
            </div>
            <form method="POST" action="{{ route('opportunities.bulkAssign') }}" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="selectedIds" name="opportunity_ids" value="">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sélectionnez une personne</label>
                    <select name="assigned_to" class="w-full" required>
                        <option value="">-- Choisir une personne --</option>
                        @foreach(\App\Models\User::orderBy('name')->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date d'affectation</label>
                    <input type="date" name="date_affect" value="{{ date('Y-m-d') }}" class="w-full" required>
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeAssignModal()" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Affecter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAssignModal() {
            const selectedIds = document.querySelectorAll('input[name=opportunity_ids]:checked');
            const ids = Array.from(selectedIds).map(el => el.value).join(',');
            document.getElementById('selectedIds').value = ids;
            document.getElementById('assignModal').classList.remove('hidden');
        }

        function closeAssignModal() {
            document.getElementById('assignModal').classList.add('hidden');
        }

        // Fermer le modal si on clique en dehors
        document.getElementById('assignModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeAssignModal();
            }
        });
    </script>
</x-app-layout>
