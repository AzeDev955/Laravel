<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MiControlador extends Controller
{
    public function listar()
    {
        $personas = DB::table('personas')->orderBy('dni', 'asc')->get();

        $datos = [
            'personas' => $personas
        ];

        return response()->json($datos, 200);
    }

    public function listarPersona($dni)
    {
        $persona = DB::table('personas')->where('dni', '=', $dni)->first();
        //get siempre devuelve una coleccion, hay que usar first si queremos validar si existe o no
        if ($persona) {
            return response()->json($persona, 200);
        } else {
            $respuesta = 'La persona no existe';
            return response()->json([$respuesta]);
        }
    }

    public function insertar(Request $data)
    {
        try {
            $validacion = $data->validate([
                'dni' => 'required|unique:personas',
                'nombre' => 'required',
                'tfno' => 'required',
                'edad' => 'required'
            ]);
            DB::table('personas')->insert($validacion);

            return response()->json([
                'success' => true,
                'message' => 'Persona insertada correctamente'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al insertar: ' . $e->getMessage()
            ], 404);
        }
    }

    public function updatear(Request $data)
    {
        $validacion = $data->validate([
            'dni' => 'required',
            'nombre' => 'required',
            'tfno' => 'required',
            'edad' => 'required'
        ]);
        $dni = $validacion['dni'];
        $persona = DB::table('personas')->where('dni', '=', $dni)->first();

        if ($persona) {
            DB::table('personas')->where('dni', '=', $dni)->update([
                'dni' => $data['dni'],
                'nombre' => $data['nombre'],
                'tfno' => $data['tfno'],
                'edad' => $data['edad']
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Persona actualizada correctamente'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Persona no encontrada'
            ], 404);
        }
    }

    public function deletear($dniPersona)
    {
        $deleted = DB::table('personas')->where('dni', '=', $dniPersona)->delete();
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Persona eliminada correctamente'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Persona no encontrada'
            ], 500);
        }
    }
}
