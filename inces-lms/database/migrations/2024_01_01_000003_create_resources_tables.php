<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('module_id')->nullable()->constrained('modules')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->integer('order')->default(0);
            $table->jsonb('metadata')->nullable();
            $table->boolean('is_downloadable')->default(true);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('document_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained('resources')->onDelete('cascade');
            $table->text('extracted_text')->nullable();
            $table->text('summary')->nullable();
            $table->jsonb('keywords')->nullable();
            $table->jsonb('topics')->nullable();
            $table->string('language')->default('es');
            $table->string('status')->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
        Schema::create('resource_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained('resources')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('view_count')->default(1);
            $table->timestamp('last_viewed_at');
            $table->timestamps();
            $table->unique(['resource_id', 'user_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('resource_views');
        Schema::dropIfExists('document_analysis');
        Schema::dropIfExists('resources');
    }
};
