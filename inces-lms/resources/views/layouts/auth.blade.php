<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Acceso') — INCES LMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Lexend', 'sans-serif'],
                    },
                    colors: {
                        brand: { 500: '#005A9E', 600: '#004d8a', 700: '#003d70' }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .font-display { font-family: 'Lexend', sans-serif; }
        .form-input { @apply block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition text-sm; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-brand-700 via-brand-500 to-blue-400 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-xl mb-4">
                <span class="text-4xl">🎓</span>
            </div>
            <h1 class="font-display text-3xl font-bold text-white">INCES LMS</h1>
            <p class="text-blue-100 text-sm mt-1">Plataforma de Aprendizaje en Línea</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            @yield('content')
        </div>

        <p class="text-center text-blue-100 text-xs mt-6">
            © {{ date('Y') }} INCES — Instituto Nacional de Capacitación y Educación Socialista
        </p>
    </div>
</body>
</html>
