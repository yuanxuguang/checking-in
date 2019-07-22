<?php

namespace App\Http\Middleware;

use Closure;

class login
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
        if($request->session()->has('eid')){
            return $next($request);
        }else{
            return redirect('/loginView')->with('error','登陆已过期,请重新登陆');
        }

    }
}
