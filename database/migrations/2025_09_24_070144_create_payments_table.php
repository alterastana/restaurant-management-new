<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->uuid('order_id')->nullable();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->string('payment_method', 50); // contoh: cash, credit card, transfer
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_date');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->text('payment_url')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('reservation_id')->references('reservation_id')->on('reservations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
