<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Answer::truncate();
        Schema::enableForeignKeyConstraints();
        Answer::upsert(
            [
                [
                    'answer' => 'int',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'String',
                    'is_correct' => false,
                ],
                [
                    'answer' => 'boolean',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'double',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'char',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'extend',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'super',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'implements',
                    'is_correct' => false,
                ],
                [
                    'answer' => 'extends',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'MyClass obj = MyClass();',
                    'is_correct' => false,
                ],
                [
                    'answer' => 'MyClass obj = new MyClass();',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'new MyClass obj;',
                    'is_correct' => false,
                ],
                [
                    'answer' => 'MyClass obj = new MyClass;',
                    'is_correct' => false,
                ],
                [
                    'answer' => 'throw',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'catch',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'throws',
                    'is_correct' => false,
                ],
                [
                    'answer' => 'try',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'Interfejsy mogą zawierać implementacje metod.',
                    'is_correct' => false,
                ],
                [
                    'answer' => 'Klasa implementująca interfejs musi zaimplementować wszystkie metody interfejsu.',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'Interfejsy mogą dziedziczyć po innych interfejsach.',
                    'is_correct' => true,
                ],
                [
                    'answer' => 'Interfejsy nie mogą zawierać stałych (const).',
                    'is_correct' => false,
                ]
            ],
            'answer'
        );
    }
}
