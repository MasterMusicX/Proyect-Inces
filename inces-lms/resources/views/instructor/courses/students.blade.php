@extends('layouts.app')
@section('title', 'Estudiantes - ' . $course->title)
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('instructor.courses.show', $course) }}" class="text-gray-400 hover:text-gray-600">← Volver</a>
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white">Estudiantes — {{ Str::limit($course->title, 40) }}</h1>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Estudiante</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Progreso</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Estado</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Inscrito</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $student->avatar_url }}" class="w-9 h-9 rounded-full" alt="{{ $student->name }}">
                            <div>
                                <p class="font-semibold text-sm text-gray-900 dark:text-white">{{ $student->name }}</p>
                                <p class="text-xs text-gray-400">{{ $student->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-28 h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-brand-500 rounded-full" style="width:{{ $student->pivot->progress_percentage }}%"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $student->pivot->progress_percentage }}%</span>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="badge {{ $student->pivot->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $student->pivot->status === 'completed' ? 'Completado' : 'En curso' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($student->pivot->created_at)->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">Sin estudiantes inscritos.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4 border-t">{{ $students->links() }}</div>
    </div>
</div>
@endsection
