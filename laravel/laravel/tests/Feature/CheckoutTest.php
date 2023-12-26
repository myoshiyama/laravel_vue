<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Bookable;
use App\Booking;
use RuntimeException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckoutSuccess()
    {
        $bookable = factory(Bookable::class)->create();

        $response = $this->postJson('/api/checkout', [
            'bookings' => [
                [
                    'bookable_id' => $bookable->id,
                    'from' => '2024-01-01',
                    'to' => '2024-01-05',
                ],
            ],
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, Booking::all());
    }

    public function testCheckout400Failure()
    {
      $bookable = factory(Bookable::class)->create();

        $response = $this->postJson('/api/checkout', [
            'bookings' => [
                [
                    'bookable_id' => $bookable->id,
                    'from' => '2023-01-01',
                    'to' => '2023-01-05',
                ],
            ],
        ]);

        $response->assertStatus(422);
        $this->assertCount(0, Booking::all());
    }

    public function testCheckout500Failure()
    {
        $bookable = factory(Bookable::class)->create();

        // DBモック
        DB::partialMock()->shouldReceive('table->insert')
            ->andThrow(new RuntimeException('サーバーダウン'));

        $response = $this->postJson('/api/checkout', [
            'bookings' => [
                [
                    'bookable_id' => $bookable->id,
                    'from' => '2024-01-01',
                    'to' => '2024-01-05',
                ],
            ],
        ]);

        $response->assertStatus(500);
    }
}
