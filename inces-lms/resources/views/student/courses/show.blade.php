@extends('layouts.app')
@section('title', $course->title)
@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Course Header -->
    <div class="card overflow-hidden mb-6">
        <div class="h-48 bg-gradient-to-br from-brand-600 to-blue-500 relative">
            @if($course->thumbnail)
                <img src="{{ $course->thumbnail_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
            @else
                <div class="absolute inset-0 flex items-center justify-center text-8xl opacity-20">📚</div>
            @endif
        </div>
        <div class="p-6">
            @if($course->category)
                <span class="badge bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300 mb-3">{{ $course->category->name }}</span>
            @endif
            <h1 class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">{{ $course->title }}</h1>
            <p class="text-gray-500 mb-4">{{ $course->description }}</p>
            <div class="flex flex-wrap gap-4 text-sm text-gray-400 mb-5">
                <span>👩‍🏫 {{ $course->instructor->name }}</span>
                <span>📊 {{ $course->level_label }}</span>
                <span>⏱️ {{ $course->duration_hours }} horas</span>
                <span>👥 {{ $course->enrolled_count }} inscritos</span>
                <span>📦 {{ $course->modules->count() }} módulos</span>
            </div>
            @if($isEnrolled)
                <a href="{{ route('student.courses.learn', $course) }}" class="btn-primary text-base px-7 py-3">
                    📖 Continuar Aprendiendo
                </a>
            @else
                <form method="POST" action="{{ route('student.courses.enroll', $course) }}" class="inline">
                    @csrf
                    <button type="submit" class="btn-primary text-base px-7 py-3">
                        ✅ Inscribirme Gratis
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Course Content -->
        <div class="lg:col-span-2">
            @if($course->objectives)
            <div class="card p-5 mb-5">
                <h2 class="font-display font-bold text-lg text-gray-900 dark:text-white mb-3">🎯 Objetivos del Curso</h2>
                <div class="text-sm text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $course->objectives }}</div>
            </div>
            @endif

            <div class="card p-5">
                <h2 class="font-display font-bold text-lg text-gray-900 dark:text-white mb-4">📋 Contenido del Curso</h2>
                @foreach($course->modules as $module)
                <div class="border-b border-gray-50 dark:border-gray-700 last:border-b-0 py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 bg-brand-50 dark:bg-brand-900/20 text-brand-600 rounded-md flex items-center justify-center text-xs font-bold">{{ $loop->iteration }}</span>
                            <span class="font-medium text-gray-900 dark:text-white text-sm">{{ $module->title }}</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ $module->resources->count() }} recursos</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <div class="card p-5">
                <h3 class="font-bold text-gray-900 dark:text-white mb-3">👩‍🏫 Instructor</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ $course->instructor->avatar_url }}" class="w-12 h-12 rounded-full" alt="{{ $course->instructor->name }}">
                    <div>
                        <p class="font-semibold text-sm">{{ $course->instructor->name }}</p>
                        @if($course->instructor->bio)
                            <p class="text-xs text-gray-400">{{ Str::limit($course->instructor->bio, 60) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
