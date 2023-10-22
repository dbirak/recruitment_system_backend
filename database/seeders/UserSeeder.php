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
                    'role_id' => 2
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
                ]
            ],
            'name'
        );
    }
}
