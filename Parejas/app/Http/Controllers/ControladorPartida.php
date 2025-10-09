<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ControladorPartida
{
    public function getPartida(Request $request, $id_partida)
    {
        $id_usuario = $request->input("usuario_id");
        $usuario = DB::table("usuario")->where("id", $id_usuario)->first();
        if ($usuario) {
            $partida = DB::table("partida")->where("id", $id_partida)->first();
            if ($partida->usuario_id == $id_usuario) {
                return response()->json([
                    "partida" => $partida,
                    "mensaje" => 'partida encontrada'
                ]);
            } else {
                return response()->json(['error' => 'La partida no existe o no es tuya'], 405);
            }

        } else {
            return response()->json(['error' => 'El usuario no existe']);
        }
    }

    public function getAllPartidas(Request $request)
    {
        $id_usuario = $request->input('usuario_id');
        $partidas = DB::table('partida')->where('usuario_id', $id_usuario)->get();
        return response()->json($partidas);
    }

    public function crearPartida(Request $request, $numeroCasillas)
    {
        $id_usuario = $request->input('usuario_id');
        $partidaId = DB::table('partida')->insertGetId([
            'usuario_id' => $id_usuario,
            'estado' => 'activa',
            'casillas' => $numeroCasillas,
            'intentos' => 0
        ]);
        if ($partidaId) {
            for ($i = 0; $i < $numeroCasillas / 2; $i++) {
                $valores[] = $i;
                $valores[] = $i;
            }
            shuffle($valores);
            for ($i = 0; $i < $numeroCasillas; $i++) {
                DB::table('casilla')->insert([
                    'partida_id' => $partidaId,
                    'numero_contenido' => $valores[$i],
                    'posicion' => $i,
                    'destapada' => false
                ]);
            }
            $partida = DB::table('partida')->where('id', $partidaId)->first();
            return response()->json([
                'exito' => 'Partida creada con exito',
                'partida' => $partida
            ], 201);
        } else {
            return response()->json(['error' => 'No se ha podido crear una partida'], 500);
        }
    }

    public function destaparCasilla(Request $request, $partida_id, $num1, $num2)
    {
        $posicion1 = $num1 - 1;
        $posicion2 = $num2 - 1;

        $casilla1 = DB::table('casilla')
            ->where('partida_id', $partida_id)
            ->where('posicion', $posicion1)
            ->first();

        $casilla2 = DB::table('casilla')
            ->where('partida_id', $partida_id)
            ->where('posicion', $posicion2)
            ->first();

        if (!$casilla1 || !$casilla2) {
            return response()->json(['error' => 'Alguna casilla no existe'], 400);
        }

        if ($casilla1->destapada || $casilla2->destapada) {
            return response()->json(['error' => 'Alguna casilla ya esta destapada'], 400);
        }

        DB::table('partida')
            ->where('id', $partida_id)
            ->increment('intentos');

        if ($casilla1->numero_contenido == $casilla2->numero_contenido) {
            DB::table('casilla')
                ->where('partida_id', $partida_id)
                ->where('posicion', $posicion1)
                ->update(['destapada' => true]);

            DB::table('casilla')
                ->where('partida_id', $partida_id)
                ->where('posicion', $posicion2)
                ->update(['destapada' => true]);


            return response()->json([
                'exito' => 'Pareja encontrada',
                'casilla 1' => $casilla1->numero_contenido,
                'casilla 2' => $casilla2->numero_contenido,

            ], 200);
        } else {
            return response()->json([
                'fallo' => 'No son pareja',
                'casilla 1' => $casilla1->numero_contenido,
                'casilla 2' => $casilla2->numero_contenido,
            ], 400);
        }
    }
}
