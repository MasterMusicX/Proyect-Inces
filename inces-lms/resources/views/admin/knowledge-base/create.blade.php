@extends('layouts.app')
@section('title', 'Nueva Entrada KB')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.knowledge-base.index') }}" class="text-gray-400 hover:text-gray-600">← Volver</a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Nueva Entrada de Conocimiento</h1>
    </div>
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.knowledge-base.store') }}" class="space-y-5">
            @csrf
            @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                    @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Categoría *</label>
                    <select name="category" required class="form-input">
                        <option value="faq">FAQ General</option>
                        <option value="cursos">Cursos</option>
                        <option value="plataforma">Plataforma</option>
                        <option value="certificados">Certificados</option>
                        <option value="inces">Sobre el INCES</option>
                        <option value="tecnico">Soporte Técnico</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <div class="flex items-center gap-3 pb-1">
                        <input type="checkbox" name="is_active" value="1" checked id="active" class="rounded">
                        <label for="active" class="font-medium text-sm">Entrada activa</label>
                    </div>
                </div>
            </div>
            <div>
                <label class="form-label">Pregunta *</label>
                <input name="question" value="{{ old('question') }}" required class="form-input"
                    placeholder="Ej: ¿Cómo me inscribo en un curso?">
            </div>
            <div>
                <label class="form-label">Respuesta *</label>
                <textarea name="answer" rows="6" required class="form-input"
                    placeholder="Respuesta detallada que el chatbot dará al estudiante...">{{ old('answer') }}</textarea>
            </div>
            <div>
                <label class="form-label">Tags (separados por coma)</label>
                <input name="tags" value="{{ old('tags') }}" class="form-input" placeholder="inscripción, curso, registro">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">💾 Guardar Entrada</button>
                <a href="{{ route('admin.knowledge-base.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
