<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookableAvailabilityTest extends TestCase
{
    /**
     * 「GET /api/bookables/○/availability」のテスト
     */

    // 「/api/bookables/1/availability"日付の条件"」にGETリクエストしてレスポンスを $response に代入

    //OKパターン
    public function testBookableAvailabilityOk(){
        $response = $this->json('get', '/api/bookables/1/availability?from=2022-06-20&to=2022-06-20');

        // ステータスコードが200であることを検証
        $response->assertStatus(200);
    }

    //NHパターン
    public function testBookableAvailabilityNg(){
        $response = $this->json('get', '/api/bookables/1/availability?from=2022-06-18&to=2022-06-18');

        // ステータスコードが200であることを検証
        $response->assertStatus(200);
    }
}
