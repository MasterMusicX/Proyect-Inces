@extends('layouts.app')
@section('title', 'Mis Cursos')
@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Mis Cursos</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($courses as $course)
        <div class="card overflow-hidden hover:shadow-md transition-shadow">
            <div class="h-32 bg-gradient-to-br from-brand-500 to-blue-600 relative">
                @if($course->thumbnail)
                    <img src="{{ $course->thumbnail_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                @endif
                <span class="absolute top-2 right-2 badge {{ $course->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $course->status === 'published' ? 'Publicado' : 'Borrador' }}
                </span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $course->title }}</h3>
                <div class="flex gap-3 text-xs text-gray-400 mb-3">
                    <span>👥 {{ $course->enrollments_count }}</span>
                    <span>📦 {{ $course->modules_count }} módulos</span>
                    <span>📄 {{ $course->resources_count }} recursos</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('instructor.courses.show', $course) }}"
                        class="flex-1 text-center py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-600 text-xs font-semibold rounded-lg transition">Ver Detalle</a>
                    <a href="{{ route('instructor.courses.resources.index', $course) }}"
                        class="flex-1 text-center py-1.5 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-semibold rounded-lg transition">Recursos</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full card p-12 text-center">
            <div class="text-5xl mb-4">📭</div>
            <p class="text-gray-400">No tienes cursos asignados aún.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
