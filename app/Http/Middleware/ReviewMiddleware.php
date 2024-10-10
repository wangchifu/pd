<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class ReviewMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->review=="1"){
                return $next($request);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('login');
        }
    }
}
