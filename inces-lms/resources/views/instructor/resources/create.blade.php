@extends('layouts.app')
@section('title', 'Subir Recurso')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('instructor.courses.resources.index', $course) }}" class="text-gray-400 hover:text-gray-600">← Volver</a>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Subir Recurso</h1>
    </div>
    <div class="card p-6">
        <form method="POST" action="{{ route('instructor.courses.resources.store', $course) }}"
            enctype="multipart/form-data" class="space-y-5" x-data="{ type: 'pdf' }">
            @csrf
            @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                    @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                </div>
            @endif
            <div>
                <label class="form-label">Tipo de Recurso *</label>
                <select name="type" x-model="type" required class="form-input">
                    <option value="pdf">📄 PDF</option>
                    <option value="docx">📝 Word (DOCX)</option>
                    <option value="xlsx">📊 Excel (XLSX)</option>
                    <option value="pptx">📋 PowerPoint (PPTX)</option>
                    <option value="video">🎬 Video</option>
                    <option value="image">🖼️ Imagen</option>
                    <option value="url">🔗 URL Externa</option>
                </select>
            </div>
            <div>
                <label class="form-label">Título *</label>
                <input name="title" value="{{ old('title') }}" required class="form-input" placeholder="Nombre del recurso">
            </div>
            <div>
                <label class="form-label">Descripción</label>
                <textarea name="description" rows="2" class="form-input" placeholder="Descripción opcional...">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="form-label">Módulo</label>
                <select name="module_id" class="form-input">
                    <option value="">Sin módulo específico</option>
                    @foreach($modules as $m)
                        <option value="{{ $m->id }}" {{ old('module_id') == $m->id ? 'selected' : '' }}>{{ $m->title }}</option>
                    @endforeach
                </select>
            </div>
            <!-- File upload (for non-url types) -->
            <div x-show="type !== 'url'">
                <label class="form-label">Archivo *</label>
                <input type="file" name="file" class="form-input"
                    :accept="type === 'pdf' ? '.pdf' : (type === 'docx' ? '.docx' : (type === 'xlsx' ? '.xlsx' : (type === 'pptx' ? '.pptx' : (type === 'video' ? '.mp4,.avi,.mov,.webm' : 'image/*'))))">
                <p class="text-xs text-gray-400 mt-1">Máximo 50 MB</p>
            </div>
            <!-- URL input (for url type) -->
            <div x-show="type === 'url'">
                <label class="form-label">URL Externa *</label>
                <input type="url" name="external_url" value="{{ old('external_url') }}" class="form-input" placeholder="https://...">
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_downloadable" value="1" checked id="downloadable" class="rounded">
                <label for="downloadable" class="text-sm font-medium">Permitir descarga</label>
            </div>
            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-sm text-blue-600 dark:text-blue-300">
                🤖 <strong>Análisis IA:</strong> Los documentos (PDF, Word, Excel, PowerPoint) serán analizados automáticamente por IA para generar resúmenes y palabras clave.
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">⬆️ Subir Recurso</button>
                <a href="{{ route('instructor.courses.resources.index', $course) }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
