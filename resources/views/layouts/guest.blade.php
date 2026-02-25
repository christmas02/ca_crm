<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CA CRM') }} - Connexion</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        {{-- Left: Login Form --}}
        <div class="flex-1 flex flex-col justify-center px-8 sm:px-16 lg:px-24 bg-white">
            <div class="max-w-md w-full mx-auto">
                {{-- Logo --}}
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-primary-400 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">CA <span class="text-primary-400">CRM</span></h1>
                            <p class="text-xs text-gray-400">Call Center Assurances</p>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Bon retour !</h2>
                    <p class="text-gray-500 mt-2">Connectez-vous pour accéder à votre espace de travail.</p>
                </div>

                {{ $slot }}

                <div class="mt-10 pt-6 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">CA CRM - Call Center Assurances</p>
                </div>
            </div>
        </div>

        {{-- Right: Orange Panel --}}
        <div class="hidden lg:flex lg:w-[45%] bg-gradient-to-b from-primary-400 to-orange-500 flex-col items-center justify-center p-12 text-white relative overflow-hidden">
            {{-- Decorative circles --}}
            <div class="absolute top-10 right-10 w-40 h-40 bg-white/5 rounded-full"></div>
            <div class="absolute bottom-20 left-10 w-60 h-60 bg-white/5 rounded-full"></div>

            <div class="relative z-10 text-center max-w-sm">
                {{-- Icon --}}
                <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-10">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>

                {{-- Feature cards --}}
                <div class="space-y-4 mb-10">
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl px-6 py-4 text-left">
                        <p class="text-white/70 text-xs">Gestion des</p>
                        <p class="font-semibold text-lg">Opportunités & Prospects</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl px-6 py-4 text-left">
                        <p class="text-white/70 text-xs">Suivi des</p>
                        <p class="font-semibold text-lg">Clients & Contrats</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl px-6 py-4 text-left">
                        <p class="text-white/70 text-xs">Pilotage des</p>
                        <p class="font-semibold text-lg">Équipes & Performance</p>
                    </div>
                </div>

                {{-- Quote --}}
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 bg-accent-500 rounded-full flex items-center justify-center text-white font-bold text-sm">CA</div>
                        <div class="text-left">
                            <p class="font-semibold text-sm">Call Center Assurances</p>
                            <p class="text-white/60 text-xs">Plateforme CRM</p>
                        </div>
                    </div>
                    <p class="text-white/80 text-sm italic">"Une plateforme moderne pour une gestion efficace de nos activités quotidiennes."</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
