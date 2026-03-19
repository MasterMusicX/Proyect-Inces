@extends('layouts.app')
@section('title', 'Panel Administrativo')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white">Panel de Administración</h1>
        <p class="text-gray-500 mt-1">Gestión completa de la plataforma INCES LMS</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 mb-8">
        @php
        $statCards = [
            ['icon' => '🎓', 'label' => 'Estudiantes',     'value' => $stats['total_users'],       'color' => 'bg-blue-50 text-blue-600'],
            ['icon' => '👩‍🏫', 'label' => 'Instructores',    'value' => $stats['total_instructors'], 'color' => 'bg-purple-50 text-purple-600'],
            ['icon' => '📚', 'label' => 'Cursos',           'value' => $stats['total_courses'],     'color' => 'bg-green-50 text-green-600'],
            ['icon' => '📄', 'label' => 'Recursos',         'value' => $stats['total_resources'],   'color' => 'bg-orange-50 text-orange-600'],
            ['icon' => '✅', 'label' => 'Inscripciones',    'value' => $stats['total_enrollments'], 'color' => 'bg-teal-50 text-teal-600'],
            ['icon' => '🤖', 'label' => 'Consultas IA',     'value' => $stats['total_ai_queries'],  'color' => 'bg-pink-50 text-pink-600'],
        ];
        @endphp

        @foreach($statCards as $card)
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl {{ $card['color'] }} flex items-center justify-center flex-shrink-0 text-2xl">
                {{ $card['icon'] }}
            </div>
            <div>
                <p class="text-2xl font-display font-bold text-gray-900 dark:text-white">{{ number_format($card['value']) }}</p>
                <p class="text-xs text-gray-500">{{ $card['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-display font-bold text-lg text-gray-900 dark:text-white">Usuarios Recientes</h2>
                <a href="{{ route('admin.users.index') }}" class="text-brand-500 text-sm font-semibold hover:underline">Ver todos →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full" alt="{{ $user->name }}">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-gray-800 dark:text-gray-200 truncate">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                    </div>
                    <span class="badge {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : ($user->role === 'instructor' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Popular Courses -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-display font-bold text-lg text-gray-900 dark:text-white">Cursos Más Populares</h2>
                <a href="{{ route('admin.courses.index') }}" class="text-brand-500 text-sm font-semibold hover:underline">Ver todos →</a>
            </div>
            <div class="space-y-3">
                @foreach($popularCourses as $i => $course)
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <div class="w-8 h-8 rounded-xl bg-brand-100 dark:bg-brand-900/30 text-brand-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-gray-800 dark:text-gray-200 truncate">{{ $course->title }}</p>
                        <p class="text-xs text-gray-400">{{ $course->instructor->name }}</p>
                    </div>
                    <span class="text-xs font-bold text-gray-600 dark:text-gray-300">{{ $course->enrollments_count }} 👥</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
