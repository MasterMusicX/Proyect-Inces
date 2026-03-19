@extends('layouts.app')
@section('title', $course->title)
@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('instructor.courses.index') }}" class="text-gray-400 hover:text-gray-600">← Mis Cursos</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white">{{ $course->title }}</h1>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @foreach([['🎓', 'Estudiantes', $stats['students']], ['📦', 'Módulos', $stats['modules']], ['📄', 'Recursos', $stats['resources']], ['✅', 'Completaron', $stats['completed']]] as [$icon, $label, $value])
        <div class="card p-4 text-center">
            <div class="text-3xl mb-1">{{ $icon }}</div>
            <p class="text-2xl font-display font-bold text-gray-900 dark:text-white">{{ $value }}</p>
            <p class="text-xs text-gray-400">{{ $label }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Students -->
        <div class="card p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-display font-bold text-gray-900 dark:text-white">Estudiantes Recientes</h2>
                <a href="{{ route('instructor.courses.students', $course) }}" class="text-brand-500 text-sm hover:underline">Ver todos →</a>
            </div>
            @forelse($students as $student)
            <div class="flex items-center gap-3 py-2.5 border-b border-gray-50 dark:border-gray-700 last:border-b-0">
                <img src="{{ $student->avatar_url }}" class="w-8 h-8 rounded-full" alt="{{ $student->name }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $student->name }}</p>
                </div>
                <div class="text-xs text-right">
                    <p class="font-bold text-brand-600">{{ $student->pivot->progress_percentage }}%</p>
                    <div class="w-16 h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full mt-0.5">
                        <div class="h-full bg-brand-500 rounded-full" style="width:{{ $student->pivot->progress_percentage }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm py-4 text-center">Sin estudiantes inscritos aún.</p>
            @endforelse
        </div>

        <!-- Modules overview -->
        <div class="card p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-display font-bold text-gray-900 dark:text-white">Módulos</h2>
                <a href="{{ route('instructor.courses.modules', $course) }}" class="text-brand-500 text-sm hover:underline">Gestionar →</a>
            </div>
            @forelse($course->modules as $module)
            <div class="flex items-center gap-3 py-2.5 border-b border-gray-50 dark:border-gray-700 last:border-b-0">
                <span class="w-7 h-7 bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400 rounded-lg flex items-center justify-center text-xs font-bold">{{ $loop->iteration }}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $module->title }}</p>
                    <p class="text-xs text-gray-400">{{ $module->resources->count() }} recursos</p>
                </div>
                <span class="badge {{ $module->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs">
                    {{ $module->is_published ? '✓' : 'Borrador' }}
                </span>
            </div>
            @empty
            <p class="text-gray-400 text-sm py-4 text-center">Sin módulos creados.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
