@extends('layouts.app')
@section('title', 'Gestión de Cursos')
@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Cursos</h1>
            <p class="text-gray-500 text-sm">{{ $courses->total() }} cursos en total</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn-primary">➕ Nuevo Curso</a>
    </div>

    <div class="card p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar curso..." class="form-input flex-1 min-w-48">
            <select name="status" class="form-input w-40">
                <option value="">Todos</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publicados</option>
                <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Borradores</option>
                <option value="archived"  {{ request('status') === 'archived'  ? 'selected' : '' }}>Archivados</option>
            </select>
            <button type="submit" class="btn-primary">🔍 Filtrar</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($courses as $course)
        <div class="card overflow-hidden hover:shadow-md transition-shadow">
            <div class="h-36 bg-gradient-to-br from-brand-500 to-blue-600 relative">
                @if($course->thumbnail)
                    <img src="{{ $course->thumbnail_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-6xl opacity-20">📚</div>
                @endif
                <span class="absolute top-2 right-2 badge {{ $course->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $course->status === 'published' ? 'Publicado' : 'Borrador' }}
                </span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1 line-clamp-2">{{ $course->title }}</h3>
                <p class="text-xs text-gray-400 mb-3">{{ $course->instructor->name }} • {{ $course->enrollments_count }} inscritos</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="flex-1 text-center py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-600 text-xs font-semibold rounded-lg transition">Editar</a>
                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('¿Eliminar este curso?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg transition">🗑️</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full card p-12 text-center"><p class="text-gray-400">No hay cursos registrados.</p></div>
        @endforelse
    </div>
    <div class="mt-6">{{ $courses->links() }}</div>
</div>
@endsection
