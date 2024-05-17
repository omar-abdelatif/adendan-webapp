<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user() && $request->user()->role !== $role) {
            if ($request->user()->role === 'subscriptions') {
                return redirect()->route('subscriptionRole.index');
            } elseif ($request->user()->role === 'media') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect(RouteServiceProvider::HOME);
            }
        }
        return $next($request);
    }
}
