<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();

            // رابط مع users
            $table->foreignId('user_id')->constrained('usersgreenhouse')->cascadeOnDelete();

            // معلومات المتجر
            $table->string('store_name');
            $table->string('phone')->nullable();

            // ملفات المتجر
            $table->string('logo')->nullable();      // شعار المتجر
            $table->string('banner')->nullable();    // صورة الغلاف

            $table->tinyInteger('rating')->comment('from 1 to 5');

            // موقع المتجر
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // اشتراك
            $table->string('subscription_type')->nullable();
            $table->date('subscription_expires_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
