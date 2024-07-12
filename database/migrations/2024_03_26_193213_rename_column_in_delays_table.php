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
            $table->renameColumn('amount', 'paied');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delays', function (Blueprint $table) {
            $table->renameColumn('paied', 'amount');
        });
    }
};
