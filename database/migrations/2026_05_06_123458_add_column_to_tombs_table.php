<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('tombs', function (Blueprint $table) {
            $table->string('tomb_type')->after('title');
            $table->string('tomb_specialization')->after('tomb_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('tombs', function (Blueprint $table) {
            $table->dropColumn('tomb_type')->after('title');
            $table->dropColumn('tomb_specialization')->after('tomb_type');
        });
    }
};
