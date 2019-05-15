<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckUserType {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check()) {
            if (Auth::user()->user_type == '2' || Auth::user()->user_type == '3') {
                return $next($request);
            } else {
                return redirect('/');
            }
        }
        return redirect('/');
    }

}
