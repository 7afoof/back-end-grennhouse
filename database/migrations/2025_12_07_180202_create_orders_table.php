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
        Schema::table('orders', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained('usersgreenhouse')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();

            $table->string('firstNameCustomer')->after('user_id');


            $table->string('lastNameCustomer')->after('firstNameCustomer');


            $table->string('phoneCustomer')->after('lastNameCustomer');


            $table->string('adressCustomer')->after('phoneCustomer');


            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'firstNameCustomer',
                'lastNameCustomer',
                'phoneCustomer',
                'adressCustomer',
            ]);
        });
    }
};
