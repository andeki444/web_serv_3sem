<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // URL запроса
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};