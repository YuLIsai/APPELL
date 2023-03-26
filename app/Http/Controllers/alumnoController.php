<?php

namespace App\Http\Controllers;

use App\Models\m_alumno;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http\Models\Alumno;
use Illuminate\Support\Facades\Log;


class alumnoController extends Controller
{
    public function index()
    {
        return view('alumno');
    }


    /**
     * Consulta todos los alumnos en la base de datos
     * 
     * 
     * @return $alumno
     * 
     */
    public function lista()
    {
        try {
            $alumno = m_alumno::query()
            ->join('materias', 'alumnos.id_materia', '=', 'materias.id')
            ->select('alumnos.*', 'materias.nombre as nombre_materia')
            ->orderBy('id','asc')
            ->get();
            if ($alumno->isEmpty()) {
                return response()->json(['no_se_encontraron_datos']);
            } else {
                return $alumno;
            }
        return $alumno;
        } catch (Exception $e) {
            Log::error("No se pudieron obtener los registros de la base de datos");
            return response()->json(["error"=>$e],500);
        }
    }

     /**
     * Consulta un alumno en la base de datos
     * 
     * @param Request $request->id
     * @return $alumno
     * 
     */
    public function alumno(Request $request)
    {
        try{
            $alumno = m_alumno::find($request->id);
            return $alumno;
        }catch(Exception $e){
            Log::error("No se encontro el usuario con ID: ".$request->id." u/o Ocurrio un error en la base de datos");
            return response()->json(["error"=>$e], 500);
        }
       
    }
    /**
     * Guarda un nuevo registro en la base de datos
     * 
     * @param Request $request
     * @return $alumno
     * 
     */
    public function guardar(Request $request)
    {
        try {

            $exists = DB::table('alumnos')
                ->where('matricula')
                ->exists();
            
            $request->validate([
                'nombre' => ['required', 'max:90', 'string', 'regex:/^[a-zA-Z]+(\s*[a-zA-Z]+[áéíóúÁÉÍÓÚ]*)*[a-zA-ZñÑ]+$/'],
                'app' => ['required','max:90','string','regex:/^[a-zA-Z]+(\s*[a-zA-Z]+[áéíóúÁÉÍÓÚ]*)*[a-zA-ZñÑ]+$/'],
                'apm' => ['required','max:90','string','regex:/^[a-zA-Z]+(\s*[a-zA-Z]+[áéíóúÁÉÍÓÚ]*)*[a-zA-ZñÑ]+$/'],
                'matricula' => ['required', 'numeric', 'max_digits:10', 'min_digits:10'],
                'edad' => ['required', 'numeric', 'max_digits:2'],
                'sexo'=>['required','string','max:10'],
                'id_materia'=>['required','numeric'],
            ]);
            /**
             * if($exists){
                Log::warning("Intento de creación de registro duplicado en la base de datos \n-> METHOD: guardar() \n -> CONTROLLER: alumnosController.php");
                Log::error("Error -> codigo de respuesta: 409");
                return response()->json(['error' => 'el alumno ya fue registrado', 'estado' => ['code' => 409]], 409);
            *}
             */
            

            if ($request->id == 0) {
                $alumno = new m_alumno();
            } else {
                $alumno = m_alumno::find($request->id);
            }

            $alumno->nombre = $request->nombre;
            $alumno->app = $request->app;
            $alumno->apm = $request->apm;
            $alumno->matricula = $request->matricula;
            $alumno->sexo = $request->sexo;
            $alumno->edad = $request->edad;
            $alumno->id_materia = $request->id_materia;
            $alumno->save();

            return response()->json([$alumno],201);
        } catch (Exception $e) {
            Log::error("Error in \n CONTROLLER -> alumnoController.php \n METHOD -> guardar");
            return response()->json(['error'=>$e], 500);
        }
    }

    /**
     * Elimina un alumno en la base de datos
     * 
     * @param Request $request->id
     * @return any
     * 
     */
    public function borrar(Request $request)
    {
        try{
            $exists=DB::table('alumnos')->where('id',$request->id)->exists();
            if($exists){
                $alumno = m_alumno::find($request->id);
                $alumno->delete();
                Log::notice("Se elimino el alumno con ID: ".$request->id);
                return response()->json(['message'=>'success']);
            }else{
                Log::error('El alumno con ID: '.$request->id.' no existe en la base de datos');
            }
        }catch(Exception $e){
            Log::error("Error in \n CONTROLLER -> alumnoController.php \n METHOD -> borrar");
            return response()->json(['error'=>$e]);
        }
        
    }
}
