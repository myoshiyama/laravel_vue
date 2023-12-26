<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookableAvailabilityRequest;
use Illuminate\Http\Request;
use App\Bookable;
use RuntimeException;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, BookableAvailabilityRequest $request)
    {
        $data = $request->all();

        try {
            $bookable = Bookable::findOrFail($id);

            return $bookable->availableFor($data['from'], $data['to'])
                ? response()->json([])
                : response()->json([], 404);
        } catch (RuntimeException $e) {
            // 500系のエラーをキャッチ
            return response()->json(['message' => 'サーバーエラーが発生しました。'], 500);
        }
    }
}
