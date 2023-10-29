<?php

namespace Tests\Feature;

use App\Models\Airport;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AirportUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_updates_an_airport_successfully()
    {
        $airport = Airport::create([
            'iata_code' => 'GHI',
            'latitude' => 34.050000,
            'longitude' => -118.250000,
            'terms_conditions' => 'Original terms and conditions.'
        ]);

        $updateData = [
            'iata_code' => 'GHJ',
            'latitude' => 35.000000,
            'longitude' => -117.000000,
            'terms_conditions' => 'Updated terms and conditions.'
        ];

        $this->put("/airports/{$airport->id}", $updateData)
            ->seeStatusCode(200)
            ->seeJson($updateData);
    }

    public function test_it_fails_to_update_nonexistent_airport()
    {
        $updateData = [
            'iata_code' => 'GKL',
            'latitude' => 36.000000,
            'longitude' => -116.000000,
            'terms_conditions' => 'Some terms and conditions.'
        ];

        $this->put('/airports/999999', $updateData)
            ->seeStatusCode(404);
    }
}
