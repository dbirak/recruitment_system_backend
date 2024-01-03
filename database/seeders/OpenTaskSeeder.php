<?php

namespace Database\Seeders;

use App\Models\OpenTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OpenTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        OpenTask::truncate();
        Schema::enableForeignKeyConstraints();
        OpenTask::upsert(
            [
                [
                    'name' => 'Podejście do pracy z kolekcjami w języku JAVA',
                    'descryption' => '<p class="ql-align-center"><strong class="ql-size-large">KOLEKCJE W JĘZYKU JAVA</strong></p><p><br></p><p>Opowiedz o swoim podejściu do pracy z kolekcjami w języku Java. W swojej odpowiedzi skup się na następujących aspektach:</p><ul><li><strong>Wybór odpowiedniej kolekcji:</strong> Jak podejmujesz decyzje dotyczące wyboru konkretnej kolekcji w zależności od problemu lub zadania? Jakie czynniki wpływają na Twoją decyzję?</li><li><strong>Operacje na kolekcjach:</strong> Czy możesz podać przykłady wykorzystania operacji na kolekcjach, takich jak dodawanie, usuwanie, iterowanie czy sortowanie danych? Jakie metody lub interfejsy wykorzystujesz najczęściej?</li><li><strong>Zarządzanie danymi:</strong> Jak dbasz o efektywne zarządzanie pamięcią i wydajność operacji na kolekcjach? Czy stosujesz jakieś techniki optymalizacji pracy z danymi w kolekcjach?</li><li><strong>Obsługa różnych typów danych:</strong> Jak radzisz sobie z różnymi typami danych przechowywanymi w kolekcjach? Czy masz doświadczenie z kolekcjami generycznymi lub w jaki sposób radzisz sobie z różnymi typami obiektów w kolekcjach?</li><li><strong>Doświadczenie z konkretnymi kolekcjami:</strong> Czy masz doświadczenie z wykorzystaniem konkretnych kolekcji, takich jak <em>ArrayList</em>, <em>HashMap</em>, <em>LinkedList </em>itp.? Jakie są Twoje spostrzeżenia lub doświadczenia z ich stosowania?</li></ul>',
                    'time' => 30,
                    'user_id' => 12,
                ]
            ],
            'time'
        );
    }
}
