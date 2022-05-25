<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookableReviewTest extends TestCase
{
    /**
     * 「GET /api/bookables/○/reviews」のテスト
     */
    public function testBookableReview(){
        // 「/api/bookables/1/reviews」にGETリクエストしてレスポンスを $response に代入
        $response = $this->json('get', '/api/bookables/1/reviews');

        // ステータスコードが200であることを検証
        $response->assertStatus(200);

        // JSONのキー「data」に要素数8の配列が入っていることを検証
        $response->assertJsonCount(8, 'data');

        $response->assertJsonStructure([
            'data' => [
              '*' => [
                'created_at',
                'rating',
                'content',
              ],
            ],
        ]);
    }
}
