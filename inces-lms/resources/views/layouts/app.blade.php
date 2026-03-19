<!DOCTYPE html>
<html lang="es" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'INCES LMS') — INCES LMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans:    ['Inter', 'sans-serif'],
                        display: ['Lexend', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            500: '#005A9E',
                            600: '#004d8a',
                            700: '#003d70',
                            800: '#002d56',
                            900: '#001e3c',
                        },
                    },
                },
            },
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Lexend', sans-serif; }
        .sidebar-item { @apply flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200; }
        .sidebar-item:hover { @apply bg-white/10 text-white; }
        .sidebar-item.active { @apply bg-white text-brand-700 shadow-sm; }
        .card { @apply bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700; }
        .btn-primary { @apply inline-flex items-center gap-2 px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-sm; }
        .btn-secondary { @apply inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-xl transition-all duration-200; }
        .btn-danger { @apply inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl transition-all duration-200; }
        .form-input { @apply block w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition; }
        .form-label { @apply block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5; }
        .badge { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold; }
    </style>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top navbar -->
        @include('components.navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div x-data="{show:true}" x-show="show" x-transition
                    class="mb-6 flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-xl">
                    <span class="text-lg">✅</span>
                    <span class="flex-1 text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show=false" class="text-green-500 hover:text-green-700">✕</button>
                </div>
            @endif
            @if (session('error'))
                <div x-data="{show:true}" x-show="show" x-transition
                    class="mb-6 flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-xl">
                    <span class="text-lg">❌</span>
                    <span class="flex-1 text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show=false" class="text-red-500 hover:text-red-700">✕</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
