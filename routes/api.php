<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Repositories\ScopesRepository;

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

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('/logout', 'AuthController@logout');
    Route::get('/cuenta', 'API\CuentaController@index');
    Route::put('/cuenta', 'API\CuentaController@update');
    Route::get('/roles', 'API\CuentaController@roles');
    Route::get('/permisos', 'API\CuentaController@scopes');

    Route::apiResource('usuario', 'API\UserController')->only(['show']);

    Route::apiResource('maestro/grupo', 'API\MaestroGrupoController')->only(['index', 'show']);
    Route::apiResource('alumno/grupo', 'API\AlumnoGrupoController')->only(['index', 'show']);
    Route::apiResource('alumno/grupo.comentario', 'API\ComentarioGrupoController')->only(['index', 'store', 'update']);

    Route::apiResource('inscripcion', 'API\InscripcionController');

    Route::apiResource('curso', 'API\CursoController');
    Route::apiResource('curso.modulo', 'API\ModuloController');
    Route::apiResource('curso.modulo.material', 'API\MaterialController');
    Route::apiResource('curso.grupo', 'API\CursoGrupoController');
});


Route::apiResource('unidad-duracion', 'API\UnidadDuracionController')->only([
    'index', 'show'
]);

Route::apiResource('imagen', 'API\ImagenController')->only([
    'index', 'show'
]);



Route::fallback('FallbacksController@RouteNotFound')->name('api.fallback.404');

