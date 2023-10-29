<?php

namespace Tests\Feature;

use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AirportCreateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_creates_an_airport_successfully()
    {
        $data = [
            'iata_code' => 'ABC',
            'latitude' => 12.345678,
            'longitude' => 98.765432,
            'terms_conditions' => 'Sample terms and conditions.',
            'translations' => [
                [
                    'language_code' => 'en',
                    'name' => 'Test Airport',
                    'description' => 'Description in English'
                ],
            ]
        ];

        $this->post('/airports', $data)
            ->seeStatusCode(201)
            ->seeJson(['iata_code' => 'ABC']);
    }

    public function test_it_rejects_creation_for_invalid_data()
    {
        $invalidData = [];

        $this->post('/airports', $invalidData)
            ->seeStatusCode(422);
    }

    public function test_it_prevents_duplicate_airport_creation()
    {
        $data = [
            'iata_code' => 'DEF',
            'latitude' => '23.456789',
            'longitude' => '87.654321',
        ];

        $this->post('/airports', $data);

        $this->post('/airports', $data)
            ->seeStatusCode(422);
    }
}
