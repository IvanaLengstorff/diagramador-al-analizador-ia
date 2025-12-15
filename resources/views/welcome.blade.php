<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Diagramador UML Colaborativo</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-pink-950">
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-rose-50 to-pink-100">

    <!-- NAV -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="rounded-2xl bg-white/60 border border-pink-200 shadow-sm px-4 py-2">
                    <svg class="h-12 w-auto" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="bgGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#ffffff;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#fff1f2;stop-opacity:1" />
                            </linearGradient>

                            <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="2" dy="2" stdDeviation="3" flood-color="#000000" flood-opacity="0.15"/>
                            </filter>
                        </defs>

                        <rect width="200" height="80" rx="12" ry="12" fill="url(#bgGradient)" filter="url(#shadow)"/>

                        <g transform="translate(15, 15)">
                            <rect x="0" y="0" width="25" height="18" fill="white" stroke="#ec4899" stroke-width="1.5" rx="2"/>
                            <line x1="0" y1="6" x2="25" y2="6" stroke="#ec4899" stroke-width="1"/>
                            <line x1="0" y1="12" x2="25" y2="12" stroke="#ec4899" stroke-width="1"/>

                            <rect x="40" y="25" width="25" height="18" fill="white" stroke="#ec4899" stroke-width="1.5" rx="2"/>
                            <line x1="40" y1="31" x2="65" y2="31" stroke="#ec4899" stroke-width="1"/>
                            <line x1="40" y1="37" x2="65" y2="37" stroke="#ec4899" stroke-width="1"/>

                            <rect x="80" y="5" width="25" height="18" fill="white" stroke="#ec4899" stroke-width="1.5" rx="2"/>
                            <line x1="80" y1="11" x2="105" y2="11" stroke="#ec4899" stroke-width="1"/>
                            <line x1="80" y1="17" x2="105" y2="17" stroke="#ec4899" stroke-width="1"/>

                            <line x1="25" y1="9" x2="40" y2="34" stroke="#fb7185" stroke-width="2" opacity="0.8"/>
                            <line x1="65" y1="34" x2="80" y2="14" stroke="#fb7185" stroke-width="2" opacity="0.8"/>
                            <line x1="25" y1="9" x2="80" y2="14" stroke="#fb7185" stroke-width="2" opacity="0.8"/>

                            <circle cx="32.5" cy="21.5" r="3" fill="#fb7185" opacity="0.9"/>
                            <circle cx="72.5" cy="19.5" r="3" fill="#fb7185" opacity="0.9"/>
                            <circle cx="52.5" cy="11.5" r="3" fill="#fb7185" opacity="0.9"/>
                        </g>

                        <text x="125" y="30" font-family="Arial, sans-serif" font-size="16" font-weight="bold" fill="#881337">UML</text>
                        <text x="125" y="48" font-family="Arial, sans-serif" font-size="12" fill="#9d174d" opacity="0.95">Colaborativo</text>
                    </svg>
                </div>
            </div>

            <!-- Links -->
            @if (Route::has('login'))
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/diagrams') }}"
                           class="px-4 py-2 rounded-xl bg-white/70 border border-pink-200 shadow-sm
                                  text-pink-800 hover:bg-white transition">
                            Mis Diagramas
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 rounded-xl bg-white/70 border border-pink-200 shadow-sm
                                  text-pink-800 hover:bg-white transition">
                            Iniciar Sesión
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 rounded-xl bg-pink-500 text-white shadow-sm
                                      hover:bg-pink-600 transition">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <!-- HERO -->
        <div class="mt-10 text-center">
            <h1 class="text-4xl font-bold text-pink-900">
                Diagramador UML Colaborativo
            </h1>
            <p class="mt-3 text-pink-700">
                Diseñá · Colaborá · Exportá · Generá Código
            </p>
        </div>

        <!-- CARDS -->
        <div class="mt-12 grid gap-6 lg:grid-cols-2 lg:items-start">

            <!-- Card grande (izquierda) -->
            <div class="rounded-3xl bg-pink-200/60 border border-pink-300 shadow-xl overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-semibold text-pink-900">Editor UML Avanzado</h2>
                    <p class="mt-3 text-pink-800">
                        Crea diagramas de clases UML de forma intuitiva. Soporte completo para asociaciones,
                        herencia, composición y agregación.
                    </p>

                    <!-- “Imagen” reemplazada por un mock más lindo -->
                    <div class="mt-6 rounded-2xl bg-pink-50/80 border border-pink-300 p-6 shadow-inner">
                        <div class="text-sm font-semibold text-pink-900 mb-3">Vista previa</div>

                        <div class="rounded-2xl bg-white/60 border border-pink-200 p-6">
                            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                                <div class="w-56 rounded-xl bg-white border border-pink-300 p-4 shadow-sm">
                                    <div class="font-bold text-pink-800 mb-2 text-center">User</div>
                                    <div class="text-xs text-pink-900">+ name: String</div>
                                    <div class="text-xs text-pink-900">+ email: String</div>
                                </div>

                                <div class="w-56 rounded-xl bg-white border border-pink-300 p-4 shadow-sm">
                                    <div class="font-bold text-pink-800 mb-2 text-center">Post</div>
                                    <div class="text-xs text-pink-900">+ title: String</div>
                                    <div class="text-xs text-pink-900">+ content: String</div>
                                </div>
                            </div>

                            <div class="mt-5 text-center text-xs text-pink-700">
                                User <span class="font-semibold">writes</span> → Post
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards derechas (se mantienen alineadas y apiladas) -->
            <div class="grid gap-6">
                <div class="rounded-3xl bg-white/70 border border-pink-200 shadow-xl p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-pink-900">Colaboración en Tiempo Real</h3>
                            <p class="mt-2 text-pink-800">
                                Trabaja en equipo sincronizado. Ve cambios en vivo, comparte diagramas con enlaces seguros.
                            </p>
                        </div>
                        <div class="shrink-0 w-12 h-12 rounded-2xl bg-pink-500 text-white flex items-center justify-center shadow-sm">
                            ✓
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white/70 border border-pink-200 shadow-xl p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-pink-900">Generación de Código</h3>
                            <p class="mt-2 text-pink-800">
                                Convierte diagramas a Spring Boot: modelos, repositorios, servicios y controladores.
                            </p>
                        </div>
                        <div class="shrink-0 w-12 h-12 rounded-2xl bg-rose-500 text-white flex items-center justify-center shadow-sm">
                            &lt;/&gt;
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white/70 border border-pink-200 shadow-xl p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-pink-900">Exportación Profesional</h3>
                            <p class="mt-2 text-pink-800">
                                Exporta en PNG, XMI y más. Integración perfecta con tu flujo de trabajo.
                            </p>
                        </div>
                        <div class="shrink-0 w-12 h-12 rounded-2xl bg-fuchsia-500 text-white flex items-center justify-center shadow-sm">
                            ⇩
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- FOOTER -->
        <footer class="py-14 text-center text-sm text-pink-700">
            Diagramador UML Colaborativo
        </footer>
    </div>
</div>
</body>
</html>
