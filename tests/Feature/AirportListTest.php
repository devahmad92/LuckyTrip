<?php

namespace Tests\Feature;

use App\Models\Airport;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AirportListTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_lists_airports()
    {
        Airport::create([
            'iata_code' => 'PQR',
            'latitude' => 35.050000,
            'longitude' => -119.250000,
            'terms_conditions' => 'Some terms and conditions.'
        ]);

        $response = $this->get('/airports');

        $response->seeStatusCode(200);
    }
}
