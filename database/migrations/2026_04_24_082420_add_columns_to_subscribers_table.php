<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->string('tomb_name')->index()->references('title')->on('tombs')->nullable()->after('status');
            $table->string('password')->nullable()->after('tomb_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropColumn('tomb_name');
            $table->dropColumn('password');
        });
    }
};
