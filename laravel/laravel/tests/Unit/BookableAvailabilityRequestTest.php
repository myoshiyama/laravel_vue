<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\BookableAvailabilityRequest;

class BookableAvailabilityRequestTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
    }

    public function testFromRequired() {
        $data = [
          'from' => null,
          'to' => null
        ];
        $request = new BookableAvailabilityRequest();
        $rules = $request->rules();
    
        $validator = Validator::make($data, $rules);
    
        // NGになることを検証
        $this->assertTrue($validator->fails());
    
        // NGになったバリデーションルールを検証
        $expectedFailed = [
          'from' => ['Required' => [],],
          'to' => ['Required' => [],],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }
}
