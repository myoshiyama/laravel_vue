<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookableTest extends TestCase
{
    /**
     * 「GET /api/bookables」のテスト
     */
    public function testBookable() {
      // 「/api/bookables」にGETリクエストしてレスポンスを $response に代入
      $response = $this->json('get', '/api/bookables');
  
      // ステータスコードが200であることを検証
      $response->assertStatus(200);
  
      // JSONのキーが以下のようになっていることを検証
      $response->assertJsonStructure([
        'data' => [
          '*' => [
            'id',
            'title',
            'description',
          ],
        ],
      ]);
  
      // JSONのキー「data」に要素数100の配列が入っていることを検証
      $response->assertJsonCount(100, 'data');
    }
  
    /**
     * 「GET /api/bookables/1」のテスト
     */
    public function testBookableId() {
      // 「/api/bookables/1」にGETリクエストしてレスポンスを $response に代入
      $response = $this->json('get', '/api/bookables/1');
  
      // ステータスコードが200であることを検証
      $response->assertStatus(200);
  
      // レスポンスボディが引数と等しいことを検証
      $response->assertJson([
        'data' => [
          'id' => 1,
          'title' => '小泉市 bnb',
          'description' => 'Assumenda illo quia doloribus nulla quia sunt eos. Sequi blanditiis exercitationem excepturi nihil maxime dolorem.',
        ],
      ]);
    }
  }
