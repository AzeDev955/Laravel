<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class VerificarNumeroCasillas
{

    public function handle(Request $request, Closure $next): Response
    {

        $partida_id = $request->route('partida_id');
        $num1 = $request->route('num1');
        $num2 = $request->route('num2');
        if ($num1 != $num2) {
            $partida = DB::table('partida')->where('id', $partida_id)->first();
            if ($partida) {
                $casillasPartida = $partida->casillas;
                if ($num1 < 1 || $num1 > $casillasPartida) {
                    return response()->json([
                        'error' => 'Número de casilla 1 fuera de rango',
                        'num1' => $num1,
                        'rango_valido' => "1 a " . $casillasPartida
                    ], 400);
                }

                if ($num2 < 1 || $num2 > $casillasPartida) {
                    return response()->json([
                        'error' => 'Número de casilla 1 fuera de rango',
                        'num1' => $num1,
                        'rango_valido' => "1 a " . $casillasPartida
                    ], 400);
                }
                return $next($request);
            } else {
                return response()->json(['error' => 'Partida no encontrada'], 404);
            }
        } else {
            return response()->json([
                'error' => 'Pon dos numeros distintos'
            ], 404);
        }


    }
}
