<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->string('order_type');
            $table->dateTime('order_date');
            $table->string('status');
            $table->timestamps();

            $table->foreign('restaurant_id')->references('restaurant_id')->on('restaurants')->onDelete('cascade');
            $table->foreign('reservation_id')->references('reservation_id')->on('reservations')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
