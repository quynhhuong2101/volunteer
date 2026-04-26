<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Items within a Budget Plan
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('unit_price', 15, 2);
            $table->integer('quantity')->default(1);
            $table->string('source')->default('fund'); // fund, sponsor, etc.
            $table->timestamps();
        });

        // Actual Expenses Tracking
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who created this expense entry
            $table->string('title');
            $table->decimal('amount', 15, 2);
            $table->string('proof_image')->nullable();
            $table->dateTime('occurred_at')->useCurrent();
            $table->string('status')->default('approved'); // approved, pending, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('budget_items');
    }
};
