<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();
        Category::upsert(
            [
                [
                    'category_name' => 'Badania i rozwój',
                ],
                [
                    'category_name' => 'Budownictwo',
                ],
                [
                    'category_name' => 'Edukacja',
                ],
                [
                    'category_name' => 'Finanse i rachunkowość',
                ],
                [
                    'category_name' => 'Gastronomia',
                ],
                [
                    'category_name' => 'Handel',
                ],
                [
                    'category_name' => 'Informatyka i technologia',
                ],
                [
                    'category_name' => 'Inżynieria',
                ],
                [
                    'category_name' => 'Medycyna i opieka zdrowotna',
                ],
                [
                    'category_name' => 'Nieruchomości',
                ],
                [
                    'category_name' => 'Obsługa klienta',
                ],
                [
                    'category_name' => 'Prawo',
                ],
                [
                    'category_name' => 'Praca fizyczna',
                ],
                [
                    'category_name' => 'Sprzedaż i marketing',
                ],
                [
                    'category_name' => 'Sztuka',
                ],
                [
                    'category_name' => 'Transport i logistyka',
                ],
                [
                    'category_name' => 'Inne',
                ]
            ],
            'category_name'
        );
    }
}
