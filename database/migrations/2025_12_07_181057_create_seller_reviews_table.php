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
        Schema::create('seller_reviews', function (Blueprint $table) {
            $table->id();

            // المشتري اللي دار التقييم
            $table->foreignId('user_id')->constrained('usersgreenhouse')->cascadeOnDelete();

            // البائع اللي تايدير ليه التقييم
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();

            // rating
            $table->tinyInteger('rating')->comment('from 1 to 5');

            // review/comment
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_reviews');
    }
};
