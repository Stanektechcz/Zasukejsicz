<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'country_name' => [
                    'cs' => 'Česká republika',
                    'en' => 'Czech Republic'
                ],
                'country_code' => 'CZ'
            ],
            [
                'country_name' => [
                    'cs' => 'Slovensko',
                    'en' => 'Slovakia'
                ],
                'country_code' => 'SK'
            ],
            [
                'country_name' => [
                    'cs' => 'Německo',
                    'en' => 'Germany'
                ],
                'country_code' => 'DE'
            ],
            [
                'country_name' => [
                    'cs' => 'Rakousko',
                    'en' => 'Austria'
                ],
                'country_code' => 'AT'
            ],
            [
                'country_name' => [
                    'cs' => 'Polsko',
                    'en' => 'Poland'
                ],
                'country_code' => 'PL'
            ],
        ];

        foreach ($countries as $countryData) {
            Country::create($countryData);
        }
    }
}
