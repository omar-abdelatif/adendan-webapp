<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('sms_subscribers', function (Blueprint $table) {
            $table->engine("InnoDB");
            $table->id();
            $table->foreignId('member_id')->constrained('subscribers', 'member_id')->cascadeOnDelete()->nullable();
            $table->bigInteger('mobile_no');
            $table->integer('amount');
            $table->date('subscription_start_date')->nullable();
            $table->date('subscription_expiry_date')->nullable();
            $table->boolean('active_sms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('sms_subscribers');
    }
};
