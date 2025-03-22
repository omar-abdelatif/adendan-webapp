<?php

namespace Database\Seeders;

use App\Models\TotalBank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SafeSeeder extends Seeder
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
