@extends('layouts.app')
@section('title', 'Módulos - ' . $course->title)
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('instructor.courses.show', $course) }}" class="text-gray-400 text-sm hover:text-gray-600">← Volver al curso</a>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Módulos del Curso</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Modules List -->
        <div class="lg:col-span-2 space-y-3">
            @forelse($modules as $module)
            <div class="card p-4 flex items-center gap-4">
                <span class="w-9 h-9 bg-brand-100 dark:bg-brand-900/30 text-brand-700 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0">{{ $loop->iteration }}</span>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $module->title }}</p>
                    @if($module->description)<p class="text-xs text-gray-400">{{ Str::limit($module->description, 60) }}</p>@endif
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs text-gray-400">{{ $module->resources_count }} recursos</span>
                        <span class="badge {{ $module->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs">{{ $module->is_published ? 'Publicado' : 'Borrador' }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('instructor.courses.modules.destroy', [$course, $module]) }}"
                    onsubmit="return confirm('¿Eliminar módulo?')">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:text-red-600 text-sm">✕</button>
                </form>
            </div>
            @empty
            <div class="card p-8 text-center text-gray-400">Sin módulos creados.</div>
            @endforelse
        </div>

        <!-- Create Module Form -->
        <div class="card p-5">
            <h2 class="font-display font-bold text-lg text-gray-900 dark:text-white mb-4">➕ Nuevo Módulo</h2>
            <form method="POST" action="{{ route('instructor.courses.modules.store', $course) }}" class="space-y-4">
                @csrf
                @if($errors->any())<div class="p-2 bg-red-50 rounded text-red-600 text-xs">{{ $errors->first() }}</div>@endif
                <div>
                    <label class="form-label">Título *</label>
                    <input name="title" required class="form-input" placeholder="Ej: Unidad 1: Introducción">
                </div>
                <div>
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="2" class="form-input"></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" checked id="pub" class="rounded">
                    <label for="pub" class="text-sm font-medium">Publicar ahora</label>
                </div>
                <button type="submit" class="btn-primary w-full">💾 Crear Módulo</button>
            </form>
        </div>
    </div>
</div>
@endsection
