<?php

namespace App\Http\Middleware;

use Closure;

class UserCheck

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

        if (session()->has('user')){
            return $next($request);
        }else{
            return redirect()->route('LoginPage')->withErrors('У вас нет доступа');
        }
    }
}
