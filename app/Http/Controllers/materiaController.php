<?php

namespace App\Http\Controllers;

use App\Models\m_materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http\Models\Materia;

class materiaController extends Controller
{
    public function index(){ 
        return view('materia');
    }
    public function lista(){
        $materia = m_materia::all();
        return $materia;
    }
    public function materia (Request $request){
        $materia = m_materia::find($request->id);
        return $materia;
    }
    public function guardar(Request $request){
        if($request->id == 0){
            $materia = new m_materia();
        }
        else {
            $materia = m_materia::find($request->id);
        }

        $materia->nombre = $request->nombre;
        $materia->duracion = $request->duracion;
        $materia->profesor = $request->profesor;
        $materia->dias = $request->dias;
    
        $materia->save();

        return $materia;
        
    }
    public function borrar(Request $request){

        $materia = m_materia::find($request->id);
        $materia ->delete();
        return "OK";
    }
    public function combo(){
        
        $materias = m_materia::select('nombre as name', 'id as code')->get();

        return $materias;
    }
}
