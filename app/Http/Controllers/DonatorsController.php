<?php

namespace App\Http\Controllers;

use App\Models\Donators;
use Illuminate\Http\Request;

class DonatorsController extends Controller
{
    public function index()
    {
        $allDonators = Donators::all();
        return view('pages.donations.donators', compact('allDonators'));
    }
    public function storeDonator(){}
}
