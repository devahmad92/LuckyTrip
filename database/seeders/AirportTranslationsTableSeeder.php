<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AirportTranslation;
use Faker\Factory as Faker;

class AirportTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // assume you have 100 airports
        foreach (range(1, 100) as $index) {

            AirportTranslation::create([
                'airport_id' => $index,
                'language_code' => 'en',
                'name' => $faker->sentence(3),
                'description' => $faker->text
            ]);
            AirportTranslation::create([
                'airport_id' => $index,
                'language_code' => 'de',
                'name' => $faker->sentence(3),
                'description' => $faker->text
            ]);

            AirportTranslation::create([
                'airport_id' => $index,
                'language_code' => 'ar',
                'name' => $faker->sentence(3),
                'description' => $faker->text
            ]);

        }
    }
}
