<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('dues', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->id();
            $table->foreignId('member_id')->constrained('subscribers', 'member_id')->onDelete('cascade');
            $table->string('item');
            $table->integer('total_amount')->default(0);
            $table->string('amount_paid')->default(0)->nullable();
            $table->string('amount_remaining')->default(0)->nullable();
            $table->string('transaction_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('dues');
    }
};
