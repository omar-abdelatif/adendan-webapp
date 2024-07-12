<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request)
    {
        $url = '';
        if ($request->user()->role === 'subscriptions') {
            $url = 'admin/subscriptions/dashboard';
        } elseif ($request->user()->role === 'media') {
            $url = 'media/dashboard/main';
        } else {
            $url = 'admin/dashboard/main';
        }
        $notification = [
            'message' => "تم تسجيل الدخول",
            'alert-type' => 'success',
        ];
        return redirect()->intended($url)->with($notification);
    }
}
