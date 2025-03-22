<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

    protected function getTranslatedLoginDescription(string $eventName): string
    {
        $descriptions = [
            'login' => 'قام المستخدم ":name" بتسجيل الدخول بنجاح.',
            'logout' => 'قام المستخدم ":name" بتسجيل الخروج بنجاح.',
        ];
        $user = Auth::user();
        $arDescription = $descriptions[$eventName] ?? 'حدث تسجيل دخول غير معروف.';
        return strtr($arDescription, [':name' => $user->name]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            if ($user && $user instanceof \Illuminate\Database\Eloquent\Model) {
                activity('auth')->performedOn($user)->causedBy($user)->withProperties([
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])->event('loggedin')->log($this->getTranslatedLoginDescription('login'));
            }
            $request->session()->regenerate();
            return $this->authenticated($request, $user) ?: redirect()->intended($this->redirectPath());
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = $this->guard()->user();
        if ($user && $user instanceof \Illuminate\Database\Eloquent\Model) {
            activity('auth')->performedOn($user)->causedBy($user)->withProperties([
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])->event('loggedout')->log($this->getTranslatedLoginDescription('logout'));
        }
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson() ? new JsonResponse([], 204) : redirect('/');
    }
}
