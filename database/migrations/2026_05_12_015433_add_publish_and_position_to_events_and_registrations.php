<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->after('status');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->foreignId('event_position_id')->nullable()->after('event_id')->constrained('event_positions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['event_position_id']);
            $table->dropColumn('event_position_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }
};
