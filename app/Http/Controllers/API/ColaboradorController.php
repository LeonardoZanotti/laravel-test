<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Empresa;
use App\Colaborador;
use App\Salario;

class ColaboradorController extends BaseController
{
    public function store(request $request) {
        $validator = Validator::make($request->all(), [
            'empresa_id' => 'required|integer',
            'nome' => 'required|max:255',
            'idade' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Campo incorreto.', $validator->errors());
        }

        $empresa = Empresa::find($request->empresa_id);
        if(!$empresa) {
            return $this::sendErrorResponse('Empresa não encontrada', null);
        }

        $colaborador = new Colaborador;
        $colaborador->nome = $request->nome;
        $colaborador->idade = $request->idade;

        $empresa = $empresa->colaboradores()->save($colaborador);

        return $this::sendSucessResponse($colaborador, $colaborador->empresa. 'Colaborador criado com sucesso.', 201);
    }

    public function show(request $request) {
        $validator = Validator::make($request->all(), [
            'empresa_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $empresa = Empresa::find($request->empresa_id);
        if(!$empresa) {
            return $this::sendErrorResponse('Empresa não encontrada.', null);
        }

        if($empresa->colaboradores->count() == 0) {
            return $this::sendErrorResponse('Nenhum colaborador cadastrado para esta empresa');
        }

        return $this::sendSucessResponse($empresa, $empresa->colaboradores. 'Mostrando os colaboradores da empresa', 200);
    }

    public function update(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer', 
            'nome' => 'required|max:255',
            'idade' => 'required|integer',
            'empresa_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $colaborador = Colaborador::find($request->id);
        $empresa = Empresa::find($request->empresa_id);
        if(!$colaborador || !$empresa) {
            return $this::sendErrorResponse('Colaborador ou empresa não encontrada.', null);
        }

        $colaborador->nome = $request->nome;
        $colaborador->idade = $request->idade;
        $colaborador->empresa()->associate($empresa)->save();

        return $this::sendSucessResponse($colaborador, $colaborador->empresa. 'Colaborador alterado com sucesso.', 200);
    }

    public function destroy(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $colaborador = Colaborador::find($request->id);
        if(!$colaborador) {
            return $this::sendErrorResponse('Colaborador não encontrado.', null);
        }

        $colaborador->delete();   
        // como estamos usando o softDelete a linha não será realmente apagada
        // desse modo se quiser dá pra restaurar
        // usar forceDelete() se quiser apagar mesmo

        return $this::sendSucessResponse(null, 'Colaborador deletado com sucesso.', 200);
    }

    public function index() {
        $empresas = Empresa::all();
        if($empresas->count() == 0) {
            return $this::sendErrorResponse('Não há empresas cadastradas.');
        }

        foreach($empresas as $empresa) {
            echo $this::sendSucessResponse($empresa, $empresa->colaboradores. 'Mostrando colaboradores das empresas', 200);
        }
    }
}
