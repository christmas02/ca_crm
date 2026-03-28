<x-app-layout>
    <x-slot name="header">Bordereaux</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        {{-- Menu Bordereau Conseil --}}
        <a href="{{ route('bordereaux.conseil') }}" class="card hover:shadow-lg transition-shadow cursor-pointer group">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="badge bg-blue-100 text-blue-700 text-xs">Conseil</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Bordereau Conseil</h3>
                <p class="text-sm text-gray-500">Performance et statistiques des conseillers</p>
                <div class="text-xs text-primary-600 font-semibold mt-3 group-hover:translate-x-1 transition-transform">
                    Consulter →
                </div>
            </div>
        </a>

        {{-- Menu Contrats Gagnés --}}
        <a href="{{ route('bordereaux.contrats-gagnes') }}" class="card hover:shadow-lg transition-shadow cursor-pointer group">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="badge bg-green-100 text-green-700 text-xs">Contrats</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Contrats Gagnés</h3>
                <p class="text-sm text-gray-500">Détail des contrats nouveaux et renouvelés</p>
                <div class="text-xs text-green-600 font-semibold mt-3 group-hover:translate-x-1 transition-transform">
                    Consulter →
                </div>
            </div>
        </a>

        {{-- Menu Contrats Gagnés par Équipe --}}
        <a href="{{ route('bordereaux.contrats-gagnes-equipe') }}" class="card hover:shadow-lg transition-shadow cursor-pointer group">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="badge bg-amber-100 text-amber-700 text-xs">Équipe</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Contrats par Équipe</h3>
                <p class="text-sm text-gray-500">Performance des contrats par équipe</p>
                <div class="text-xs text-amber-600 font-semibold mt-3 group-hover:translate-x-1 transition-transform">
                    Consulter →
                </div>
            </div>
        </a>

        {{-- Stats Comparatives --}}
        <a href="{{ route('bordereaux.stats-comparatives') }}" class="card hover:shadow-lg transition-shadow cursor-pointer group">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12M8 11h12m-12 4h12m-12 4h12M3 7h.01M3 11h.01M3 15h.01M3 19h.01"/>
                        </svg>
                    </div>
                    <span class="badge bg-purple-100 text-purple-700 text-xs">Comparaison</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Stats Comparatives</h3>
                <p class="text-sm text-gray-500">Comparer les performances entre deux périodes</p>
                <div class="text-xs text-purple-600 font-semibold mt-3 group-hover:translate-x-1 transition-transform">
                    Consulter →
                </div>
            </div>
        </a>

        {{-- Agents Terrain --}}
        <a href="{{ route('bordereaux.agents-terrain') }}" class="card hover:shadow-lg transition-shadow cursor-pointer group">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="badge bg-orange-100 text-orange-700 text-xs">Terrain</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Agents Terrain</h3>
                <p class="text-sm text-gray-500">Suivi des agents de prospection et qualité des opportunités</p>
                <div class="text-xs text-orange-600 font-semibold mt-3 group-hover:translate-x-1 transition-transform">
                    Consulter →
                </div>
            </div>
        </a>
    </div>

    {{-- Info Card --}}
    <div class="card bg-blue-50 border border-blue-200">
        <div class="card-body">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-1">À propos des bordereaux</h4>
                    <p class="text-sm text-blue-800">Les bordereaux vous permettent de suivre en détail les performances de votre équipe. Consultez les statistiques, les graphiques et les points d'évolution pour optimiser vos stratégies.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
