<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loyalty_programs', function (Blueprint $table) {
            $table->id('loyalty_id');
            $table->unsignedBigInteger('customer_id');
            $table->integer('points')->default(0);
            $table->string('membership_level');
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('loyalty_programs');
    }
};
