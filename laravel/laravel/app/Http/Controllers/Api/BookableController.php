<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bookable;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;

class BookableController extends Controller
{
    public function index()
    {
        return BookableIndexResource::collection(
            Bookable::paginate(20)
        );
    }

    public function show($id)
    {
        return new BookableShowResource(Bookable::findOrFail($id));
    }
}
