<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('table_restaurants', function (Blueprint $table) {
            $table->id('table_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->integer('table_number');
            $table->integer('capacity');
            $table->string('status');
            $table->timestamps();

            $table->foreign('restaurant_id')->references('restaurant_id')->on('restaurants')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('table_restaurants');
    }
};
