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
        Schema::create('loyalties', function (Blueprint $table) {
        $table->id('loyalty_id');
        $table->foreignId('customer_id')->constrained('customers', 'customer_id')->cascadeOnDelete();
        $table->integer('points')->default(0);
        $table->enum('membership_level', ['Silver', 'Gold', 'Platinum'])->default('Silver');
        $table->decimal('discount_amount', 10, 2)->default(2000);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalties');
    }
};
