<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Province::truncate();
        Schema::enableForeignKeyConstraints();
        Province::upsert(
            [
                [    
                    'province_name' => 'Dolnośląskie',
                ],
                [    
                    'province_name' => 'Kujawsko-Pomorskie',
                ],
                [    
                    'province_name' => 'Lubelskie',
                ],
                [    
                    'province_name' => 'Lubuskie',
                ],
                [    
                    'province_name' => 'Łódzkie',
                ],
                [    
                    'province_name' => 'Małopolskie',
                ],
                [    
                    'province_name' => 'Mazowieckie',
                ],
                [    
                    'province_name' => 'Opolskie',
                ],
                [    
                    'province_name' => 'Podkarpackie',
                ],
                [    
                    'province_name' => 'Podlaskie',
                ],
                [    
                    'province_name' => 'Pomorskie',
                ],
                [    
                    'province_name' => 'Śląskie',
                ],
                [    
                    'province_name' => 'Świętokrzyskie',
                ],
                [    
                    'province_name' => 'Warmińsko-Mazurskie',
                ],
                [    
                    'province_name' => 'Wielkopolskie',
                ],
                [    
                    'province_name' => 'Zachodniopomorskie',
                ]
            ],
            'role_name'
        );
    }
}
