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

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/roles', function(Request $request) {
        $user = $request->user();
        return $user->roles->makeHidden(['pivot', 'created_at', 'updated_at']);
    });

    Route::get('/permissions', function(Request $request) {
        $user = $request->user();
    
        $scopes_repository = new ScopesRepository();
        $scopes = $scopes_repository->getUniqueScopesForUser($user);
        
        return $scopes;
    });

});

Route::apiResource('curso', 'API\CursoController');
Route::apiResource('curso.modulo', 'API\ModuloController');
Route::apiResource('curso.modulo.material', 'API\MaterialController');

Route::apiResource('curso.grupo', 'API\CursoGrupoController');
Route::apiResource('grupo', 'API\GrupoController')->only(['index', 'show']);

Route::apiResource('inscripcion', 'API\InscripcionController');

Route::apiResource('unidad-duracion', 'API\UnidadDuracionController')->only([
    'index', 'show'
]);

Route::apiResource('imagen', 'API\ImagenController')->only([
    'index', 'show'
]);


Route::get('/test', function(Request $request){
    return \App\Curso::find(1)->grupos()->first()->alumnos;
});



Route::fallback(function(){
    return response()->json(['message' => 'Not found.'], 404);
})->name('api.fallback.404');

