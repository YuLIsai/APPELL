<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asisntencia;
use App\Models\Asistencia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AsisntenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Alumno::query()->join('materias', 'alumnos.id_materia', '=', 'materias.id')
            ->where('id_materia', '=', $request->id_materia)
            ->select('alumnos.*', 'materias.nombre as nombre_materia')
            ->get();

        Log::alert("Se realizo una consulta para pase de lista");
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_alumno'=>['required'],
                'asistio'=>['required','boolean']
            ]);

            $asistencia = new Asisntencia();
            $asistencia->id_alumno =$request->id_alumno;
            $asistencia->asistio=$request->asistio;
            $asistencia->fecha=now();
            $asistencia->save();
            Log::info("Se ha creado un nuevo registro en la tabla asistencias");
            return response()->json($asistencia, 201);
        } catch (Exception $th) {
            Log::error("Sucedio un error en AsistenciaController.php");
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function show(Asisntencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asisntencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asisntencia $asistencia)
    {
        //
    }
}
