@extends('layouts.app')
@section('title', 'Catálogo de Cursos')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Catálogo de Cursos</h1>
        <p class="text-gray-500 text-sm">{{ $courses->total() }} cursos disponibles</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($courses as $course)
        <div class="card overflow-hidden hover:shadow-lg transition-shadow group">
            <div class="h-40 bg-gradient-to-br from-brand-400 to-blue-600 relative overflow-hidden">
                @if($course->thumbnail)
                    <img src="{{ $course->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $course->title }}">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-7xl opacity-20">📚</div>
                @endif
                <div class="absolute top-3 right-3">
                    <span class="badge bg-white/90 text-gray-700 text-xs font-semibold">
                        {{ $course->level_label }}
                    </span>
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1 line-clamp-2">{{ $course->title }}</h3>
                <p class="text-xs text-gray-400 mb-3 line-clamp-2">{{ $course->description }}</p>
                <div class="flex items-center justify-between text-xs text-gray-400 mb-3">
                    <span>👩‍🏫 {{ Str::limit($course->instructor->name, 20) }}</span>
                    <span>👥 {{ $course->enrollments_count }}</span>
                </div>
                <a href="{{ route('student.courses.show', $course) }}"
                    class="block text-center py-2 bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold rounded-xl transition">
                    Ver Curso
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full card p-12 text-center">
            <div class="text-5xl mb-4">📚</div>
            <p class="text-gray-400">No hay cursos disponibles en este momento.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $courses->links() }}</div>
</div>
@endsection
