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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('content');
        });

        Schema::table('post_comments', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('user_id')->constrained('post_comments')->onDelete('cascade');
        });

        Schema::create('comment_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_comment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['like', 'dislike']);
            $table->timestamps();

            $table->unique(['post_comment_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_reactions');

        Schema::table('post_comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
