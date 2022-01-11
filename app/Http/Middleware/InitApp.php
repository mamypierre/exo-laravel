<?php

namespace App\Http\Middleware;

use App\Events\UserAccess;
use Closure;

class InitApp
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
        event(new UserAccess);
        return $next($request);
    }
}
