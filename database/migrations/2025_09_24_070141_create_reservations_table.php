<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservation_id');
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->string('status');
            $table->timestamps();

            $table->foreign('table_id')->references('table_id')->on('table_restaurants')->onDelete('cascade');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservations');
    }
};
