@extends('layouts.app')
@section('title', 'Base de Conocimiento IA')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Base de Conocimiento IA</h1>
            <p class="text-gray-500 text-sm">El chatbot consulta esta base para responder preguntas frecuentes</p>
        </div>
        <a href="{{ route('admin.knowledge-base.create') }}" class="btn-primary">➕ Nueva Entrada</a>
    </div>

    <!-- Filters -->
    <div class="card p-4 mb-5">
        <form method="GET" class="flex flex-wrap gap-3">
            <input name="search" value="{{ request('search') }}" placeholder="Buscar pregunta..." class="form-input flex-1">
            <select name="category" class="form-input w-44">
                <option value="">Todas las categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary">🔍</button>
            <a href="{{ route('admin.knowledge-base.index') }}" class="btn-secondary">Limpiar</a>
        </form>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Pregunta</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Categoría</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Vistas</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Estado</th>
                    <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                @forelse($entries as $entry)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20">
                    <td class="px-5 py-4">
                        <p class="font-medium text-sm text-gray-900 dark:text-white">{{ Str::limit($entry->question, 70) }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($entry->answer, 80) }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <span class="badge bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">{{ $entry->category }}</span>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500">{{ $entry->views }}</td>
                    <td class="px-5 py-4">
                        <span class="badge {{ $entry->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $entry->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.knowledge-base.edit', $entry) }}" class="text-brand-500 hover:text-brand-700 text-sm font-medium">Editar</a>
                            <form method="POST" action="{{ route('admin.knowledge-base.destroy', $entry) }}" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600 text-sm">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Sin entradas en la base de conocimiento.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">{{ $entries->links() }}</div>
    </div>
</div>
@endsection
