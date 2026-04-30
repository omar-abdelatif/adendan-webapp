<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->id();
            $table->foreignId('member_id')->constrained('subscribers', 'member_id')->onDelete('cascade');
            $table->string('item');
            $table->integer('amount')->default(0);
            $table->integer('inv_no')->default(0);
            $table->string('payment_cat');
            $table->date('payment_date');
            $table->string('payment_method');
            $table->string('transaction_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('payment_transactions');
    }
};
