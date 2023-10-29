<?php

namespace Tests\Feature;

use App\Models\Airport;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AirportDeleteTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_deletes_an_airport_successfully()
    {
        $airport = Airport::create([
            'iata_code' => 'MNO',
            'latitude' => 34.050000,
            'longitude' => -118.250000,
            'terms_conditions' => 'Some terms and conditions.'
        ]);

        $this->delete("/airports/{$airport->id}")
            ->seeStatusCode(204);
    }

    public function test_it_fails_to_delete_nonexistent_airport()
    {
        $this->delete('/airports/999999')
            ->seeStatusCode(404);
    }
}
