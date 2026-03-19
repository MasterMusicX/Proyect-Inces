@extends('layouts.app')
@section('title', 'Gestión de Usuarios')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Usuarios del Sistema</h1>
            <p class="text-gray-500 text-sm">{{ $users->total() }} usuarios registrados</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            ➕ Nuevo Usuario
        </a>
    </div>

    <!-- Filters -->
    <div class="card p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o email..."
                class="form-input flex-1 min-w-48">
            <select name="role" class="form-input w-40">
                <option value="">Todos los roles</option>
                <option value="admin"      {{ request('role') === 'admin'      ? 'selected' : '' }}>Admin</option>
                <option value="instructor" {{ request('role') === 'instructor' ? 'selected' : '' }}>Instructor</option>
                <option value="student"    {{ request('role') === 'student'    ? 'selected' : '' }}>Estudiante</option>
            </select>
            <button type="submit" class="btn-primary">🔍 Filtrar</button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">✕ Limpiar</a>
        </form>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Último Acceso</th>
                    <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar_url }}" class="w-9 h-9 rounded-full" alt="{{ $user->name }}">
                            <div>
                                <p class="font-semibold text-sm text-gray-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="badge {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : ($user->role === 'instructor' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="badge {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-400">
                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Nunca' }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-brand-500 hover:text-brand-700 text-sm font-medium">Editar</a>
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                @csrf
                                <button type="submit" class="text-xs px-2.5 py-1 rounded-lg {{ $user->is_active ? 'text-orange-600 bg-orange-50 hover:bg-orange-100' : 'text-green-600 bg-green-50 hover:bg-green-100' }} font-medium transition">
                                    {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">No se encontraron usuarios.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
