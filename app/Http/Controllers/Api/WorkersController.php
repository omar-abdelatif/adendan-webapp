<?php

namespace App\Http\Controllers\Api;

use App\Models\Worker;
use App\Http\Controllers\Controller;

class WorkersController extends Controller {
    public function index() {
        return response()->json(Worker::all());
    }
}
