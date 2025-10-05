<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MiControlador extends Controller
{
    public function listar(){
        $personas = DB::table('personas')->orderBy('dni', 'asc')->get();

        $datos = [
            'personas' => $personas
        ];

        return response()->json($datos,200);
    }

    public function listarPersona($dni){
        $persona = DB::table('personas')->where('dni','=', $dni)->get();
        if($persona){
            return response()->json($persona,200);
        }else{
            $respuesta = 'La persona no existe';
            return response()->json([$respuesta]) ;
        }
        
        
    }

    public function insertar(){
        //en body de json
    }

    public function updatear(){
        //en body de json

    }

    public function deletear($dniPersona){

    }
}
