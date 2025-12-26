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
        Schema::create('seller_feedback', function (Blueprint $table) {
            $table->id();

            // البائع اللي داير التعليق للموقع
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();

            // التقييم اللي عطاه seller للموقع (من 1 لـ 5)
            $table->tinyInteger('rating')->nullable()->comment('rating from 1 to 5');

            // الرسالة
            $table->text('message')->nullable();

            // الرد من عندك (admin)
            $table->text('admin_reply')->nullable();

            // الحالة
            $table->enum('status', ['pending', 'seen', 'replied'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_feedback');
    }
};
