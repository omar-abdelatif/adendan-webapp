<?php

namespace Database\Seeders;

use App\Models\TotalSafe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TotalSafe::create([
            'amount' => 0,
        ]);
    }
}
