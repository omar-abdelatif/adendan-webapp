<?php

namespace App\Http\Controllers\MediaRole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaRoleController extends Controller
{
    public function MediaRole(){
        return view('media_role.home');
    }
}
