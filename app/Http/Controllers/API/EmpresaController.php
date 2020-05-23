<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Empresa;
use App\Grupo;

class EmpresaController extends BaseController
{
    public function store(request $request) {
        $validator = Validator::make($request->all(), [
            'grupo_id' => 'required|integer',
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Campo incorreto.', $validator->errors());
        }

        $empresa = Empresa::create([
            'nome' => $request->nome,
            'endereco' => $request->endereco
        ]);

        $grupo = Grupo::find($request->grupo_id);
        if(!$grupo) {
            return $this::sendErrorResponse('Grupo não encontrado', null);
        }

        $empresa->grupos()->attach($grupo);
        $empresa->save();

        return $this::sendSucessResponse($empresa, $empresa->grupos. 'Empresa criada com sucesso.', 201);
    }

    public function show(request $request) {
        $validator = Validator::make($request->all(), [
            'grupo_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $grupo = Grupo::find($request->grupo_id);
        if(!$grupo) {
            return $this::sendErrorResponse('Grupo não encontrado.', null);
        }

        if($grupo->empresas->count() == 0) {
            return $this::sendErrorResponse('Nenhuma empresa cadastrada para esse grupo');
        }

        return $this::sendSucessResponse($grupo, $grupo->empresas. 'Empresa criada com sucesso', 200);
    }

    public function update(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer', 
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'grupo_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $empresa = Empresa::find($request->id);
        if(!$empresa) {
            return $this::sendErrorResponse('Empresa não encontrada.', null);
        }

        $grupo = Grupo::find($request->grupo_id);
        if(!$grupo) {
            return $this::sendErrorResponse('Grupo não encontrado.', null);
        }

        $empresa->nome = $request->nome;
        $empresa->endereco = $request->endereco;
        $empresa->grupos()->attach($grupo);
        $empresa->save();

        return $this::sendSucessResponse($empresa, $empresa->grupos. 'Empresa alterada com sucesso.', 200);
    }

    public function destroy(request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $empresa = Empresa::find($request->id);
        if(!$empresa) {
            return $this::sendErrorResponse('Empresa não encontrada.', null);
        }

        $empresa->delete();   
        // como estamos usando o softDelete a linha não será realmente apagada
        // desse modo se quiser dá pra restaurar
        // usar forceDelete() se quiser apagar mesmo

        return $this::sendSucessResponse(null, 'Empresa deletada com sucesso.', 200);
    }

    public function removeGrupo(request $request) {
        $validator = Validator::make($request->all(), [
            'grupo_id' => 'required|integer',
            'empresa_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this::sendErrorResponse('Erros de validação.', $validator->errors());
        }

        $empresa = Empresa::find($request->empresa_id);
        $grupo = Grupo::find($request->grupo_id);
        if(!$empresa || !$grupo) {
            return $this::sendErrorResponse('Empresa ou grupo não encontrados.', null);
        }

        $empresa->grupos()->detach($grupo);
        $empresa->save();   

        return $this::sendSucessResponse(null, 'Grupo removido com sucesso.', 200);
    }

    public function index() {
        $empresas = Empresa::all();
        if($empresas->count() == 0) {
            return $this::sendErrorResponse('Não há empresas cadastradas.');
        }

        foreach($empresas as $empresa) {
            echo $this::sendSucessResponse($empresa, $empresa->grupos. 'Mostrando os grupos das empresas', 200);
        }
    }
}
