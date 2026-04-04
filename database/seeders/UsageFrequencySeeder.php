<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsageFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usage_frequencies')->insert([
            ['monthly_usage' => '1', 'frequency_name' => 'ほぼ使わない'],
            ['monthly_usage' => '2', 'frequency_name' => 'たまに'],
            ['monthly_usage' => '4', 'frequency_name' => 'ときどき'],
            ['monthly_usage' => '10', 'frequency_name' => 'よく使う'],
            ['monthly_usage' => '16', 'frequency_name' => 'かなり使う'],
            ['monthly_usage' => '30', 'frequency_name' => '毎日使う'],
        ]);
    }
}
