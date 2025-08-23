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
        Schema::create('searched_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ssn');
            $table->string('mobile_no');
            $table->string('address');
            $table->string('birthdate');
            $table->integer('member_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('searched_data');
    }
};
