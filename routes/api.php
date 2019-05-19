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

Route::apiResource('cursos', 'API\CursoController');
Route::apiResource('unidades-duracion', 'API\UnidadDuracionController')->only([
    'index', 'show'
])->parameters([
    'unidades-duracion' => 'unidadDuracion'
]);

Route::apiResource('imagenes', 'API\ImagenController')->only([
    'index', 'show'
])->parameters([
    'imagenes' => 'imagen'
]);


Route::get('/test', function(Request $request){
    $ultima_matricula = 100000;
    $ultima_matricula++;
    $matricula = 'CEIM-' . str_pad($ultima_matricula, 5, "0", STR_PAD_LEFT);
    return response()->json(['matricula' => $matricula]);
});








Route::fallback(function(){
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');
