<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasAnyRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! in_array($request->user()->role_id, $roles)) {
            return redirect('home')->with('error', "Access denied");
        }

        return $next($request);
    }
}
