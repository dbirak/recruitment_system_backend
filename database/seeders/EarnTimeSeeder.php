<?php

namespace Database\Seeders;

use App\Models\EarnTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EarnTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        EarnTime::truncate();
        Schema::enableForeignKeyConstraints();
        EarnTime::upsert(
            [
                [
                    'earn_time_name' => 'brutto / mies.',
                ],
                [
                    'earn_time_name' => 'netto / mies.',
                ],
                [
                    'earn_time_name' => 'brutto / godz.',
                ],
                [
                    'earn_time_name' => 'brutto / godz.',
                ]
            ],
            'earn_time_name'
        );
    }
}
