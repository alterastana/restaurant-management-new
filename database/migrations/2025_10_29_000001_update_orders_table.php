<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->after('status');
            $table->text('notes')->nullable()->after('total_amount');
            $table->string('payment_status')->default('pending')->after('notes');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->string('payment_token')->nullable()->after('payment_method');
        });
    }

    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'notes', 'payment_status', 'payment_method', 'payment_token']);
        });
    }
};