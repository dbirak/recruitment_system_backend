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
                    'name' => 'Spółka akcyjna Orchidea sp. z.o.o',
                    'street' => 'Letnia 3',
                    'post_code' => '65-123',
                    'city' => 'Rzeszów',
                    'krs' => "1234567890",
                    'regon' => "123456789",
                    'nip' => "1234567890",
                    'phone_number' => "362718279",
                    'description' => "",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => null,
                    'user_id' => 1,
                    'province_id' => 5
                ]
            ],
            'street'
        );
    }
}
