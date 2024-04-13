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
        Schema::table('olddelays', function (Blueprint $table) {
            $table->bigInteger('delay_amount')->after('old_delay_type')->nullable();
            $table->bigInteger('delay_remaining')->after('delay_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('olddelays', function (Blueprint $table) {
            $table->dropColumn('delay_amount');
            $table->dropColumn('delay_remaining');
        });
    }
};
