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
        Schema::table('delays', function (Blueprint $table) {
            $table->string('year')->after('member_id');
            $table->integer('yearly_cost')->after('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delays', function (Blueprint $table) {
            $table->dropColumn('year');
            $table->dropColumn('yearly_cost');
        });
    }
};
