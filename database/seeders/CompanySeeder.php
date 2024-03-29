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
                    'name' => 'Agencja Reklamowa Creativo sp. j.',
                    'street' => 'Aleja Różana 12',
                    'post_code' => '00-987',
                    'city' => 'Warszawa',
                    'krs' => "9876543210",
                    'regon' => "987654321",
                    'nip' => "9876543210",
                    'phone_number' => "123456789",
                    'description' => "Specjalizujemy się w projektowaniu kreatywnych kampanii reklamowych.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'kontakt@creativoad.pl',
                    'user_id' => 4,
                    'province_id' => 7,
                ],
                [
                    'name' => 'Firma Budowlana "SolidBud" sp. z o.o.',
                    'street' => 'Krakowska 56',
                    'post_code' => '30-456',
                    'city' => 'Kraków',
                    'krs' => "9876543210",
                    'regon' => "123456789",
                    'nip' => "9876543210",
                    'phone_number' => "987654321",
                    'description' => "Specjalizujemy się w budowie domów jednorodzinnych.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'biuro@solidbud.com',
                    'user_id' => 5,
                    'province_id' => 6,
                ],
                [
                    'name' => 'Hurtownia Elektroniki "ELEKTRO-PLUS"',
                    'street' => 'Łąkowa 23',
                    'post_code' => '50-789',
                    'city' => 'Wrocław',
                    'krs' => "9876543210",
                    'regon' => "123456789",
                    'nip' => "9876543210",
                    'phone_number' => "987654321",
                    'description' => "Oferujemy szeroki asortyment elektroniki użytkowej.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'info@elektroplus.com',
                    'user_id' => 6,
                    'province_id' => 1,
                ],
                [
                    'name' => 'Wydawnictwo "Książkowe ABC" sp. z o.o.',
                    'street' => 'Mazurska 5',
                    'post_code' => '10-987',
                    'city' => 'Olsztyn',
                    'krs' => "9876543210",
                    'regon' => "123456789",
                    'nip' => "9876543210",
                    'phone_number' => "987654321",
                    'description' => "Publikujemy książki z różnych dziedzin wiedzy.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'info@ksiazkoweabc.pl',
                    'user_id' => 7,
                    'province_id' => 14,
                ],
                [
                    'name' => 'Hurtownia Odzieży "ModaPlus"',
                    'street' => 'Świętojańska 3',
                    'post_code' => '40-678',
                    'city' => 'Katowice',
                    'krs' => "9876543210",
                    'regon' => "123456789",
                    'nip' => "9876543210",
                    'phone_number' => "987654321",
                    'description' => "Oferujemy szeroki wybór odzieży dla kobiet, mężczyzn i dzieci.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'sklep@modaplus.com',
                    'user_id' => 8,
                    'province_id' => 12,
                ],
                [
                    'name' => 'Firma Transportowa "SpeedyTrans" sp. z o.o.',
                    'street' => 'Kołobrzeska 8',
                    'post_code' => '70-901',
                    'city' => 'Szczecin',
                    'krs' => "9876543210",
                    'regon' => "123456789",
                    'nip' => "9876543210",
                    'phone_number' => "987654321",
                    'description' => "Zajmujemy się szybkim i bezpiecznym transportem towarów.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'kontakt@speedytrans.pl',
                    'user_id' => 9,
                    'province_id' => 16, 
                ],
                [
                    'name' => 'Sklep Zoologiczny "ZooLife"',
                    'street' => 'Słoneczna 20',
                    'post_code' => '90-234',
                    'city' => 'Łódź',
                    'krs' => "9876543210",
                    'regon' => "123456789",
                    'nip' => "9876543210",
                    'phone_number' => "987654321",
                    'description' => "Znajdziesz u nas szeroki wybór produktów dla zwierząt domowych.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'sklep@zoolife.com',
                    'user_id' => 10,
                    'province_id' => 5,
                ],
                [
                    'name' => 'Restauracja "Smakosz"',
                    'street' => 'Podgórska 10',
                    'post_code' => '50-789',
                    'city' => 'Poznań',
                    'krs' => "9876543210",
                    'regon' => "123456789",
                    'nip' => "9876543210",
                    'phone_number' => "987654321",
                    'description' => "Oferta różnorodnych dań kuchni polskiej i światowej.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'kontakt@smakosz-restauracja.pl',
                    'user_id' => 11,
                    'province_id' => 15,
                ],
                [
                    'name' => 'Firma programistyczna "SoftwareHouse"',
                    'street' => 'Sportowa 5',
                    'post_code' => '02-345',
                    'city' => 'Gdańsk',
                    'krs' => "9876543210",
                    'regon' => "123456789",
                    'nip' => "9876543210",
                    'phone_number' => "987654321",
                    'description' => "Bogaty wybór sprzętu i odzieży sportowej dla wszystkich dyscyplin.",
                    'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
                    'avatar' => null,
                    'background_image' => null,
                    'contact_email' => 'sklep@sportmax.pl',
                    'user_id' => 12,
                    'province_id' => 11,
                ],
            ],
            'street'
        );
    }
}
