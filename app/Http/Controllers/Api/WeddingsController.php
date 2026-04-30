<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wedding;

class WeddingsController extends Controller {
    public function index() {
        return response()->json(Wedding::all());
    }
}
