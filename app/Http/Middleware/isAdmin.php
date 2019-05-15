<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isAdmin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check()) {
            if (Auth::user()->user_type == '1') {
//                dd(Auth::user());
                return $next($request);
            } else {
                return redirect('/');
            }
        }
        return redirect('/');
    }

}
