<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarNumeroPar
{

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->numeroCasillas % 2 == 0) {
            return $next($request);
        } else {
            return response('No has introducido un numero par', 403);
        }
    }
}
