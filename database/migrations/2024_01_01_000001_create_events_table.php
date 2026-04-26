<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location');
            $table->string('scope')->default('trong_truong'); // trong_truong, ngoai_truong
            $table->string('category')->default('Hoạt động chung');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('organizer_id');
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'changes_requested', 'ended', 'completed', 'cancelled'])->default('draft');
            $table->integer('max_participants')->nullable();
            $table->string('qr_token')->nullable(); // For dynamic QR generation
            $table->timestamps();

            $table->foreign('organizer_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
