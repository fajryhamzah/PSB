<?php

namespace App\Http\Middleware;

use Closure;

class AfterLogin
{
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('id')) {
          return redirect('');
        }


        return $next($request);
    }
}
