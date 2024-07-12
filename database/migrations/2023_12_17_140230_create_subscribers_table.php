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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('member_id')->unique();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->bigInteger('ssn')->unique();
            $table->string('address')->nullable();
            $table->string('educational_qualification')->nullable();
            $table->date('qualification_date')->nullable();
            $table->string('job')->nullable();
            $table->longText('job_destination')->nullable();
            $table->bigInteger('job_tel')->nullable();
            $table->string('job_address')->nullable();
            $table->string('home_tel')->nullable();
            $table->string('martial_status')->nullable();
            $table->date('birthdate');
            $table->bigInteger('mobile_no')->unique();
            $table->tinyInteger('status')->default(0);
            $table->string('img')->nullable();
            $table->string('id_img')->nullable();
            $table->string('membership_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
