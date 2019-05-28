<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FallbacksController extends Controller
{
    //
    public function RouteNotFound() {
        return response()->json(['message' => 'Not found.'], 404);
    }
}
