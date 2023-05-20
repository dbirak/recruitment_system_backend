<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Contract::truncate();
        Schema::enableForeignKeyConstraints();
        Contract::upsert(
            [
                [
                    'contract_name' => 'Umowa o pracę',
                ],
                [
                    'contract_name' => 'Umowa o dzieło',
                ],
                [
                    'contract_name' => 'Umowa zlecenie',
                ],
                [
                    'contract_name' => 'Kontrakt B2B',
                ],
                [
                    'contract_name' => 'Umowa agencyjna',
                ],
                [
                    'contract_name' => 'Umowa o pracę tymczasową',
                ],
                [
                    'contract_name' => 'Umowa o staż / praktyki',
                ]
            ],
            'contract_name'
        );
    }
}
