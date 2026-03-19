@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-6">Categorías de Cursos</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- List -->
        <div class="lg:col-span-2 card overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Categoría</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Cursos</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <span class="w-4 h-4 rounded-full flex-shrink-0" style="background-color: {{ $cat->color }}"></span>
                                <div>
                                    <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $cat->name }}</p>
                                    @if($cat->description)<p class="text-xs text-gray-400">{{ Str::limit($cat->description, 50) }}</p>@endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-500">{{ $cat->courses_count }}</td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                onsubmit="return confirm('¿Eliminar categoría?')" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600 text-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-8 text-center text-gray-400">Sin categorías creadas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Create Form -->
        <div class="card p-5">
            <h2 class="font-display font-bold text-lg text-gray-900 dark:text-white mb-4">➕ Nueva Categoría</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                @csrf
                @if($errors->any())
                    <div class="p-2 bg-red-50 rounded text-red-600 text-xs">{{ $errors->first() }}</div>
                @endif
                <div>
                    <label class="form-label">Nombre *</label>
                    <input name="name" value="{{ old('name') }}" required class="form-input" placeholder="Ej: Tecnología">
                </div>
                <div>
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="2" class="form-input" placeholder="Descripción opcional...">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Color</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" value="{{ old('color', '#005A9E') }}"
                            class="h-10 w-16 rounded-lg border border-gray-200 cursor-pointer p-1">
                        <span class="text-sm text-gray-400">Selecciona un color representativo</span>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full">💾 Crear Categoría</button>
            </form>
        </div>
    </div>
</div>
@endsection
