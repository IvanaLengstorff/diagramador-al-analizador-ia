<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Diagramador UML') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/uml-editor.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gradient-to-br from-pink-50 via-rose-50 to-pink-100 text-pink-950">
<div class="min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white/70 backdrop-blur border-b border-pink-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-10">

                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('diagrams.index') }}" class="flex items-center gap-3">
                            <!-- Icono "logo" -->
                            <div class="w-9 h-9 rounded-xl bg-pink-100 border border-pink-200 flex items-center justify-center">
                                <svg class="w-5 h-5 text-pink-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M4 19h16v2H4v-2zM6 10h3v7H6v-7zm5-4h3v11h-3V6zm5 2h3v9h-3V8z"/>
                                </svg>
                            </div>
                            <span class="text-xl font-bold text-pink-950">UML Designer</span>
                        </a>
                    </div>

                    <!-- Primary Navigation Menu -->
                    <div class="hidden sm:flex items-center gap-8">
                        <a href="{{ route('diagrams.index') }}"
                           class="inline-flex items-center gap-2 px-1 pt-1 border-b-2 text-sm font-medium
                           {{ request()->routeIs('diagrams.index') ? 'border-pink-500 text-pink-950' : 'border-transparent text-pink-700 hover:text-pink-900 hover:border-pink-300' }}
                           transition">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                            </svg>
                            Mis Diagramas
                        </a>

                        <a href="{{ route('diagrams.editor') }}"
                           class="inline-flex items-center gap-2 px-1 pt-1 border-b-2 text-sm font-medium
                           {{ request()->routeIs('diagrams.editor') ? 'border-pink-500 text-pink-950' : 'border-transparent text-pink-700 hover:text-pink-900 hover:border-pink-300' }}
                           transition">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M11 5h2v14h-2V5zm-6 6h14v2H5v-2z"/>
                            </svg>
                            Nuevo Diagrama
                        </a>
                    </div>
                </div>

                <!-- Right side -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="ml-3 relative">
                        <div class="flex items-center gap-4">
                            <span class="text-pink-800 text-sm">{{ Auth::user()->name }}</span>

                            <!-- Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-pink-200 transition">
                                    <div class="w-9 h-9 bg-pink-100 border border-pink-200 rounded-full flex items-center justify-center">
                                        <span class="text-pink-800 text-sm font-semibold">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                </button>

                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black/5 z-50">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-pink-800 hover:bg-pink-50">Perfil</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-pink-800 hover:bg-pink-50">Configuración</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                    class="block w-full text-left px-4 py-2 text-sm text-pink-800 hover:bg-pink-50">
                                                Cerrar sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hamburger (mobile) -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button class="inline-flex items-center justify-center p-2 rounded-md text-pink-700 hover:text-pink-900 hover:bg-pink-50 focus:outline-none focus:bg-pink-50 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white/50 backdrop-blur border-b border-pink-200 shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

</div>

{{-- Flash Messages --}}
@if (session('success'))
    <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg z-50"
         x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transform transition-all duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transform transition-all duration-300"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0">
        <div class="flex items-center space-x-2">
            <span class="text-lg">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="fixed bottom-4 right-4 bg-rose-600 text-white px-6 py-3 rounded-xl shadow-lg z-50"
         x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transform transition-all duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transform transition-all duration-300"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0">
        <div class="flex items-center space-x-2">
            <span class="text-lg">❌</span>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

@livewireScripts
</body>
</html>
