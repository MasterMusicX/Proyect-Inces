@extends('layouts.app')
@section('title', 'Nuevo Curso')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.courses.index') }}" class="text-gray-400 hover:text-gray-600">← Volver</a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Nuevo Curso</h1>
    </div>
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                    @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                </div>
            @endif
            <div>
                <label class="form-label">Título del Curso *</label>
                <input name="title" value="{{ old('title') }}" required class="form-input" placeholder="Ej: Administración de Empresas Básico">
            </div>
            <div>
                <label class="form-label">Descripción *</label>
                <textarea name="description" rows="4" required class="form-input" placeholder="Descripción del curso...">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="form-label">Objetivos del Curso</label>
                <textarea name="objectives" rows="3" class="form-input" placeholder="Al finalizar el curso el participante será capaz de...">{{ old('objectives') }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Instructor *</label>
                    <select name="instructor_id" required class="form-input">
                        <option value="">Seleccionar...</option>
                        @foreach($instructors as $i)
                            <option value="{{ $i->id }}" {{ old('instructor_id') == $i->id ? 'selected' : '' }}>{{ $i->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Categoría</label>
                    <select name="category_id" class="form-input">
                        <option value="">Sin categoría</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Nivel</label>
                    <select name="level" class="form-input">
                        <option value="beginner"     {{ old('level') === 'beginner'     ? 'selected' : '' }}>Básico</option>
                        <option value="intermediate" {{ old('level') === 'intermediate' ? 'selected' : '' }}>Intermedio</option>
                        <option value="advanced"     {{ old('level') === 'advanced'     ? 'selected' : '' }}>Avanzado</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-input">
                        <option value="draft"     {{ old('status') === 'draft'     ? 'selected' : '' }}>Borrador</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                        <option value="archived"  {{ old('status') === 'archived'  ? 'selected' : '' }}>Archivado</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Duración (horas)</label>
                    <input type="number" name="duration_hours" value="{{ old('duration_hours', 0) }}" min="0" class="form-input">
                </div>
                <div>
                    <label class="form-label">Máximo Estudiantes (vacío = ilimitado)</label>
                    <input type="number" name="max_students" value="{{ old('max_students') }}" min="1" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Imagen Portada</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-input">
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} id="featured" class="rounded border-gray-300">
                <label for="featured" class="text-sm text-gray-700 dark:text-gray-300 font-medium">Marcar como curso destacado</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">💾 Crear Curso</button>
                <a href="{{ route('admin.courses.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
