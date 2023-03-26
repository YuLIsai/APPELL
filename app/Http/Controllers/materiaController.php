<?php

namespace App\Http\Controllers;

use App\Models\m_materia;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class materiaController extends Controller
{
    public function index(){ 
        return view('materia');
    }
    public function lista(){
        try {
            $materia = m_materia::all();
            if ($materia->isEmpty()) {
                return response()->json(['no_se_encontraron_datos']);
            } else {
                return $materia;
            }
            return $materia;
        } catch (Exception $e) {
            Log::error("No se pudieron obtener los registros de la base de datos");
            return response()->json(["error" => $e], 404);
        }
    }
    public function materia (Request $request){
        try {
            $materia = m_materia::find($request->id);
            return $materia;
        } catch (Exception $e) {
            Log::error("No se encontro el usuario con ID: " . $request->id . " u/o Ocurrio un error en la base de datos");
            return response()->json(["error" => $e], 500);
        }
    }
    public function guardar(Request $request){
        try {
            $exists = DB::table('materias')
                ->where('nombre',$request->nombre)
                ->exists();
            $request->validate([
                'nombre' => ['required', 'max:90', 'string', 'regex:/^[a-zA-Z]+(\s*[a-zA-ZÁÉÍÓÚáéíúó]*)*[a-zA-ZñÑ]+$/'],
                'duracion' => ['required', 'max:90', 'string', 'regex:/^[a-zA-Z0-9]+(\s*[a-zA-ZÁÉÍÓÚáéíúó]*)*[a-zA-ZñÑ]+$/'],
                'dias' => ['required', 'numeric', 'max_digits:3'],
            ]);
            /**
             * if ($exists) {
                Log::warning("Intento de creación de registro duplicado en la base de datos \n-> METHOD: guardar() \n -> CONTROLLER: alumnosController.php");
                Log::error("Error -> codigo de respuesta: 409");
                return response()->json(['error' => 'la materia ya fue registrada', 'estado' => ['code' => 409]], 409);
            }
             */
            if ($request->id == 0) {
                $materia = new m_materia();
            } else {
                $materia = m_materia::find($request->id);
            }

            $materia->nombre = $request->nombre;
            $materia->duracion = $request->duracion;
            $materia->dias = $request->dias;

            $materia->save();

            return response()->json([$materia], 201);
        } catch (Exception $th) {
            Log::error("Error in \n CONTROLLER -> materiaController.php \n METHOD -> guardar");
            return response()->json(['error' => $th], 500);
        }
        
    }
    public function borrar(Request $request){

        try {
            $exists = DB::table('materias')->where('id', $request->id)->exists();
            if ($exists) {
                $materia = m_materia::find($request->id);
                $materia->delete();
                Log::notice("Se elimino el alumno con ID: " . $request->id);
                return response()->json(['message' => 'success']);
            } else {
                Log::error('La materia con ID: ' . $request->id . ' no existe en la base de datos');
            }
        } catch (Exception $e) {
            Log::error("Error in \n CONTROLLER -> materiaController.php \n METHOD -> borrar");
            return response()->json(['error' => $e]);
        }
    }
    public function combo(){
        
        try{
            $materias = m_materia::select('nombre as name', 'id as code')->get();
            return $materias;
        }catch(Exception $e){
            Log::error("Error in \n CONTROLLER -> materiaController.php \n METHOD -> combo");
            return response()->json(['error' => $e]);
        }
    }
}
