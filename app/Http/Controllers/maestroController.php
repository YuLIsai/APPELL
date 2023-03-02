<?php

namespace App\Http\Controllers;

use App\Models\m_maestro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http\Models\Maestro;

class maestroController extends Controller
{
    public function index(){ 
        return view('maestro');
    }
    public function lista(){
        $maestro = m_maestro::join('materias','maestros.id_materia','=','materias.id')
                            ->select('maestros.*','materias.nombre as nombre_materia')
                            ->get();

        return $maestro;
    }
    public function maestro (Request $request){
        $maestro = m_maestro::find($request->id);
        return $maestro;
    }
    public function guardar(Request $request){
        if($request->id == 0){
            $maestro = new m_maestro();
        }
        else {
            $maestro = m_maestro::find($request->id);
        }

        $maestro->nombremae = $request->nombremae;
        $maestro->app = $request->app;
        $maestro->apm = $request->apm;
        $maestro->nocedula = $request->nocedula;
        $maestro->sexo = $request->sexo;
        $maestro->edad = $request->edad;

        $maestro->id_materia = $request->id_materia;
    
        $maestro->save();

        return $maestro;
        
    }
    public function borrar(Request $request){

        $maestro = m_maestro::find($request->id);
        $maestro ->delete();
        return "OK";
    }
}
