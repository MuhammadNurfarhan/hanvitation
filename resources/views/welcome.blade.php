<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanvitation - Digital Wedding Invitation Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-stone-50 text-stone-800 font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center">
        <x-application-logo class="w-24 h-24 text-red-900 mb-6" />
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-red-900 mb-4">Hanvitation</h1>
        <p class="text-lg text-stone-600 max-w-xl mb-8">Platform undangan pernikahan digital yang elegan, sakral, dan modern untuk momen terindah Anda.</p>

        <div class="flex gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-red-900 text-white rounded-xl font-medium shadow-lg hover:bg-red-800 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-red-900 text-white rounded-xl font-medium shadow-lg hover:bg-red-800 transition">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-red-900 border-2 border-red-900 rounded-xl font-medium hover:bg-red-50 transition">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <footer class="mt-12 text-sm text-stone-400">
            &copy; {{ date('Y') }} Hanvitation. Made with ♥ for Wedding.
        </footer>
    </div>
</body>
</html>
