<?php

namespace Database\Seeders;

use App\Models\TotalSafe;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SafeSeeder extends Seeder
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
