<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_verpase;

class verpase_controller extends Controller
{
    public function index(){ 
        return view('verpase');
    }
    public function lista(){
        $verpase = m_verpase::join('alumnos','asisntencias.id_alumno','=','alumnos.id')
                            ->select('asisntencias.*','alumnos.nombre as nombre_alumno')
                            ->get();
        return $verpase;
    }
}
