@php $role = auth()->user()->role; @endphp
<aside class="hidden lg:flex flex-col w-64 bg-gradient-to-b from-brand-800 to-brand-900 text-white flex-shrink-0 overflow-y-auto">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10 flex-shrink-0">
        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
            <span class="text-xl">🎓</span>
        </div>
        <div>
            <span class="font-display font-bold text-lg leading-none">INCES LMS</span>
            <p class="text-blue-200 text-xs">v1.0 — Plataforma IA</p>
        </div>
    </div>

    <!-- User info -->
    <div class="px-4 py-3 border-b border-white/10">
        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                class="w-9 h-9 rounded-full border-2 border-white/30 flex-shrink-0">
            <div class="min-w-0">
                <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                <span class="text-xs text-blue-200">
                    {{ match(auth()->user()->role) { 'admin' => 'Administrador', 'instructor' => 'Instructor', default => 'Estudiante' } }}
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-0.5">

        @if($role === 'admin')
        <p class="text-blue-300 text-xs font-semibold uppercase tracking-wider px-3 pt-1 pb-2">Principal</p>
        <a href="{{ route('admin.dashboard') }}"  class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-blue-100' }}"><span>📊</span> Dashboard</a>
        <a href="{{ route('admin.statistics') }}" class="sidebar-item {{ request()->routeIs('admin.statistics') ? 'active' : 'text-blue-100' }}"><span>📈</span> Estadísticas</a>

        <p class="text-blue-300 text-xs font-semibold uppercase tracking-wider px-3 pt-4 pb-2">Gestión</p>
        <a href="{{ route('admin.users.index') }}"      class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : 'text-blue-100' }}"><span>👥</span> Usuarios</a>
        <a href="{{ route('admin.courses.index') }}"    class="sidebar-item {{ request()->routeIs('admin.courses.*') ? 'active' : 'text-blue-100' }}"><span>📚</span> Cursos</a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : 'text-blue-100' }}"><span>🏷️</span> Categorías</a>

        <p class="text-blue-300 text-xs font-semibold uppercase tracking-wider px-3 pt-4 pb-2">Inteligencia Artificial</p>
        <a href="{{ route('admin.knowledge-base.index') }}" class="sidebar-item {{ request()->routeIs('admin.knowledge-base.*') ? 'active' : 'text-blue-100' }}"><span>🧠</span> Base de Conocimiento</a>

        @elseif($role === 'instructor')
        <p class="text-blue-300 text-xs font-semibold uppercase tracking-wider px-3 pt-1 pb-2">Panel Instructor</p>
        <a href="{{ route('instructor.dashboard') }}"    class="sidebar-item {{ request()->routeIs('instructor.dashboard') ? 'active' : 'text-blue-100' }}"><span>📊</span> Dashboard</a>
        <a href="{{ route('instructor.courses.index') }}" class="sidebar-item {{ request()->routeIs('instructor.courses.*') ? 'active' : 'text-blue-100' }}"><span>📚</span> Mis Cursos</a>

        @else
        <p class="text-blue-300 text-xs font-semibold uppercase tracking-wider px-3 pt-1 pb-2">Mi Aprendizaje</p>
        <a href="{{ route('student.dashboard') }}"       class="sidebar-item {{ request()->routeIs('student.dashboard') ? 'active' : 'text-blue-100' }}"><span>🏠</span> Mi Panel</a>
        <a href="{{ route('student.courses.catalog') }}" class="sidebar-item {{ request()->routeIs('student.courses.*') ? 'active' : 'text-blue-100' }}"><span>📚</span> Catálogo de Cursos</a>
        <a href="{{ route('student.search') }}"          class="sidebar-item {{ request()->routeIs('student.search') ? 'active' : 'text-blue-100' }}"><span>🔍</span> Búsqueda Inteligente</a>

        <p class="text-blue-300 text-xs font-semibold uppercase tracking-wider px-3 pt-4 pb-2">Asistente IA</p>
        <a href="{{ route('student.chatbot') }}"         class="sidebar-item {{ request()->routeIs('student.chatbot') ? 'active' : 'text-blue-100' }}"><span>🤖</span> Asistente Virtual</a>

        <p class="text-blue-300 text-xs font-semibold uppercase tracking-wider px-3 pt-4 pb-2">Mi Cuenta</p>
        <a href="{{ route('student.profile') }}"         class="sidebar-item {{ request()->routeIs('student.profile') ? 'active' : 'text-blue-100' }}"><span>👤</span> Mi Perfil</a>
        @endif
    </nav>

    <!-- Logout -->
    <div class="px-3 pb-4 pt-2 border-t border-white/10 flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-item text-blue-100 w-full hover:bg-red-500/20 hover:text-red-200">
                <span>🚪</span> Cerrar Sesión
            </button>
        </form>
    </div>
</aside>
