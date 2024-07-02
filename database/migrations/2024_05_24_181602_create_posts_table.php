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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            // 外部キー制約、usersテーブルのレコード削除に伴うポストの連鎖削除
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title', 50);
            $table->text('content');
            $table->string('image_path', 255)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
