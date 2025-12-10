<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loyalty_programs', function (Blueprint $table) {
            $table->id('loyalty_id');

            // Relasi ke customer
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')
                ->references('customer_id')
                ->on('customers')
                ->onDelete('cascade');

            // Kolom poin dan level
            $table->integer('points')->default(0);
            $table->enum('membership_level', ['Silver', 'Gold', 'Platinum'])->default('Silver');

            // Diskon berdasarkan level (tetap)
            $table->decimal('discount_amount', 10, 2)->default(5000);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('loyalty_programs');
    }
};
