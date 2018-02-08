<?php

namespace App\Http\Middleware;

use Closure;

class SiswaOnly
{
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('tipe') != 3) {
          return redirect('');
        }


        return $next($request);
    }
}
