<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookablePriceTest extends TestCase
{
    /**
     * 「GET /api/bookables/○/price」のテスト
     */

    // 「/api/bookables/1/price"日付の条件"」にGETリクエストしてレスポンスを $response に代入

    //okパターン
    public function testBookablePriceOk(){
        $response = $this->json('get', '/api/bookables/1/price?from=2022-06-20&to=2022-06-20');

        // ステータスコードが200であることを検証
        $response->assertStatus(200);

        // レスポンスボディが引数と等しいことを検証
        $response->assertJson([
            'data' => [
              'total' => 162,
              'breakdown' => '162',
              'breakdown' =>
                array (
                    162 => 1,
                    ),
            ],
        ]);
    }

    //ngパターン
    public function testBookablePriceNg(){
        $response = $this->json('get', '/api/bookables/1/price?from=2022-06-20&to=2022-06-21');

        // ステータスコードが200であることを検証
        $response->assertStatus(200);

        // レスポンスボディが引数と等しいことを検証
        $response->assertJson([
            'data' => [
              'total' => 162,
              'breakdown' => '162',
              'breakdown' =>
                array (
                    162 => 2,
                    ),
            ],
        ]);
    }
}
