<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Question::truncate();
        Schema::enableForeignKeyConstraints();
        Question::upsert(
            [
                [
                    'question' => 'Które z poniższych typów danych są właściwymi typami prymitywnymi w języku Java?',
                ],
                [
                    'question' => 'Które z poniższych słów kluczowych są używane do obsługi dziedziczenia w Javie?',
                ],
                [
                    'question' => 'Które z poniższych są poprawnymi sposobami tworzenia obiektów w Javie?',
                ],
                [
                    'question' => 'Które z poniższych są właściwymi metodami służącymi do obsługi wyjątków w Javie?',
                ],
                [
                    'question' => 'Które z poniższych są właściwymi cechami interfejsów w Javie?',
                ]
            ],
            'question'
        );
    }
}
