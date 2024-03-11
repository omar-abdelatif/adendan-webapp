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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('member_id');
            $table->integer('subscription_cost');
            $table->integer('invoice_no');
            $table->date('pay_date');
            $table->integer('subscribers_id')->index()->references('id')->on('subscribers')->onDelete('cascade');
            $table->year('period');
            $table->string('delays')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
