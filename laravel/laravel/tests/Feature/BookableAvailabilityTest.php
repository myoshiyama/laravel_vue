<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Bookable;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class BookableAvailabilityTest extends TestCase
{
    use RefreshDatabase;

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
    public function testAvailabilityCheck400Failure()
    {
        $bookable = factory(Bookable::class)->create();

        $response = $this->json('GET', '/api/bookables/' . $bookable->id . '/availability', [
            'from' => '2020-01-10',
            'to' => '2020-01-15'
        ]);

        $response->assertStatus(422);
    }

    public function testAvailabilityCheck500Failure()
    {
        $bookableId = 1; // テスト用

        $bookableMock = $this->mock(Bookable::class);
        $bookableMock->shouldReceive('findOrFail')
                    ->with($bookableId)
                    ->andReturnSelf();

        $bookableMock->shouldReceive('availableFor')
                    ->andThrow(new RuntimeException('サーバーダウン'));

        $response = $this->json('GET', '/api/bookables/' . $bookableId . '/availability', [
            'from' => '2024-01-01',
            'to' => '2024-01-05'
        ]);

        // 500系エラーが返ってくることを確認
        $response->assertStatus(500);
    }
}