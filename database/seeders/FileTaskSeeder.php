<?php

namespace Database\Seeders;

use App\Models\FileTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FileTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        FileTask::truncate();
        Schema::enableForeignKeyConstraints();
        FileTask::upsert(
            [
                [
                    'name' => 'Obsługa wyjątków w JAVIE',
                    'descryption' => '<p class="ql-align-center"><strong class="ql-size-large">ZADANIE PROGRAMISTYCZNE: OBSŁUGA WYJĄTKÓW W JAVIE</strong></p><p><br></p><p>Twoim zadaniem jest stworzenie aplikacji do zarządzania bazą danych książek. Aplikacja ma umożliwiać dodawanie nowych książek do bazy oraz usuwanie istniejących.</p><p><br></p><p><strong>Wymagania:</strong></p><ol><li>Stwórz klasę Book, która reprezentuje książkę. Powinna zawierać podstawowe informacje takie jak tytuł, autor, numer ISBN itp.</li><li>Utwórz klasę BookDatabase, która będzie symulować bazę danych książek. Ta klasa powinna posiadać następujące funkcjonalności:</li></ol><ul><li class="ql-indent-1">Metodę addBook(Book book) dodającą nową książkę do bazy danych.</li><li class="ql-indent-1">Metodę removeBook(String isbn) usuwającą książkę z bazy danych na podstawie numeru ISBN.</li><li class="ql-indent-1">Obsługę wyjątków w przypadku próby dodania już istniejącej książki (np. identyczny numer ISBN).</li><li class="ql-indent-1">Zaimplementuj odpowiednie własne wyjątki (DuplicateBookException, BookNotFoundException itp.) odpowiadające za sytuacje, w których występują błędy podczas dodawania lub usuwania książek.</li></ul><p><br></p><p><strong>Oczekiwane pliki:</strong></p><p>Swoje rozwiązanie należy spakować do archiwum ZIP. Twoja odpowiedź powinna zawierać:</p><ol><li>Plik Book.java zawierający definicję klasy Book.</li><li>Plik BookDatabase.java z implementacją bazy danych książek oraz obsługą wyjątków.</li><li>Plik Main.java (lub inaczej nazwany) z metodą main służącą do przetestowania działania Twojej implementacji.</li></ol><p><br></p><p><strong>Instrukcja:</strong></p><ol><li>Stwórz własne klasy wyjątków w odpowiednich sytuacjach.</li><li>Dodaj komentarze do kodu, wyjaśniając działanie kluczowych fragmentów Twojego kodu.</li><li>Nazwij zmienne i metody zgodnie z konwencjami nazewniczymi Javy.</li><li>Upewnij się, że Twoja implementacja obsługuje wyjątki w odpowiedni sposób i umożliwia prawidłowe działanie bazy danych książek.</li></ol><p><br></p><p><strong>Powodzenia!</strong></p>',
                    'time' => 65,
                    'user_id' => 12,
                ]
            ],
            'time'
        );
    }
}
