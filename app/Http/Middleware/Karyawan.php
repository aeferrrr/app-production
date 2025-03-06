<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Karyawan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illumi nate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth()->user()->role=='karyawan') {
            return $next($request);
        }
        abort(401);
    }
}
