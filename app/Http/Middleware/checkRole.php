<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role)
        {
            if (!Auth::check()) {
                return redirect('/login'); // atau response 401
            }
            // Jika peran user tidak sesuai, kembalikan Unauthorized

            if (!in_array(auth()->user()->role_id, $role)) {
               return redirect('/dashboard')->with('error', 'Unauthorized');
            }
            return $next($request);
    }
}
