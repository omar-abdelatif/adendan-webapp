<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use App\Http\Controllers\Controller;

class NewsController extends Controller {
    public function allNews(){
        return response()->json(News::all());
    }
    public function show(int $id){
        return response()->json(News::find($id));
    }
}
