<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Bookable;

class BookableAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testAvailabilityCheckSuccess()
    {
        $bookable = factory(Bookable::class)->create();

        $response = $this->json('GET', '/api/bookables/' . $bookable->id . '/availability', [
            'from' => '2024-01-01',
            'to' => '2024-01-05'
        ]);

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /**
     * @return void
     */
    public function testAvailabilityCheckFailure()
    {
        $bookable = factory(Bookable::class)->create();

        $response = $this->json('GET', '/api/bookables/' . $bookable->id . '/availability', [
            'from' => '2020-01-10',
            'to' => '2020-01-15'
        ]);

        $response->assertStatus(422);
    }
}
