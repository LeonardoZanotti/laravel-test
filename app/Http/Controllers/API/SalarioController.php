<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Salario;
use App\Colaborador;

class SalarioController extends BaseController
{
    public function store(request $request) {
        $validator = Validator::make($request->all(), [
            'colaborador_id' => 'required|integer',
            'valor' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Campos incorretos.', $validator->errors());
        }

        $colaborador = Colaborador::find($request->colaborador_id);
        if(!$colaborador) {
            return $this::sendErrorResponse('Colaborador não encontrado', null);
        }

        if($colaborador->salario) {
            return $this::sendErrorResponse('Este colaborador já possui um salário');
        }

        $salario = new Salario;
        $salario->valor = $request->valor;

        $colaborador = $colaborador->salario()->save($salario);

        return $this::sendSucessResponse($salario, $salario->colaborador. 'Salário criado com sucesso.', 201);
    }

    public function show(request $request) {
        $validator = Validator::make($request->all(), [
            'colaborador_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erro de validação.', $validator->errors());
        }

        $colaborador = Colaborador::find($request->colaborador_id);
        if(!$colaborador) {
            return $this::sendErrorResponse('Colaborador não encontrado.', null);
        }

        if(!$colaborador->salario) {
            return $this::sendErrorResponse('Este colaborador não possui salário');
        }

        return $this::sendSucessResponse($colaborador, $colaborador->salario. 'Mostrando o salário do colaborador', 200);
    }

    public function update(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'valor' => 'required|integer',
            'colaborador_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $salario = Salario::find($request->id);
        $colaborador = Colaborador::find($request->colaborador_id);
        if(!$salario || !$colaborador) {
            return $this::sendErrorResponse('Salário ou Colaborador não encontrado.', null);
        }

        if($colaborador->salario) {
            $colaborador->salario->delete();
        }

        $salario->valor = $request->valor;
        $salario->colaborador()->associate($colaborador)->save();

        return $this::sendSucessResponse($salario, $salario->colaborador. 'Salário e colaborador alterados com sucesso.', 200);
    }

    public function destroy(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $salario = Salario::find($request->id);
        if(!$salario) {
            return $this::sendErrorResponse('Salário não encontrado.', null);
        }

        $salario->delete();   
        // como estamos usando o softDelete a linha não será realmente apagada
        // desse modo se quiser dá pra restaurar
        // usar forceDelete() se quiser apagar mesmo

        return $this::sendSucessResponse(null, 'Salário deletado com sucesso.', 200);
    }

    public function index() {
        $salarios = Salario::all();
        if($salarios->count() == 0) {
            return $this::sendErrorResponse('Não há salários cadastrados.');
        }

        foreach($salarios as $salario) {
            echo $this::sendSucessResponse($salario, $salario->colaborador. 'Mostrando salários dos colaboradores', 200);
        }
    }
}
