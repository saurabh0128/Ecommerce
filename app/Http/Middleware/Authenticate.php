<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;


class Authenticate //extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     * 
     * 
     */

    public function handle(Request $request, Closure $next)
    {
        $id = Auth::id();

       if($id)
       { 
            return $next($request);
       }
       else {
            throw new HttpException(404);
        } 
    }


    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('admin.login.index');
        }
    }
   
}
