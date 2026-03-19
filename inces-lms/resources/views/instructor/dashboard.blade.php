@extends('layouts.app')
@section('title', 'Panel del Instructor')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Mi Panel</h1>
        <p class="text-gray-500">Gestiona tus cursos y materiales educativos</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl">📚</div>
            <div>
                <p class="text-2xl font-display font-bold">{{ $stats['total_courses'] }}</p>
                <p class="text-xs text-gray-500">Mis Cursos</p>
            </div>
        </div>
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-2xl">👥</div>
            <div>
                <p class="text-2xl font-display font-bold">{{ $stats['total_students'] }}</p>
                <p class="text-xs text-gray-500">Estudiantes</p>
            </div>
        </div>
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl">✅</div>
            <div>
                <p class="text-2xl font-display font-bold">{{ $stats['published_courses'] }}</p>
                <p class="text-xs text-gray-500">Publicados</p>
            </div>
        </div>
    </div>

    <!-- Courses List -->
    <div class="card p-6">
        <h2 class="font-display font-bold text-lg text-gray-900 dark:text-white mb-4">Mis Cursos</h2>
        @forelse($courses as $course)
        <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 transition border-b border-gray-50 dark:border-gray-700 last:border-b-0">
            <div class="w-12 h-12 bg-gradient-to-br from-brand-400 to-blue-600 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">📚</div>
            <div class="flex-1">
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $course->title }}</h3>
                <p class="text-xs text-gray-400">{{ $course->enrollments_count }} estudiantes • {{ $course->level_label }}</p>
            </div>
            <span class="badge {{ $course->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $course->status === 'published' ? 'Publicado' : 'Borrador' }}
            </span>
            <a href="{{ route('instructor.courses.resources.index', $course) }}" class="btn-secondary text-sm">
                Recursos →
            </a>
        </div>
        @empty
        <p class="text-gray-400 text-center py-8">No tienes cursos asignados aún.</p>
        @endforelse
    </div>
</div>
@endsection
