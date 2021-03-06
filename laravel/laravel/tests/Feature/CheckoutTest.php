<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    /**
     * 「GET /api/check」のテスト
     */

    // use RefreshDatabase;
    
    public function testCheckout(){
        
        // 「/api/check」にPOSTリクエストしてレスポンスを $response に代入
        $response = $this->post('/api/checkout', [
            'bookings' => [
              [
                'bookable_id' => 1,
                'from' => "2022-06-08",
                'to' => "2022-06-08"
              ]
            ],
          ]);

        // ステータスコードが200であることを検証
        $response->assertStatus(200);
    }
}
