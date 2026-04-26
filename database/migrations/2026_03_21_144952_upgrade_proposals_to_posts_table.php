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
        // 1. Rename table
        Schema::rename('proposals', 'posts');

        // 2. Add 'type' column to posts
        Schema::table('posts', function (Blueprint $table) {
            $table->string('type')->default('idea')->after('content'); // idea, recruitment, announcement
        });

        // 3. Create post_reactions table
        Schema::create('post_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // like, dislike
            $table->timestamps();
            
            // Allow a user to react only once per post
            $table->unique(['post_id', 'user_id']);
        });

        // 4. Create post_comments table
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('post_reactions');
        
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::rename('posts', 'proposals');
    }
};
