<?php

namespace Database\Seeders;

use App\Models\SMSFEES;
use Illuminate\Database\Seeder;

class SmsFeesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        SMSFEES::create([
            'item' => 'رسائل 2027',
            'amount' => 40,
        ]);
    }
}
