<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontDonationController extends Controller
{
    public function index(){
        return view('frontend.pages.donate');
    }
    public function store(Request $request) {}
}
