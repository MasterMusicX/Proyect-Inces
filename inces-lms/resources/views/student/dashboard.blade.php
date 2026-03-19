@extends('layouts.app')
@section('title', 'Mi Panel')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Welcome -->
    <div class="mb-8 p-6 bg-gradient-to-r from-brand-600 to-blue-500 rounded-2xl text-white">
        <div class="flex items-center gap-4">
            <img src="{{ $user->avatar_url }}" class="w-16 h-16 rounded-full border-3 border-white/30" alt="{{ $user->name }}">
            <div>
                <h1 class="text-2xl font-display font-bold">¡Hola, {{ explode(' ', $user->name)[0] }}! 👋</h1>
                <p class="text-blue-100">Continúa con tu formación en INCES</p>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-5 pt-5 border-t border-white/20">
            <div class="text-center">
                <p class="text-2xl font-bold">{{ $enrolledCourses->count() }}</p>
                <p class="text-blue-100 text-xs">Cursos Inscritos</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold">{{ $enrolledCourses->where('pivot.status', 'completed')->count() }}</p>
                <p class="text-blue-100 text-xs">Completados</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold">{{ $enrolledCourses->avg('pivot.progress_percentage') ? round($enrolledCourses->avg('pivot.progress_percentage')) : 0 }}%</p>
                <p class="text-blue-100 text-xs">Progreso Promedio</p>
            </div>
        </div>
    </div>

    <!-- Enrolled Courses -->
    @if($enrolledCourses->count() > 0)
    <div class="mb-8">
        <h2 class="text-xl font-display font-bold text-gray-900 dark:text-white mb-4">Mis Cursos</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($enrolledCourses as $course)
            <div class="card overflow-hidden hover:shadow-md transition-shadow">
                <div class="h-36 bg-gradient-to-br from-brand-400 to-brand-600 relative overflow-hidden">
                    @if($course->thumbnail)
                        <img src="{{ $course->thumbnail_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-6xl opacity-30">📚</div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1 line-clamp-2">{{ $course->title }}</h3>
                    <p class="text-xs text-gray-400 mb-3">{{ $course->instructor->name }}</p>
                    <!-- Progress bar -->
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-gray-400 mb-1">
                            <span>Progreso</span>
                            <span>{{ $course->pivot->progress_percentage }}%</span>
                        </div>
                        <div class="h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-brand-500 rounded-full transition-all"
                                style="width: {{ $course->pivot->progress_percentage }}%"></div>
                        </div>
                    </div>
                    <a href="{{ route('student.courses.learn', $course) }}"
                        class="block text-center py-2 bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold rounded-xl transition">
                        Continuar →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Featured Courses -->
    @if($featuredCourses->count() > 0)
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-display font-bold text-gray-900 dark:text-white">Cursos Destacados</h2>
            <a href="{{ route('student.courses.catalog') }}" class="text-brand-500 text-sm font-semibold hover:underline">Ver catálogo →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($featuredCourses as $course)
            <div class="card overflow-hidden hover:shadow-md transition-shadow">
                <div class="h-32 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-5xl">📚</div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1">{{ $course->title }}</h3>
                    <p class="text-xs text-gray-400 mb-3">{{ $course->instructor->name }} • {{ $course->enrollments_count }} estudiantes</p>
                    <a href="{{ route('student.courses.show', $course) }}"
                        class="block text-center py-2 border-2 border-brand-500 text-brand-500 hover:bg-brand-50 text-xs font-bold rounded-xl transition">
                        Ver Curso
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
