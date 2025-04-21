<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('media_post');
    }

    public function down(): void
    {
        Schema::create('media_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->nullable()->constrained('medias')->onDelete('cascade');
            $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

};
