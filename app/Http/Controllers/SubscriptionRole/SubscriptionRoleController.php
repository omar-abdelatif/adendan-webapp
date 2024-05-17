<?php

namespace App\Http\Controllers\SubscriptionRole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionRoleController extends Controller
{
    public function RoleIndex()
    {
        return view('subscription_role.home');
    }
}
