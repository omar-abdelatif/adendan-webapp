<?php

namespace App\Http\Controllers\Api;

use App\Models\Tombs;
use App\Http\Controllers\Controller;

class TombController extends Controller {
    public function index() {
        return response()->json(Tombs::all());
    }
}
