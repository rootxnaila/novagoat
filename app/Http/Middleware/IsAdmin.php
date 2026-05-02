<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role === 'admin') {
            //admin =  masuk ke API
            return $next($request);
        }

        //bukan admin error
        return response()->json([
            'message' => 'Akses Ditolak! Fitur ini khusus Admin Peternakan.'
        ], 403); 
    }
}