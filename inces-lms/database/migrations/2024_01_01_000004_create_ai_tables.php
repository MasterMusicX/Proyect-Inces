<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ai_queries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->text('question');
            $table->text('response');
            $table->jsonb('context')->nullable();
            $table->integer('tokens_used')->default(0);
            $table->boolean('was_helpful')->nullable();
            $table->timestamps();
        });
        Schema::create('chatbot_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('session_id')->index();
            $table->string('title')->nullable();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('chatbot_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chatbot_conversations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['user', 'assistant', 'system']);
            $table->text('content');
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
        });
        Schema::create('knowledge_base', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('question');
            $table->text('answer');
            $table->jsonb('tags')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('knowledge_base');
        Schema::dropIfExists('chatbot_messages');
        Schema::dropIfExists('chatbot_conversations');
        Schema::dropIfExists('ai_queries');
    }
};
