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
        Schema::create('tombs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('region');
            $table->string('location')->nullable();
            $table->string('tomb_guard_name')->nullable();
            $table->bigInteger('tomb_guard_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tombs');
    }
};
