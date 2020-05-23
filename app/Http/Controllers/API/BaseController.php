<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * Método para devolver resposta de sucesso.
     * 
     * @param $dados, os dados que serão retornados para o cliente
     * @param $mensagem, mensagem
     * @param $codigo, código http a ser retornado
     * @return \Illuminate\Http\Response
     */

    public function sendSucessResponse($data, $message = 'Sucesso', $code = 200) {
        $response = [
            'data' => $data,
            'message' => $message
        ];
        return response()->json($response, $code);
    }

    /**
     * Método para devolver resposta de erro.
     * 
     * @param $erroPrincipal, mensagem de erro principal
     * @param $errosSecundários, pode ser um vetor com mais mensagens de erro
     * @param $codigo, código do erro, por padrão é 400
     * @return \Illuminate\Http\Response
     */

     public function sendErrorResponse(
            $erroPrincipal,
            $errosSecundarios = [],
            $code = 400) {
        $response = [
            'erro1' => $erroPrincipal,
            'erro2' => $errosSecundarios
        ];
        return response()->json($response, $code);
    }
}
