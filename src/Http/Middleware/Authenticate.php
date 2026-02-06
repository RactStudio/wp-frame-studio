<?php

namespace RactStudio\FrameStudio\Http\Middleware;

use RactStudio\FrameStudio\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \RactStudio\FrameStudio\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        if (! Auth::check()) {
           // Redirect or throw exception
           // For API usually return 401
           return new \RactStudio\FrameStudio\Http\Response('Unauthorized', 401);
        }

        return $next($request);
    }
}
