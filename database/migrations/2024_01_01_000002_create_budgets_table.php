<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->decimal('total_estimated', 15, 2)->default(0);
            $table->decimal('total_approved', 15, 2)->default(0);
            $table->decimal('total_spent', 15, 2)->default(0);
            $table->string('status')->default('draft'); // draft, pending, approved, rejected
            $table->text('admin_note')->nullable(); // For request changes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
