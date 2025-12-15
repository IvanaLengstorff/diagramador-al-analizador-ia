<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'UML Colaborativo') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- 🌸 FONDO ROSA PASTEL COMPLETO -->
    <div class="min-h-screen flex items-center justify-center
                bg-gradient-to-br from-pink-100 via-rose-100 to-pink-50 px-4">

        <div class="w-full sm:max-w-md">
            <!-- 💖 CARD DEL LOGIN -->
            <div class="bg-white/90 backdrop-blur-xl
                        border border-pink-200
                        shadow-2xl rounded-3xl px-8 py-10">

                {{ $slot }}

            </div>

            <!-- Footer -->
            <div class="text-center mt-6 text-xs text-pink-500">
                © {{ date('Y') }} UML Colaborativo · Laravel
            </div>
        </div>

    </div>
</body>
</html>
