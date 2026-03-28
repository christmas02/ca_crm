<x-app-layout>
    <x-slot name="header">Bordereaux</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
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

        {{-- Placeholder pour futurs menus --}}
        <div class="card opacity-50">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="badge bg-gray-100 text-gray-600 text-xs">À venir</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Bordereau Partenaire</h3>
                <p class="text-sm text-gray-500">Performance des assureurs</p>
            </div>
        </div>
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
