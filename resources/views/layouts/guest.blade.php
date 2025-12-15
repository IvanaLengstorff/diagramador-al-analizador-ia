<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UML Colaborativo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen flex items-center justify-center
           bg-gradient-to-br from-pink-100 via-rose-50 to-pink-100">

    <div class="w-full max-w-md px-6">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <x-application-logo class="h-14 w-auto" />
        </div>

        <!-- CARD DEL LOGIN -->
        <div
            class="
                bg-pink-200
                border border-pink-300
                rounded-3xl
                shadow-xl
                px-8 py-10
            "
        >
            {{ $slot }}
        </div>

        <!-- Footer -->
        <p class="mt-6 text-center text-sm text-pink-600">
            © 2025 UML Colaborativo · Laravel
        </p>

    </div>

</body>
</html>
