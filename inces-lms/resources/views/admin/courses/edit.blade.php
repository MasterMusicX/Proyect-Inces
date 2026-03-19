@extends('layouts.app')
@section('title', 'Editar Curso')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.courses.index') }}" class="text-gray-400 hover:text-gray-600">← Volver</a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Editar Curso</h1>
    </div>
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                    @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                </div>
            @endif
            <div>
                <label class="form-label">Título *</label>
                <input name="title" value="{{ old('title', $course->title) }}" required class="form-input">
            </div>
            <div>
                <label class="form-label">Descripción *</label>
                <textarea name="description" rows="4" required class="form-input">{{ old('description', $course->description) }}</textarea>
            </div>
            <div>
                <label class="form-label">Objetivos</label>
                <textarea name="objectives" rows="3" class="form-input">{{ old('objectives', $course->objectives) }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Instructor *</label>
                    <select name="instructor_id" required class="form-input">
                        @foreach($instructors as $i)
                            <option value="{{ $i->id }}" {{ old('instructor_id', $course->instructor_id) == $i->id ? 'selected' : '' }}>{{ $i->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Categoría</label>
                    <select name="category_id" class="form-input">
                        <option value="">Sin categoría</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ old('category_id', $course->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Nivel</label>
                    <select name="level" class="form-input">
                        @foreach(['beginner' => 'Básico', 'intermediate' => 'Intermedio', 'advanced' => 'Avanzado'] as $v => $l)
                            <option value="{{ $v }}" {{ old('level', $course->level) === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-input">
                        @foreach(['draft' => 'Borrador', 'published' => 'Publicado', 'archived' => 'Archivado'] as $v => $l)
                            <option value="{{ $v }}" {{ old('status', $course->status) === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Duración (horas)</label>
                    <input type="number" name="duration_hours" value="{{ old('duration_hours', $course->duration_hours) }}" min="0" class="form-input">
                </div>
                <div>
                    <label class="form-label">Máximo Estudiantes</label>
                    <input type="number" name="max_students" value="{{ old('max_students', $course->max_students) }}" min="1" class="form-input">
                </div>
            </div>
            @if($course->thumbnail)
                <div>
                    <p class="form-label">Imagen Actual</p>
                    <img src="{{ $course->thumbnail_url }}" class="h-28 object-cover rounded-xl mb-2" alt="{{ $course->title }}">
                </div>
            @endif
            <div>
                <label class="form-label">Nueva Imagen (opcional)</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-input">
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }} id="featured" class="rounded">
                <label for="featured" class="text-sm font-medium">Curso destacado</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">💾 Actualizar Curso</button>
                <a href="{{ route('admin.courses.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
