<?php

namespace App\Http\Middleware;

use Closure;

class OperatorOnly
{
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('tipe') != 1) {
          return redirect('');
        }


        return $next($request);
    }
}
