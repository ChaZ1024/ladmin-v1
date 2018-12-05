<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminAuthMiddleware
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
        if(!Session::get('userInfo')){
            return redirect("/login");
        }
        else{

            $userHasNode=Session::get('userHasNode');
            if($userHasNode=='all'){
                return $next($request);
            }else{
                $sysNode=Session::get('sysNode');
                if(in_array('/'.$request->path(),$sysNode)){
                    if(in_array('/'.$request->path(),$userHasNode)){
                        return $next($request);
                    }else{
                        return redirect("/noauth");
                    }
                }else{
                    return $next($request);
                }

            }

        }

    }
}
