@extends('layouts.app')
@section('title', 'Asistente Virtual IA')

@section('content')
<div class="flex gap-6 h-full" style="height: calc(100vh - 9rem);" x-data="chatbot()">

    <!-- Sidebar: Conversation History -->
    <div class="hidden xl:flex flex-col w-72 flex-shrink-0">
        <div class="card flex-1 flex flex-col overflow-hidden">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="font-display font-bold text-gray-800 dark:text-gray-200">💬 Historial</h3>
                <button @click="newConversation()" class="text-xs text-brand-500 hover:text-brand-700 font-semibold">+ Nuevo</button>
            </div>
            <div class="flex-1 overflow-y-auto p-2 space-y-1">
                <template x-for="conv in conversations" :key="conv.id">
                    <button @click="loadConversation(conv.id)"
                        :class="activeConversationId === conv.id ? 'bg-brand-50 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300' : 'hover:bg-gray-50 dark:hover:bg-gray-700/30 text-gray-600 dark:text-gray-400'"
                        class="w-full text-left p-3 rounded-xl transition group flex items-center gap-2">
                        <span class="text-base">💬</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium truncate" x-text="conv.title || 'Conversación'"></p>
                            <p class="text-xs opacity-60" x-text="conv.created_at"></p>
                        </div>
                        <button @click.stop="deleteConversation(conv.id)" class="opacity-0 group-hover:opacity-100 text-red-400 hover:text-red-600 transition text-xs">✕</button>
                    </button>
                </template>
                <template x-if="conversations.length === 0">
                    <p class="text-xs text-gray-400 text-center py-8">Sin conversaciones anteriores</p>
                </template>
            </div>
        </div>
    </div>

    <!-- Main Chat -->
    <div class="flex-1 flex flex-col card overflow-hidden min-w-0">
        <!-- Header -->
        <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
            <div class="w-11 h-11 bg-gradient-to-br from-brand-500 to-purple-600 rounded-2xl flex items-center justify-center text-xl flex-shrink-0 shadow">🤖</div>
            <div>
                <h2 class="font-display font-bold text-gray-900 dark:text-white">Asistente Virtual INCES</h2>
                <p class="text-xs text-gray-400">Gemini AI • Siempre disponible</p>
            </div>
            <div class="ml-auto flex items-center gap-2">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-xs text-gray-400 hidden sm:block">En línea</span>
                <button @click="newConversation()" title="Nueva conversación"
                    class="ml-2 text-xs px-3 py-1.5 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    🔄 Nueva
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div id="chat-msgs" class="flex-1 overflow-y-auto p-5 space-y-5">
            <!-- Welcome -->
            <div x-show="messages.length === 0">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-purple-600 rounded-full flex items-center justify-center text-sm flex-shrink-0">🤖</div>
                    <div class="max-w-lg">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl rounded-tl-sm p-4">
                            <p class="text-sm text-gray-800 dark:text-gray-100 font-semibold mb-2">¡Hola! Soy el <strong>Asistente Virtual INCES</strong> 👋</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">Puedo ayudarte con:</p>
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                @foreach(['📚 Preguntas sobre cursos', '💡 Explicar conceptos', '🔍 Buscar en documentos', '❓ Dudas frecuentes'] as $item)
                                <div class="bg-white dark:bg-gray-600 rounded-xl p-2 text-xs text-gray-600 dark:text-gray-200">{{ $item }}</div>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-800 dark:text-gray-100">¿En qué puedo ayudarte hoy?</p>
                        </div>
                    </div>
                </div>

                <!-- Quick suggestions -->
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach(['¿Cómo me inscribo en un curso?', '¿Qué cursos están disponibles?', 'Explícame qué es la administración', '¿Cómo obtengo mi certificado?'] as $q)
                    <button @click="quickSend('{{ $q }}')"
                        class="px-3 py-2 bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-300 rounded-xl text-xs font-medium hover:bg-brand-100 dark:hover:bg-brand-900/40 transition border border-brand-100 dark:border-brand-800">
                        {{ $q }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Chat messages -->
            <template x-for="(msg, idx) in messages" :key="idx">
                <div :class="msg.role === 'user' ? 'flex flex-row-reverse items-start gap-3' : 'flex items-start gap-3'">
                    <!-- Avatar -->
                    <div :class="msg.role === 'user'
                        ? 'w-8 h-8 bg-brand-500 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0'
                        : 'w-8 h-8 bg-gradient-to-br from-brand-500 to-purple-600 rounded-full flex items-center justify-center text-sm flex-shrink-0'">
                        <span x-text="msg.role === 'user' ? 'Tú' : '🤖'"></span>
                    </div>
                    <!-- Bubble -->
                    <div class="max-w-xl">
                        <div :class="msg.role === 'user'
                            ? 'bg-brand-500 text-white rounded-2xl rounded-tr-sm p-3.5'
                            : 'bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-2xl rounded-tl-sm p-3.5'">
                            <div class="text-sm leading-relaxed" x-html="formatMessage(msg.content)"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 px-1"
                            :class="msg.role === 'user' ? 'text-right' : ''"
                            x-text="msg.time || ''"></p>
                    </div>
                </div>
            </template>

            <!-- Typing indicator -->
            <div x-show="isTyping" class="flex items-start gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-brand-500 to-purple-600 rounded-full flex items-center justify-center text-sm">🤖</div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl rounded-tl-sm p-3.5">
                    <div class="flex gap-1 items-center">
                        <span class="text-xs text-gray-400 mr-1">Escribiendo</span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-100 dark:border-gray-700 p-4">
            <form @submit.prevent="sendMessage" class="flex gap-3 items-end">
                <div class="flex-1">
                    <textarea
                        x-model="newMessage"
                        @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                        :disabled="isTyping"
                        placeholder="Escribe tu pregunta... (Enter para enviar, Shift+Enter para nueva línea)"
                        rows="1"
                        maxlength="2000"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition resize-none disabled:opacity-50"
                        style="min-height: 48px; max-height: 120px;"
                        @input="$el.style.height = 'auto'; $el.style.height = Math.min($el.scrollHeight, 120) + 'px'"
                    ></textarea>
                </div>
                <button type="submit"
                    :disabled="!newMessage.trim() || isTyping"
                    class="h-12 px-5 bg-brand-500 hover:bg-brand-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-semibold rounded-xl transition flex items-center gap-2 text-sm flex-shrink-0">
                    <span x-show="!isTyping">Enviar</span>
                    <span x-show="isTyping" class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span x-show="!isTyping">✈️</span>
                </button>
            </form>
            <p class="text-xs text-gray-400 mt-2 text-center">
                Asistente impulsado por <strong>Google Gemini AI</strong> • Respuestas pueden contener imprecisiones
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function chatbot() {
    return {
        messages: [],
        newMessage: '',
        isTyping: false,
        activeConversationId: null,
        conversations: [],

        init() {
            this.loadConversations();
        },

        async loadConversations() {
            try {
                const r = await fetch('/api/chatbot/conversations', {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                });
                const data = await r.json();
                if (data.success) this.conversations = data.data;
            } catch(e) {}
        },

        async loadConversation(id) {
            this.activeConversationId = id;
            try {
                const r = await fetch(`/api/chatbot/conversations/${id}`, {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                });
                const data = await r.json();
                if (data.success) {
                    this.messages = data.data.messages.map(m => ({
                        role:    m.role,
                        content: m.content,
                        time:    new Date(m.created_at).toLocaleTimeString('es-VE', { hour: '2-digit', minute: '2-digit' })
                    }));
                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch(e) {}
        },

        newConversation() {
            this.messages = [];
            this.activeConversationId = null;
        },

        async deleteConversation(id) {
            if (!confirm('¿Eliminar esta conversación?')) return;
            await fetch(`/api/chatbot/conversations/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            this.conversations = this.conversations.filter(c => c.id !== id);
            if (this.activeConversationId === id) this.newConversation();
        },

        quickSend(text) {
            this.newMessage = text;
            this.sendMessage();
        },

        async sendMessage() {
            const msg = this.newMessage.trim();
            if (!msg || this.isTyping) return;

            const now = new Date().toLocaleTimeString('es-VE', { hour: '2-digit', minute: '2-digit' });
            this.messages.push({ role: 'user', content: msg, time: now });
            this.newMessage = '';
            this.isTyping = true;
            this.$nextTick(() => this.scrollToBottom());

            try {
                const r = await fetch('/api/chatbot/message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ message: msg, conversation_id: this.activeConversationId }),
                });
                const data = await r.json();

                if (data.success) {
                    this.activeConversationId = data.data.conversation_id;
                    this.messages.push({
                        role:    'assistant',
                        content: data.data.response,
                        time:    new Date(data.data.timestamp).toLocaleTimeString('es-VE', { hour: '2-digit', minute: '2-digit' })
                    });
                    this.loadConversations();
                } else {
                    this.messages.push({ role: 'assistant', content: 'Ha ocurrido un error. Por favor intenta nuevamente.', time: now });
                }
            } catch(e) {
                this.messages.push({ role: 'assistant', content: 'Error de conexión. Verifica tu internet.', time: now });
            } finally {
                this.isTyping = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        formatMessage(text) {
            if (!text) return '';
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/`([^`]+)`/g, '<code class="bg-gray-200 dark:bg-gray-600 px-1.5 py-0.5 rounded text-xs font-mono">$1</code>')
                .replace(/^### (.*$)/gm, '<h3 class="font-bold text-base mt-3 mb-1">$1</h3>')
                .replace(/^## (.*$)/gm, '<h2 class="font-bold text-lg mt-3 mb-1">$1</h2>')
                .replace(/^- (.*$)/gm, '<li class="ml-4 list-disc">$1</li>')
                .replace(/^(\d+)\. (.*$)/gm, '<li class="ml-4 list-decimal">$2</li>')
                .replace(/\n/g, '<br>')
                .replace(/---/g, '<hr class="border-gray-200 dark:border-gray-600 my-2">');
        },

        scrollToBottom() {
            const el = document.getElementById('chat-msgs');
            if (el) el.scrollTop = el.scrollHeight;
        }
    }
}
</script>
@endpush
