<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('menus', function (Blueprint $table) {
            $table->id('menu_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('restaurant_id')->references('restaurant_id')->on('restaurants')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('menus');
    }
};
