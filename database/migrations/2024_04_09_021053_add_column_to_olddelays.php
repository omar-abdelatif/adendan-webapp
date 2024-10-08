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
            $table->string('old_delay_type')->after('member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('olddelays', function (Blueprint $table) {
            $table->dropColumn('old_delay_type');
        });
    }
};
