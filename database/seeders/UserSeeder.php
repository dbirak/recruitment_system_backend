<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        User::upsert(
            [
                [
                    'name' => 'Jan',
                    'surname' => 'Kowalski',
                    'email' => 'kowal@gmail.com',
                    'password' => bcrypt("12312312"),
                    'role_id' => 1
                ],
                [
                    'name' => 'Marek',
                    'surname' => 'Nowak',
                    'email' => 'nowaczek@gmail.com',
                    'password' => bcrypt("12312312"),
                    'role_id' => 1
                ],
                [
                    'name' => 'Dominik',
                    'surname' => 'Birak',
                    'email' => 'dombir5@gmail.com',
                    'password' => bcrypt("12312312"),
                    'role_id' => 1
                ],
                [
                    'name' => 'Anna',
                    'surname' => 'Kowalczyk',
                    'email' => 'anna.kowalczyk@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Piotr',
                    'surname' => 'Nowakowski',
                    'email' => 'piotr.nowakowski@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Magdalena',
                    'surname' => 'Wójcik',
                    'email' => 'magda.wojcik@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Tomasz',
                    'surname' => 'Lewandowski',
                    'email' => 'tomasz.lewandowski@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Karolina',
                    'surname' => 'Dąbrowska',
                    'email' => 'karolina.dabrowska@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Marcin',
                    'surname' => 'Wiśniewski',
                    'email' => 'marcin.wisniewski@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Katarzyna',
                    'surname' => 'Lis',
                    'email' => 'katarzyna.lis@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Łukasz',
                    'surname' => 'Szymański',
                    'email' => 'lukasz.szymanski@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Emilia',
                    'surname' => 'Kwiatkowska',
                    'email' => 'emilia.kwiatkowska@example.com',
                    'password' => bcrypt('12312312'),
                    'role_id' => 2,
                ]
            ],
            'name'
        );
    }
}
