<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\alumnoController;
use App\Http\Controllers\maestroController;
use App\Http\Controllers\materiaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/alumnos', [alumnoController::class, 'lista']);
Route::get('/alumno', [alumnoController::class, 'alumno']);
Route::post('/alumno', [alumnoController::class, 'guardar']);
Route::post('/alumno/borrar', [alumnoController::class, 'borrar']);

Route::get('/maestros', [maestroController::class, 'lista']);
Route::get('/maestro', [maestroController::class, 'maestro']);
Route::post('/maestro', [maestroController::class, 'guardar']);
Route::post('/maestro/borrar', [maestroController::class, 'borrar']);

Route::get('/materias', [materiaController::class, 'lista']);
Route::get('/materia', [materiaController::class, 'materia']);
Route::post('/materia', [materiaController::class, 'guardar']);
Route::post('/materia/borrar', [materiaController::class, 'borrar']);

Route::get('/combo_materias', [materiaController::class, 'combo']);

Route::post('login', function(Request $request){
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $user = Auth::user();
        $arr = array('acceso' => "Ok", 'error' => "");

        return json_encode($arr);
    }
    else{

        $arr = array('acceso' => "", 'error' => "No existe el usuario o contraseña");
        return json_encode($arr);
    }
}); 