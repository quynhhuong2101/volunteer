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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('major')->nullable();
            $table->string('faculty')->nullable();
            $table->string('class')->nullable();
            $table->string('start_year')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'dob',
                'address',
                'major',
                'faculty',
                'class',
                'start_year',
                'bio',
                'avatar'
            ]);
        });
    }
};
