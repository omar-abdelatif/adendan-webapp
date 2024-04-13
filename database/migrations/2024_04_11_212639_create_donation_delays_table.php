<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donation_delays', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('member_id')->index()->references('member_id')->on('subscribers')->onDelete('cascade');
            $table->string('donation_type');
            $table->string('payment_type');
            $table->bigInteger('delay_amount')->default(0);
            $table->bigInteger('amount_paied')->nullable();
            $table->bigInteger('amount_remaining')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_delays');
    }
};
