<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //dump($request->cookie()['XSRF-TOKEN']);

        if ($request->input('token') !== 'my-secret-token') {
            return redirect('/');
        }

        // замыкание
        return $next($request);
    }
}
