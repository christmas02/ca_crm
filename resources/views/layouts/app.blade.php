<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CA CRM') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50 flex">
        {{-- Sidebar --}}
        <aside class="sidebar hidden md:flex">
            {{-- Logo --}}
            <div class="sidebar-logo">
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-primary-400 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">CA <span class="text-primary-400">CRM</span></h1>
                        <p class="text-[10px] text-gray-400 -mt-0.5">Call Center Assurances</p>
                    </div>
                </div>
            </div>

            {{-- User --}}
            <div class="sidebar-user">
                <div class="sidebar-user-avatar bg-primary-400">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->identification }}</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-2">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Tableau de bord
                </a>

                <div class="sidebar-section">Prospection</div>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('opportunities.index') }}" class="sidebar-link {{ request()->routeIs('opportunities.index') || request()->routeIs('opportunities.show') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Toutes les opportunités
                </a>
                @endif

                @if(auth()->user()->isAgentConseil())
                <a href="{{ route('opportunities.new') }}" class="sidebar-link {{ request()->routeIs('opportunities.new') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12a2 2 0 104 0 2 2 0 00-4 0zm7-2a2 2 0 110-4 2 2 0 010 4zM5.728 11.694a6 6 0 018.546 0M5.727 17.25a3 3 0 017.546 0"/></svg>
                    Mes Opportunités 
                </a>
                @endif

                {{--<a href="{{ route('opportunities.new') }}" class="sidebar-link {{ request()->routeIs('opportunities.new') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12a2 2 0 104 0 2 2 0 00-4 0zm7-2a2 2 0 110-4 2 2 0 010 4zM5.728 11.694a6 6 0 018.546 0M5.727 17.25a3 3 0 017.546 0"/></svg>
                    Opportunités nouvelles
                </a>  --}}

                @can('create', App\Models\Opportunity::class)
                <a href="{{ route('opportunities.create') }}" class="sidebar-link {{ request()->routeIs('opportunities.create') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                    Nouvelle opportunité
                </a>
                @endcan

                @if(auth()->user()->isAdmin())
                <div class="sidebar-section">Clients</div>
                <a href="{{ route('clients.index') }}" class="sidebar-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Tous les clients
                </a>
                
                <div class="sidebar-section">Administration</div>
                <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Utilisateurs
                </a>
                <a href="{{ route('teams.index') }}" class="sidebar-link {{ request()->routeIs('teams.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Équipes
                </a>
                @endif
            </nav>

            {{-- Footer --}}
            <div class="px-5 py-3 border-t border-gray-100 text-xs text-gray-400">
                &copy; {{ date('Y') }} CA CRM
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Bar --}}
            <header class="topbar">
                <div>
                    @if (isset($header))
                        <h2 class="text-xl font-bold text-gray-800">{{ $header }}</h2>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    <span class="badge bg-primary-100 text-primary-700">
                        {{ auth()->user()->role->name ?? 'N/A' }}
                    </span>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-primary-400 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="flash-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="flash-error">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="flash-error">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="px-6 py-3 text-center text-xs text-gray-400 border-t border-gray-100">
                &copy; {{ date('Y') }} CA CRM - Tous droits réservés
            </footer>
        </div>
    </div>
</body>
</html>
