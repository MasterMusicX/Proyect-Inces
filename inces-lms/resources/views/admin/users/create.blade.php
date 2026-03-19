@extends('layouts.app')
@section('title', 'Nuevo Usuario')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-600">← Volver</a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Nuevo Usuario</h1>
    </div>
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf
            @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                    @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Nombre Completo *</label>
                    <input name="name" value="{{ old('name') }}" required class="form-input" placeholder="Juan Pérez">
                </div>
                <div>
                    <label class="form-label">Correo Electrónico *</label>
                    <input name="email" type="email" value="{{ old('email') }}" required class="form-input" placeholder="usuario@inces.gob.ve">
                </div>
                <div>
                    <label class="form-label">Contraseña *</label>
                    <input name="password" type="password" required minlength="8" class="form-input">
                </div>
                <div>
                    <label class="form-label">Confirmar Contraseña *</label>
                    <input name="password_confirmation" type="password" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Rol *</label>
                    <select name="role" required class="form-input">
                        <option value="student"    {{ old('role') === 'student'    ? 'selected' : '' }}>Estudiante</option>
                        <option value="instructor" {{ old('role') === 'instructor' ? 'selected' : '' }}>Instructor</option>
                        <option value="admin"      {{ old('role') === 'admin'      ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Teléfono</label>
                    <input name="phone" value="{{ old('phone') }}" class="form-input" placeholder="0424-0000000">
                </div>
            </div>
            <div>
                <label class="form-label">Biografía</label>
                <textarea name="bio" rows="3" class="form-input" placeholder="Descripción breve...">{{ old('bio') }}</textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">💾 Guardar Usuario</button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
