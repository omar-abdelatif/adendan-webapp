<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->string('paymob_intention_id')->nullable()->after('transaction_type');
            $table->string('paymob_transaction_id')->nullable()->after('paymob_intention_id');
            $table->enum('paymob_status', ['pending', 'paid', 'failed'])->nullable()->after('paymob_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->dropColumn(['paymob_intention_id', 'paymob_transaction_id', 'paymob_status']);
        });
    }
};
