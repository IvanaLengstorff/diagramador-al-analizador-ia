<x-guest-layout>
    <!-- Título de bienvenida -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-pink-700">¡Bienvenido de nuevo!</h2>
        <p class="text-sm text-pink-600 mt-2">
            Accede a tus diagramas UML colaborativos
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-pink-600" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label
                for="email"
                :value="__('Correo Electrónico')"
                class="text-pink-700"
            />

            <x-text-input
                id="email"
                class="block mt-1 w-full rounded-lg border-pink-200 focus:border-pink-400 focus:ring-pink-400"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="tu@email.com"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-pink-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label
                for="password"
                :value="__('Contraseña')"
                class="text-pink-700"
            />

            <x-text-input
                id="password"
                class="block mt-1 w-full rounded-lg border-pink-200 focus:border-pink-400 focus:ring-pink-400"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-pink-600" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-pink-300 text-pink-500 shadow-sm focus:ring-pink-400"
                    name="remember"
                >
                <span class="ms-2 text-sm text-pink-600">
                    {{ __('Recordarme') }}
                </span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a
                    class="underline text-sm text-pink-600 hover:text-pink-700 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400"
                    href="{{ route('password.request') }}"
                >
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-pink-500 hover:bg-pink-600 focus:bg-pink-600 active:bg-pink-700">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>

        <!-- Separador -->
        <div class="mt-6 text-center">
            <span class="text-sm text-pink-600">
                ¿No tienes cuenta?
            </span>

            <a
                href="{{ route('register') }}"
                class="text-sm text-pink-700 hover:text-pink-800 font-medium ml-1"
            >
                Regístrate aquí
            </a>
        </div>
    </form>
</x-guest-layout>
