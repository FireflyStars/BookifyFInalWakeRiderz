<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if(auth()->user())
        {
            if(auth()->user()->role->id === 1)
            {
                if(auth()->user()->is_active)
                {
                    return $next($request);
                }
                else
                {
                    return redirect()->route('accountDisabled');
                }
            }
            else
            {
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('login');
        }
    }
}