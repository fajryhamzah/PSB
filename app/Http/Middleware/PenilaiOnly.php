<?php

namespace App\Http\Middleware;

use Closure;

class PenilaiOnly
{
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('tipe') != 2) {
          
          return redirect('');
        }


        return $next($request);
    }
}
