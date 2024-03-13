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
        Schema::create('outer_donations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id');
            $table->bigInteger('amount');
            $table->string('donation_destination');
            $table->integer('donators_id')->index()->references('id')->on('donators')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outer_donations');
    }
};
