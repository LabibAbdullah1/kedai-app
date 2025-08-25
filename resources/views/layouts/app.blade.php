<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kedai App</title>

    {{-- Vite untuk Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tambahan Font & Icon --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
</head>

<body class="bg-gray-100 font-inter text-gray-900">

    {{-- Navbar --}}
    @include('layouts.navigation')

    {{-- Kontainer Utama --}}
    <div class="flex flex-col min-h-screen">

        {{-- Konten Utama --}}
        <main class="flex-1 p-4 sm:p-6 md:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        {{-- Footer --}}
        <footer class="bg-white shadow-md mt-6">
            <div
                class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} Kedai-App. All Rights Reserved.</p>
                <p class="text-gray-500 text-sm">Versi 1.0</p>
            </div>
        </footer>
    </div>

    {{-- Script Icon --}}
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
