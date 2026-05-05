<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsComments;
use Illuminate\Http\Request;

class NewsCommentsController extends Controller {
    public function getComments(int $newsId) {
        $comments = NewsComments::where('news_id', $newsId)->get();
        return response()->json($comments);
    }
    public function store(Request $request, int $newsId) {
        $validatedData = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $comment = NewsComments::create([
            'author' => $validatedData['author'],
            'content' => $validatedData['content'],
            'news_id' => $newsId,
        ]);
        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment,
        ], 201);
    }
}
