<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

class AuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user) {
            if ($user->role == 2) {
                return $next($request);
            } else {
                return redirect(url('/'));
            }
        } else {
            return redirect(url('/'));
        }
    }
}
