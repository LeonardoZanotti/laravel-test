<?php

use Illuminate\Http\Request;

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

// AuthController
// Essas rotas podem ser acessados por usuários não autenticados
Route::post('login', 'API\AuthController@login');
Route::post('registro', 'API\AuthController@registro');

// As rotas dentro desse grupo precisam de autenticação
Route::middleware('auth:api')->group(function() {
    // GrupoController
    Route::post('grupo', 'API\GrupoController@show');
    Route::get('grupos', 'API\GrupoController@index');
    
    // EmpresaController
    Route::post('empresa', 'API\EmpresaController@show');
    Route::get('empresas', 'API\EmpresaController@index');
    
    // ColaboradorController
    Route::post('colaborador', 'API\ColaboradorController@show');
    Route::get('colaboradores', 'API\ColaboradorController@index');
    
    // SalarioController
    Route::post('salario', 'API\SalarioController@show');
    Route::get('salarios', 'API\SalarioController@index');

    // As rotas dentro desse grupo precisam de acesso de admin
    Route::middleware('admin')->group(function() {
        // UserController
        Route::get('users', 'API\UserController@index');

        // GrupoController
        Route::post('novoGrupo', 'API\GrupoController@store');
        Route::post('atualizarGrupo', 'API\GrupoController@update');
        Route::post('deletarGrupo', 'API\GrupoController@destroy');
        
        // EmpresaController
        Route::post('novaEmpresa', 'API\EmpresaController@store');
        Route::post('atualizarEmpresa', 'API\EmpresaController@update');
        Route::post('deletarEmpresa', 'API\EmpresaController@destroy');
        Route::post('removeGrupo', 'API\EmpresaController@removeGrupo');
        
        // ColaboradorController
        Route::post('novoColaborador', 'API\ColaboradorController@store');
        Route::post('atualizarColaborador', 'API\ColaboradorController@update');
        Route::post('deletarColaborador', 'API\ColaboradorController@destroy');
        
        // SalarioController
        Route::post('novoSalario', 'API\SalarioController@store');
        Route::post('atualizarSalario', 'API\SalarioController@update');
        Route::post('deletarSalario', 'API\SalarioController@destroy');
    });

    // AuthController
    Route::get('logout', 'API\AuthController@logout');
});