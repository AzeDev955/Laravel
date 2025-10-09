<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ControladorPartida
{
    public function getPartida(Request $request, $id_partida)
    {
        $id_usuario = $request->input("id_usuario");
        $usuario = DB::table("usuario")->where("id", $id_usuario)->first();
        if ($usuario) {
            $partida = DB::table("partida")->where("id", $id_partida)->first();
            if ($partida->usuario_id == $id_usuario) {
                return response()->json([
                    "partida" => $partida,
                    "mensaje" => 'partida encontrada'
                ]);
            } else {
                return response()->json(['error' => 'La partida no existe o no es tuya'], 0);
            }

        } else {
            return response()->json(['error' => 'El usuario no existe']);
        }
    }

    public function getAllPartidas(Request $request)
    {
        $id_usuario = $request->input('usuario_id');
        $partidas = DB::table('partida')->where('id_usuario', $id_usuario)->get();
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
            $partida = DB::table('partida')->where('id', $partidaId)->first();
            return response()->json([
                'exito' => 'Partida creada con exito',
                'partida' => $partida
            ], 201);
        } else {
            return response()->json(['error' => 'No se ha podido crear una partida'], 500);
        }
    }
}
