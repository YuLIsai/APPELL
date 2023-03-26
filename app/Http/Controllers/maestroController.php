<?php

namespace App\Http\Controllers;

use App\Models\m_maestro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class maestroController extends Controller
{
    public function index(){ 
        return view('maestro');
    }
    public function lista(){
        try {
            $maestro = m_maestro::query()
                ->join('materias', 'maestros.id_materia', '=', 'materias.id')
                ->select('maestros.*', 'materias.nombre as nombre_materia')
                ->get();
            if ($maestro->isEmpty()) {
                return response()->json(['no_se_encontraron_datos']);
            } else {
                return $maestro;
            }
            Log::alert("Se realizo una peticion para obtener los datos de las materias");
            return $maestro;
        } catch (Exception $e) {
            Log::error("No se pudieron obtener los registros de la base de datos");
            return response()->json(["error" => $e], 404);
        }
    }
    public function maestro (Request $request){
        try {
            $maestro = m_maestro::find($request->id);
            return $maestro;
        } catch (Exception $e) {
            Log::error("No se encontro el usuario con ID: " . $request->id . " u/o Ocurrio un error en la base de datos");
            return response()->json(["error" => $e], 404);
        }
    }
    public function guardar(Request $request){
        try {
            $exists = DB::table('maestros')
                ->where('nocedula',$request->nocedula)
                ->exists();
            $request->validate([
                'nombremae' => ['required', 'max:90', 'string', 'regex:/^[a-zA-Z]+(\s*[a-zA-ZÁÉÍÓÚáéíúó]*)*[a-zA-ZñÑ]+$/'],
                'app' => ['required', 'max:90', 'string', 'regex:/^[a-zA-Z]+(\s*[a-zA-ZÁÉÍÓÚáéíúó]*)*[a-zA-ZñÑ]+$/'],
                'apm' => ['required', 'max:90', 'string', 'regex:/^[a-zA-Z]+(\s*[a-zA-ZÁÉÍÓÚáéíúó]*)*[a-zA-ZñÑ]+$/'],
                'nocedula' => ['required', 'numeric', 'max_digits:10', 'min_digits:10'],
                'edad' => ['required', 'numeric', 'max_digits:2'],
                'sexo' => ['required', 'string', 'max:10'],
                'id_materia' => ['required'],
            ]);
            /**
             *   if ($exists) {
                Log::warning("Intento de creación de registro duplicado en la base de datos \n-> METHOD: guardar() \n -> CONTROLLER: alumnosController.php");
                Log::error("Error -> codigo de respuesta: 409");
                return response()->json(['error' => 'el alumno ya fue registrado', 'estado' => ['code' => 409]], 409);
            }
             */
          
            if ($request->id == 0) {
                $maestro = new m_maestro();
            } else {
                $maestro = m_maestro::find($request->id);
            }

            $maestro->nombremae = $request->nombremae;
            $maestro->app = $request->app;
            $maestro->apm = $request->apm;
            $maestro->nocedula = $request->nocedula;
            $maestro->sexo = $request->sexo;
            $maestro->edad = $request->edad;
            $maestro->id_materia = $request->json('id_materia.code');

            $maestro->save();

            return response()->json([$maestro], 201);
        } catch (Exception $e) {
            Log::error("Error in \n CONTROLLER -> maestroController.php \n METHOD -> guardar");
            return response()->json(['error' => $e], 409);
        }
        
    }
    public function borrar(Request $request){
        try {
            $exists = DB::table('maestros')->where('id', $request->id)->exists();
            if ($exists) {
                $maestro = m_maestro::find($request->id);
                $maestro->delete();
                Log::notice("Se elimino el maestro con ID: " . $request->id);
                return response()->json(['message' => 'success']);
            } else {
                Log::error('El maestro con ID: ' . $request->id . ' no existe en la base de datos');
            }
        } catch (\Throwable $th) {
            Log::error("Error in \n CONTROLLER -> maestroController.php \n METHOD -> borrar");
            return response()->json(['error' => $th], 500);
        }
    }
}
