<?php

namespace Tests\Feature;

use App\Models\Airport;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AirportShowTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_shows_an_airport_successfully()
    {
        $airport = Airport::create([
            'iata_code' => 'XYZ',
            'latitude' => '34.050000',
            'longitude' => '-118.250000'
        ]);

        $this->get("/airports/{$airport->id}")
            ->seeStatusCode(200)
            ->seeJson([
                'iata_code' => 'XYZ',
                'latitude' => '34.050000',
                'longitude' => '-118.250000'
            ]);
    }

    public function test_it_returns_not_found_for_non_existent_airport()
    {
        $this->get('/airports/999999')
            ->seeStatusCode(404);
    }

    public function test_it_handles_invalid_id_format()
    {
        $this->get('/airports/invalid-id')
            ->seeStatusCode(400);
    }
}
