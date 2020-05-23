<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;
use App\Grupo;

class GrupoController extends BaseController
{
    public function store(request $request) {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:255'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Campo incorreto.', $validator->errors());
        }

        $grupo = Grupo::create([
            'nome' => $request->nome
        ]);

        $grupo->save();

        return $this::sendSucessResponse($grupo, 'Grupo criado com sucesso.', 201);
    }

    public function show(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $grupo = Grupo::find($request->id);
        if(!$grupo) {
            return $this::sendErrorResponse('Grupo não encontrado.', null);
        }

        return $this::sendSucessResponse($grupo, $grupo->empresas. 'Mostrando o grupo e suas empresas', 200);
    }

    public function update(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer', 
            'nome' => 'required|max:255'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $grupo = Grupo::find($request->id);
        if(!$grupo) {
            return $this::sendErrorResponse('Grupo não encontrado.', null);
        }

        $grupo->nome = $request->nome;
        $grupo->save();

        return $this::sendSucessResponse($grupo, $grupo->empresas. 'Grupo alterado com sucesso.', 200);
    }

    public function destroy(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $grupo = Grupo::find($request->id);
        if(!$grupo) {
            return $this::sendErrorResponse('Grupo não encontrado.', null);
        }

        $grupo->delete();   
        // como estamos usando o softDelete a linha não será realmente apagada
        // desse modo se quiser dá pra restaurar
        // usar forceDelete() se quiser apagar mesmo

        return $this::sendSucessResponse(null, 'Grupo deletado com sucesso.', 200);
    }

    public function index() {
        $grupos = Grupo::all();
        if($grupos->count() == 0) {
            return $this::sendErrorResponse('Não há grupos cadastrados.');
        }
        foreach($grupos as $grupo) {
            echo $this::sendSucessResponse($grupo, $grupo->empresas. 'Grupos cadastrados.', 200);
        }
    }
}
