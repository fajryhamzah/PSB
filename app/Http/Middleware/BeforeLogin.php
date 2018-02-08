<?php

namespace App\Http\Middleware;

use Closure;

class BeforeLogin
{
    public function handle($request, Closure $next)
    {
        if ($request->session()->exists('id')) {
          return redirect('/dashboard');
        }


        return $next($request);
    }
}
