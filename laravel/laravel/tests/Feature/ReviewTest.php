<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Review;
use App\Booking;
use App\Bookable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function testReviewShowSuccess()
    {
        $bookable = factory(Bookable::class)->create();
        $review = factory(Review::class)->create(['bookable_id' => $bookable->id]);

        $response = $this->getJson("/api/reviews/{$review->id}");

        $response->assertStatus(200);
    }

    public function testReviewShowNotFound()
    {
        $response = $this->getJson("/api/reviews/999"); // 存在しないidの確認

        $response->assertStatus(404);
    }

    public function testReviewStoreSuccess()
    {
        $bookable = factory(Bookable::class)->create();
        $booking = factory(Booking::class)->create([
            'bookable_id' => $bookable->id,
            'review_key' => 'testkey'
            ]);
        $data = [
            'id' => $booking->review_key,
            'content' => 'テストレビューです',
            'rating' => 5,
        ];

        Log::debug('Review Test Data', [
            'bookable' => $bookable->toArray(),
            'booking' => $booking->toArray(),
            'requestData' => $data
        ]);

        $response = $this->postJson('/api/reviews', $data);

        Log::debug('Test Review Store Success Response', ['response' => $response->getContent()]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('reviews', [
            'booking_id' => $booking->id,
            'content' => 'テストレビューです',
            'rating' => 5,
        ]);

        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id,
            'review_key' => 'testkey',
        ]);
    }

    public function testReviewStore400Failure()
    {
        $data = [
            'id' => 'invalid-review-key',
            'content' => 'エラー用のレビューです',
            'rating' => 3,
        ];

        $response = $this->postJson('/api/reviews', $data);

        $response->assertStatus(404);
    }

    public function testReviewStore500Failure()
    {
        DB::shouldReceive('beginTransaction')->once()->andThrow(new Exception('サーバーエラー'));

        $bookable = factory(Bookable::class)->create();
        $booking = factory(Booking::class)->create([
            'bookable_id' => $bookable->id,
            'review_key' => 'testkey'
        ]);
        $data = [
            'id' => $booking->review_key,
            'content' => 'テストレビューです',
            'rating' => 5,
        ];

        $response = $this->postJson('/api/reviews', $data);

        // 500系エラーが返ってくることを確認
        $response->assertStatus(500);
    }
}