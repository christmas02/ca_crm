<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Identification --}}
        <div>
            <label for="identification" class="form-label">Identification</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <input id="identification" type="text" name="identification" value="{{ old('identification') }}" required autofocus autocomplete="username"
                    placeholder="Votre identifiant"
                    class="block w-full pl-10 rounded-lg border-gray-200 shadow-sm text-sm focus:border-primary-400 focus:ring-primary-400">
            </div>
            <x-input-error :messages="$errors->get('identification')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-5">
            <div class="flex items-center justify-between">
                <label for="password" class="form-label">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-primary-400 hover:text-primary-500 font-medium" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="Entrez votre mot de passe"
                    class="block w-full pl-10 rounded-lg border-gray-200 shadow-sm text-sm focus:border-primary-400 focus:ring-primary-400">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember --}}
        <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary-400 shadow-sm focus:ring-primary-400" name="remember">
                <span class="ml-2 text-sm text-gray-600">Garder ma session active</span>
            </label>
        </div>

        {{-- Submit --}}
        <div class="mt-6">
            <button type="submit" class="w-full btn-primary justify-center py-3 text-base rounded-xl">
                Se connecter
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </form>
</x-guest-layout>
