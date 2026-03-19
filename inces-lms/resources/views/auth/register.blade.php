@extends('layouts.auth')
@section('title', 'Registro')

@section('content')
<h2 class="text-2xl font-display font-bold text-gray-900 mb-1">Crear Cuenta</h2>
<p class="text-gray-500 text-sm mb-6">Únete a la plataforma de formación INCES</p>

@if($errors->any())
    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
        @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
    </div>
@endif

<form method="POST" action="{{ route('register.post') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nombre Completo</label>
        <input type="text" name="name" value="{{ old('name') }}" required
            class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            placeholder="Juan Pérez">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Correo Electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" required
            class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            placeholder="correo@ejemplo.com">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Contraseña</label>
        <input type="password" name="password" required minlength="8"
            class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            placeholder="Mínimo 8 caracteres">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" required
            class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            placeholder="Repite la contraseña">
    </div>
    <button type="submit"
        class="w-full py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg text-sm">
        Crear Mi Cuenta
    </button>
</form>

<div class="mt-6 pt-6 border-t border-gray-100 text-center">
    <p class="text-sm text-gray-500">
        ¿Ya tienes cuenta?
        <a href="{{ route('login') }}" class="font-semibold text-brand-500 hover:text-brand-700">Inicia sesión</a>
    </p>
</div>
@endsection
