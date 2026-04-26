<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Event Positions (Tuyển dụng theo vị trí)
        Schema::create('event_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "Hậu cần", "Truyền thông"
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Chat System
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade'); // Nullable for direct messages support later
            $table->string('name')->nullable();
            $table->string('type')->default('group'); // group, direct
            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content')->nullable();
            $table->string('type')->default('text'); // text, image, file
            $table->json('attachments')->nullable();
            $table->timestamps();
        });

        // 3. Form Builder
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('form_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            $table->string('type'); // text, radio, checkbox, textarea
            $table->text('question');
            $table->json('options')->nullable(); // For radio/checkbox
            $table->boolean('is_required')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('form_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('answer');
            $table->timestamps();
        });

        // 4. Certificates
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique(); // e.g., CERT-2024-001
            $table->timestamp('issued_at');
            $table->string('template_url')->nullable();
            $table->timestamps();
        });

        // 5. Notifications
        Schema::create('notifications_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, success, warning, error
            $table->boolean('is_read')->default(false);
            $table->string('link')->nullable(); // Action link
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications_table');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('form_answers');
        Schema::dropIfExists('form_questions');
        Schema::dropIfExists('forms');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_rooms');
        Schema::dropIfExists('event_positions');
    }
};
