<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerTimeoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lastActivity = session('owner_last_activity');
        
        if ($lastActivity && now()->diffInMinutes($lastActivity) >= 30) {
            \Illuminate\Support\Facades\Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['email' => 'Your management session has expired for security reasons. Please log in again.']);
        }
        
        session(['owner_last_activity' => now()]);
        return $next($request);
    }
}
