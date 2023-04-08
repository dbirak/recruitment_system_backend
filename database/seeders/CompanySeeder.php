<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Company::truncate();
        Schema::enableForeignKeyConstraints();
        Company::upsert(
            [
                [
                    'street' => 'Letnia 3',
                    'post_code' => '65-123',
                    'city' => 'Rzeszów',
                    'krs' => "1234567890",
                    'regon' => "123456789",
                    'nip' => "123-456-78-90",
                    'phone_number' => "362718279",
                    'user_id' => 1,
                    'province_id' => 5
                ]
            ],
            'street'
        );
    }
}
