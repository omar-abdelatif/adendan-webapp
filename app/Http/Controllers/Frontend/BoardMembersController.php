<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BoardMembers;
use Illuminate\Http\Request;

class BoardMembersController extends Controller
{
    public function index()
    {
        $boards = BoardMembers::all();
        return view('frontend.pages.board_members', compact('boards'));
    }
}
