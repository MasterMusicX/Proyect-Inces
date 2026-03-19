@extends('layouts.auth')
@section('title', 'Iniciar Sesión')

@section('content')
<div>
    <h2 class="text-2xl font-display font-bold text-gray-900 mb-1">Iniciar Sesión</h2>
    <p class="text-gray-500 text-sm mb-6">Accede a tu cuenta INCES LMS</p>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                placeholder="usuario@inces.gob.ve">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Contraseña</label>
            <input type="password" name="password" required
                class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                placeholder="••••••••">
        </div>
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                Recordarme
            </label>
        </div>
        <button type="submit"
            class="w-full py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg text-sm">
            Ingresar al Sistema
        </button>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-500">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="font-semibold text-brand-500 hover:text-brand-700">Regístrate aquí</a>
        </p>
    </div>

    <!-- Demo credentials -->
    <div class="mt-4 p-3 bg-blue-50 rounded-xl text-xs text-blue-600">
        <p class="font-bold mb-1">Demo:</p>
        <p>Admin: admin@inces.gob.ve / password</p>
        <p>Estudiante: estudiante@inces.gob.ve / password</p>
    </div>
</div>
@endsection
