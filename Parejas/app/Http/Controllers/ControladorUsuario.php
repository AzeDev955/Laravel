<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class ControladorUsuario extends Controller
{
    public static function getUsuario(Request $id){
        DB::table("usuario")->where("id",$id)->update([
    }
}
