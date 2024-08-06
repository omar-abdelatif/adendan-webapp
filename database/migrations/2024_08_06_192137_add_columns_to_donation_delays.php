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
        Schema::table('donation_delays', function (Blueprint $table) {
            $table->string('delay_other_amount')->nullable()->after('donation_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donation_delays', function (Blueprint $table) {
            $table->dropColumn('delay_other_donation');
        });
    }
};
