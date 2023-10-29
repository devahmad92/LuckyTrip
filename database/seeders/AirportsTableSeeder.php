<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airport;
use Faker\Factory as Faker;

class AirportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            Airport::create([
                'iata_code' => strtoupper($faker->lexify('???')),
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'terms_conditions' => $faker->text
            ]);
        }
    }
}
