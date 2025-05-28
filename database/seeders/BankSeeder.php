<?php

namespace Database\Seeders;

use App\Models\TotalBank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TotalBank::create([
            'amount' => 0,
        ]);
    }
}
