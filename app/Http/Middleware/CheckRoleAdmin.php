<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleAdmin
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

        if(session()->get('userlogin')){
            $role = session()->get('userlogin');
            if( $role->Role == "ADMIN"){
                return $next($request);
            }
            else
            {
                return redirect("login");
            }
        }
        else
        {
            return redirect("login");
        }
    }
}
